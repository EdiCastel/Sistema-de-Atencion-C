<?php

    include "config.php";
    $conn = getConnection();

    //Consulta 1. solicitudes por tipo de solicitud.
    $sql1 = "SELECT tipo_solicitud, count(*) as cantidad from solicitudes group by tipo_solicitud;";
    $stmt1 = $conn->prepare($sql1);
    $stmt1 -> execute();
    $tiposSolicitud = [];
    while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
        $tiposSolicitud[$row['tipo_solicitud']] = $row['cantidad'];
    }

    // solicitudes por departamento
    $sql2 = "SELECT d.departamento, count(*) as 'cantidad' from solicitudes s, departamentos d where d.id_departamento = s.id_departamento_asignado group by s.id_departamento_asignado;";
    $stmt2 = $conn->prepare($sql2);
    $stmt2 -> execute();
    $solicitudesDepartamento = [];
    while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
        $solicitudesDepartamento[$row2['departamento']] = $row2['cantidad'];
    }

    //cantidad de ciudadanos
    $stmt3 = $conn -> prepare("SELECT count(*) as 'cuenta' from ciudadanos where deleted = 0;");
    $stmt3 -> execute();
    $ciudadanosRegistrados = ($stmt3 -> fetch(PDO::FETCH_ASSOC))['cuenta'];

    //cantidad de comités
    $stmt3 = $conn -> prepare("SELECT count(*) as 'cuenta' from comites where deleted = 0;");
    $stmt3 -> execute();
    $comitesRegistrados = ($stmt3 -> fetch(PDO::FETCH_ASSOC))['cuenta'];

    // consulta de solicitudes por mes
    $anio = 2024;
    $sqlCantidadPorMes = "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad_registros FROM solicitudes s WHERE YEAR(fecha_registro) = :anio GROUP BY MONTH(fecha_registro) ORDER BY mes;";
    $stmt4 = $conn->prepare($sqlCantidadPorMes);
    $stmt4 -> bindParam(':anio', $anio);
    $stmt4 -> execute();
    $cantidadesMes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    while($row = $stmt4 -> fetch(PDO::FETCH_ASSOC)){
        $cantidadesMes[$row['mes']] = $row['cantidad_registros'];
    }
    array_shift($cantidadesMes); //quita el primr elemento del array


?>
<div class="container px-4">
<h1>Inicio</h1>
</div>
<div class="container p-4" style="">
    <div class="row h-100">
        <div class="col-3">
            <div class="card text-dark borde-azul mb-3 h-100 shadow">
                <div class="card-header text-center header-azul"><i class="fas fa-folder-open"></i> Solicitudes Registradas</div>
                <div class="card-body">
                    <h1 class="card-title text-center texto-azul"><?= $tiposSolicitud[0] + $tiposSolicitud[1]; ?></h1>
                    <hr>
                    <canvas id="grafica1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-3 h-100">
            <div class="card text-dark borde-azul h-50 shadow">
                <div class="card-header text-center header-azul"><i class="fas fa-user"></i> Ciudadanos Registrados</div>
                <div class="card-body">
                    <h1 class="card-title text-center texto-azul"><?= $ciudadanosRegistrados; ?></h1>
                </div>
            </div><br>
            
            <div class="card text-dark borde-azul h-50 shadow">
                <div class="card-header header-azul text-center"><i class="fas fa-users"></i> Comités Registrados</div>
                <div class="card-body">
                    <h1 class="card-title text-center texto-azul"><?= $comitesRegistrados; ?></h1>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card text-dark borde-azul mb-3 h-100 shadow">
                <div class="card-header header-azul text-center"><i class="fas fa-area-chart"></i> Solicitudes por Departamento</div>
                <div class="card-body">
                    <canvas id="grafica2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card text-dark borde-azul shadow">
                <div class="card-header text-center header-azul"><i class="fas fa-calendar"></i> Solicitudes registradas mensualmente</div>
                <div class="p-4" style="">
                    <canvas id="grafica3" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function generateWebColors(opacity) {
        // Paleta de colores web predefinida
        const webColors = [
            `rgba(255, 99, 132, ${opacity})`,
            `rgba(54, 162, 235, ${opacity})`,
            `rgba(255, 206, 86, ${opacity})`,
            `rgba(75, 192, 192, ${opacity})`,
            `rgba(153, 102, 255, ${opacity})`,
            `rgba(255, 159, 64, ${opacity})`,
            `rgba(244, 67, 54, ${opacity})`,
            `rgba(33, 150, 243, ${opacity})`,
            `rgba(255, 235, 59, ${opacity})`,
            `rgba(121, 85, 72, ${opacity})`,
            `rgba(108, 117, 125, ${opacity})`,
            `rgba(96, 125, 139, ${opacity})`,
            `rgba(77, 182, 172, ${opacity})`,
            `rgba(255, 138, 101, ${opacity})`,
            `rgba(255, 193, 7, ${opacity})`,
            `rgba(205, 220, 57, ${opacity})`,
            `rgba(139, 195, 74, ${opacity})`,
            `rgba(100, 181, 246, ${opacity})`,
            `rgba(197, 202, 233, ${opacity})`,
            `rgba(255, 112, 67, ${opacity})`
        ];

        return webColors;
    }

    function generateColorArray(quantity, opacity) {

        const webColors = generateWebColors(opacity);
        const colorArray = [];

        for (let i = 0; i < quantity; i++) {
            colorArray.push(webColors[i % webColors.length]); // Ciclo para reutilizar colores si se solicitan más de los disponibles
        }

        return colorArray;
    }

    var ctx = document.getElementById('grafica1').getContext('2d');
    var ctx2 = document.getElementById('grafica2').getContext('2d');
    var ctx3 = document.getElementById('grafica3').getContext('2d');

    // Datos para la gráfica
    var valores = <?php echo json_encode(array_values($tiposSolicitud)); ?>;
    var coloresFondo = [ 'rgba(43, 153, 156, 0.2)', 'rgba(178, 197, 96, 0.2)' ]; // array de colores con opacidad de 0.2, la cantidad la determina el tamaño del array en php
    var coloresBorde =  [ 'rgba(43, 153, 156, 1)', 'rgba(178, 197, 96, 1)' ];; // array de N colores con opacidad de 1

    var datos = {
        labels: [ 'Individuales', 'Colectivas' ],
        datasets: [{
            label: "Tipo de solicitud",
            backgroundColor: coloresFondo, // Color de fondo de las barras
            borderColor: coloresBorde, // Color del borde de las barras
            borderWidth: 1, // Ancho del borde de las barras
            data: valores// Valores de las barras
        }]
    };

    // Configuración de la gráfica
    var opciones = {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        legend: {
            display: true,
            position: 'left'
        }
    };

    $(document).ready(function(){
        // Crea la instancia de la gráfica de barras
        var miGrafica = new Chart(ctx, {
            type: 'pie', // Tipo de gráfica
            data: datos,
            options: opciones
        });

    });
     /// grafica 2:-----------------------------------

     var etiquetas2 = <?php echo json_encode(array_keys($solicitudesDepartamento)); ?>;
    var valores2 = <?php echo json_encode(array_values($solicitudesDepartamento)); ?>;

    var coloresFondo2 = generateColorArray(<?= sizeof($solicitudesDepartamento); ?>,0.2); // array de colores con opacidad de 0.2, la cantidad la determina el tamaño del array en php
    var coloresBorde2 = generateColorArray(<?= sizeof($solicitudesDepartamento); ?>,1); // array de N colores con opacidad de 1

    var datos2 = {
        labels: etiquetas2,
        datasets: [{
            label: 'Estado',
            backgroundColor: coloresFondo2, // Color de fondo de las barras
            borderColor: coloresBorde2, // Color del borde de las barras
            borderWidth: 1, // Ancho del borde de las barras
            data: valores2 // Valores de las barras
        }]
    };

    // Configuración de la gráfica
    var opciones2 = {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        legend: {
            display: true,
            position: 'left'
        }
    };

    $(document).ready(function(){
        // Crea la instancia de la gráfica de barras
        var miGrafica2 = new Chart(ctx2, {
            type: 'doughnut', // Tipo de gráfica
            data: datos2,
            options: opciones2
        });
    });

    // grafico 3

    var valoresFechas = <?php echo json_encode(array_values($cantidadesMes)); ?>;

    var datos3 = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Mes',
                backgroundColor: 'rgba(127, 0, 178, 0.2)', // Color de fondo de las barras
                borderColor: 'rgba(127, 0, 178, 1)', // Color del borde de las barras
                borderWidth: 1, // Ancho del borde de las barras
                data: valoresFechas // Valores de las barras
            }]
        };

        // Configuración de la gráfica
        var opciones3 = {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    barPercentage: 0.2
                }
            },
            legend: {
                display: false
            }
        };

        

    $(document).ready(function(){
        // Crea la instancia de la gráfica de barras
        var miGrafica = new Chart(ctx3, {
            type: 'line', // Tipo de gráfica
            data: datos3,
            options: opciones3
        });

    });
    

</script>
