<?php

    include "../../config.php";
    $conn = getConnection();

    $idDepto = $_GET['depto'];
    $idTipoApoyo = $_GET['tipo'];

    //Consulta 1. Cantidad de solicitudes para el tipo de apoyo.
    $sqlCantidadSolicitudes = "SELECT t.nombre_apoyo, (SELECT COUNT(*) FROM solicitudes s WHERE s.id_tipo_apoyo = t.id_tipo_apoyo) AS 'cantidad' FROM tipos_apoyo t WHERE t.id_tipo_apoyo = :idTipoApoyo;";
    $stmt1 = $conn->prepare($sqlCantidadSolicitudes);
    $stmt1 -> bindParam(':idTipoApoyo', $idTipoApoyo);
    $stmt1 -> execute();
    $row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
    $nombreApoyo = $row1['nombre_apoyo'];
    $cantidad = $row1['cantidad'];

    //Consulta 2. Cantidad de apoyo por localidades de procedencia de la solicitud.
    $sqlCantidadPorLocalidad = "SELECT IF(sol.tipo_solicitud = 0, (SELECT loc.nombre FROM localidades loc, ciudadanos c WHERE c.id_localidad = loc.id_localidad AND c.id_ciudadano = sol.id_ciudadano), (SELECT loc.nombre FROM localidades loc, comites c WHERE c.id_localidad = loc.id_localidad AND c.id_comites = sol.id_comite_solicitante)) as 'Localidad', COUNT(*) as'Cantidad' FROM solicitudes sol WHERE sol.id_tipo_apoyo = :idTipoApoyo GROUP BY Localidad;";
    $stmt2 = $conn->prepare($sqlCantidadPorLocalidad);
    $stmt2 -> bindParam(':idTipoApoyo', $idTipoApoyo);
    $stmt2 -> execute();
    $cantidadesLocalidad = [];
    while($row = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
        $cantidadesLocalidad[$row['Localidad']] = $row['Cantidad'];
    }

    //Consulta 3. Cantidad de apoyo filtradas por mes.
    $anio = 2024;
    $sqlCantidadPorMes = "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad_registros FROM solicitudes s WHERE s.id_tipo_apoyo = :tipo AND YEAR(fecha_registro) = :anio GROUP BY MONTH(fecha_registro) ORDER BY mes;";
    $stmt3 = $conn->prepare($sqlCantidadPorMes);
    $stmt3 -> bindParam(':anio', $anio);
    $stmt3 -> bindParam(':tipo', $idTipoApoyo);
    $stmt3 -> execute();
    $cantidadesMes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    while($row = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
        $cantidadesMes[$row['mes']] = $row['cantidad_registros'];
    }
    array_shift($cantidadesMes);


    // $sqlQuery1 = "SELECT * FROM tipos_apoyo WHERE id_departamento = :id AND deleted = 0;";
    // $stmt1 = $conn->prepare($sqlQuery1);
    // $stmt1 -> bindParam(':id', $idDepto);
    // $stmt1 -> execute();

    // while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
    //     array_push($tipos, $row);
    // }

?>

<div class="container-fluid">

    <br>

    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-4">Cantidad de solicitudes de <b><?= $nombreApoyo; ?></b> por localidad:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th>Localidad</th>
                                <th>Solicitudes registradas</th>
                            </tr>
                            <?php foreach ($cantidadesLocalidad as $localidad => $cantidad) { ?>
                            <tr>
                                <td><?= $localidad; ?></td>
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
                        <h5 class="mb-4">Cantidad de solicitudes de <b><?= $nombreApoyo; ?></b> clasificadas por mes de registro:</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th>Mes</th>
                                <th>Solicitudes</th>
                                <th>Mes</th>
                                <th>Solicitudes</th>
                            </tr>
                            <tr><td>Enero</td><td><?= $cantidadesMes[0]; ?></td><td>Julio</td><td><?= $cantidadesMes[6]; ?></td></tr>
                            <tr><td>Febrero</td><td><?= $cantidadesMes[1]; ?></td><td>Agosto</td><td><?= $cantidadesMes[7]; ?></td></tr>
                            <tr><td>Marzo</td><td><?= $cantidadesMes[2]; ?></td><td>Septiembre</td><td><?= $cantidadesMes[8]; ?></td></tr>
                            <tr><td>Abril</td><td><?= $cantidadesMes[3]; ?></td><td>Octubre</td><td><?= $cantidadesMes[9]; ?></td></tr>
                            <tr><td>Mayo</td><td><?= $cantidadesMes[4]; ?></td><td>Noviembre</td><td><?= $cantidadesMes[10]; ?></td></tr>
                            <tr><td>Junio</td><td><?= $cantidadesMes[5]; ?></td><td>Diciembre</td><td><?= $cantidadesMes[11]; ?></td></tr>
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

        var ctx = document.getElementById('grafica1').getContext('2d');
        var ctx2 = document.getElementById('grafica2').getContext('2d');

        // Datos para la gráfica
        var etiquetas = <?php echo json_encode(array_keys($cantidadesLocalidad)); ?>;
        var valores = <?php echo json_encode(array_values($cantidadesLocalidad)); ?>;
        console.log(etiquetas);

        var datos = {
            labels: etiquetas,
            datasets: [{
                label: 'Comunidad',
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de fondo de las barras
                borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
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
                display: false
            }
        };

        // Crea la instancia de la gráfica de barras
        var miGrafica = new Chart(ctx, {
            type: 'bar', // Tipo de gráfica
            data: datos,
            options: opciones
        });

        var valoresFechas = <?php echo json_encode(array_values($cantidadesMes)); ?>;

        var datos2 = {
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
        var opciones2 = {
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

        // Crea la instancia de la gráfica de barras
        var miGrafica = new Chart(ctx2, {
            type: 'line', // Tipo de gráfica
            data: datos2,
            options: opciones2
        });


</script>
