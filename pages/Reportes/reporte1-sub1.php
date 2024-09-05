<?php

    include "../../config.php";
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

?>


<div class="container-fluid">

    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-4">Solicitudes registradas en <b>Todos los departamentos</b>:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <td>Solicitudes individuales:</td>
                                <td><?= $tiposSolicitud[0]; ?></td>
                            </tr>
                            <tr>
                                <td>Solicitudes colectivas:</td>
                                <td><?= $tiposSolicitud[1]; ?></td>
                            </tr>
                            <tr>
                                <td><b>Total de solicitudes</b></td>
                                <td><b><?= $tiposSolicitud[0] + $tiposSolicitud[1]; ?></b></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <canvas id="grafica1" style=""></canvas>
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
                        <h5 class="mb-4">Cantidad de solicitudes registradas clasificadas por <b>Departamento</b>:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th>Departamento</th>
                                <th>Solicitudes</th>
                            </tr>
                            <?php foreach($solicitudesDepartamento as $depto => $cantidad){ ?>
                            <tr>
                                <td><?= $depto; ?></td>
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

    // Crea la instancia de la gráfica de barras
    var miGrafica = new Chart(ctx, {
        type: 'pie', // Tipo de gráfica
        data: datos,
        options: opciones
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

    // Crea la instancia de la gráfica de barras
    var miGrafica2 = new Chart(ctx2, {
        type: 'pie', // Tipo de gráfica
        data: datos2,
        options: opciones2
    });

</script>
