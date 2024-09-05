<?php

    include "../../config.php";
    $conn = getConnection();

    $idDepto = $_GET['depto'];

    //Nombre del departamento
    $sql = "SELECT departamento FROM departamentos WHERE id_departamento = :idDepto LIMIT 1;";
    $stmt = $conn -> prepare($sql);
    $stmt -> bindParam(':idDepto', $idDepto);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    $nombreDepartamento = $row['departamento'];

    //Consulta 1. Cantidad de solicitudes para el tipo de apoyo.
    $sql1 = "SELECT ta.nombre_apoyo, (SELECT count(*) FROM solicitudes s WHERE s.id_tipo_apoyo = ta.id_tipo_apoyo) as 'Cantidad' FROM tipos_apoyo ta WHERE ta.id_departamento = :departamento;";
    $stmt1 = $conn->prepare($sql1);
    $stmt1 -> bindParam(':departamento', $idDepto);
    $stmt1 -> execute();
    $tiposApoyo = [];
    while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
        $tiposApoyo[$row1['nombre_apoyo']] = $row1['Cantidad'];
    }

    //Consulta 2. Clasificación de la peticiones por estado.
    $sql2 = "SELECT e.nombre, (select count(*) from solicitudes s where s.id_estado_solicitud = e.id_estado AND s.id_departamento_asignado = :departamento) as 'cantidad' from estados e;";
    $stmt2 = $conn->prepare($sql2);
    $stmt2 -> bindParam(':departamento', $idDepto);
    $stmt2 -> execute();
    $estados = [];
    while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)) {
        $estados[$row2['nombre']] = $row2['cantidad'];
    }


?>

<div class="container-fluid">

    <br>

    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-4">Tipos de solicitud y cantidad recibidas en el departamento de <b><?= $nombreDepartamento; ?></b>:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th>Tipo de solicitud</th>
                                <th>Solicitudes registradas</th>
                            </tr>
                            <?php foreach ($tiposApoyo as $nombre => $cantidad) { ?>
                            <tr>
                                <td><?= $nombre; ?></td>
                                <td><?= $cantidad; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="col">
                        <canvas id="grafica1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br>

    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-4">Estado de las solicitudes recibidas en <b><?= $nombreDepartamento; ?></b>:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th>Estado</th>
                                <th>Cantidad</th>
                            </tr>
                            <?php foreach ($estados as $nombre => $cantidad) { ?>
                            <tr>
                                <td><?= $nombre; ?></td>
                                <td><?= $cantidad; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="col">
                        <canvas id="grafica2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

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

    // Datos para la gráfica
    var etiquetas = <?php echo json_encode(array_keys($tiposApoyo)); ?>;
    var valores = <?php echo json_encode(array_values($tiposApoyo)); ?>;
    var coloresFondo = generateColorArray(<?= sizeof($tiposApoyo); ?>,0.2); // array de colores con opacidad de 0.2, la cantidad la determina el tamaño del array en php
    var coloresBorde = generateColorArray(<?= sizeof($tiposApoyo); ?>,1); // array de N colores con opacidad de 1

    var datos = {
        labels: etiquetas,
        datasets: [{
            label: 'Tipo de Apoyo',
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

    // Crea la instancia de la gráfica de barras
    var miGrafica = new Chart(ctx, {
        type: 'doughnut', // Tipo de gráfica
        data: datos,
        options: opciones
    });

    /// grafica 2:-----------------------------------

    var etiquetas2 = <?php echo json_encode(array_keys($estados)); ?>;
    var valores2 = <?php echo json_encode(array_values($estados)); ?>;

    var coloresFondo2 = generateColorArray(<?= sizeof($estados); ?>,0.2); // array de colores con opacidad de 0.2, la cantidad la determina el tamaño del array en php
    var coloresBorde2 = generateColorArray(<?= sizeof($estados); ?>,1); // array de N colores con opacidad de 1

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

    // Crea la instancia de la gráfica de barras
    var miGrafica2 = new Chart(ctx2, {
        type: 'doughnut', // Tipo de gráfica
        data: datos2,
        options: opciones2
    });

</script>
