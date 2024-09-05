<?php

    include "config.php";
    $conn = getConnection();

    $buscando = 0;
    $valorBuscado = "";

    // busqueda....
    if(isset($_POST['busqueda'])) {
        $valorBuscado = $_POST['busqueda'];
        $buscando = 1;
    }

    $limite = 10; // Cantidad de datos a mostrar.

    $numeroPagina = 1;
    if(isset($_GET['pagenum'])) {
        $numeroPagina = $_GET['pagenum'];
    }

    // consultar cantidad de registros en solicitudes
    $sqlQuery = "SELECT count(*) as 'total' FROM solicitudes WHERE deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRegistros = $fila['total'];

    $cantidadPaginas = ceil($totalRegistros / $limite);
    $offset = ($numeroPagina - 1) * $limite;
    
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $id_departamento = $_SESSION['id_departamento'];

if ($tipo_usuario == 'Administrador') {
    // Consultar la información de la tabla solicitudes.
    if ($buscando) {
        $sqlQuery = "SELECT 
            id_solicitud, 
            tipo_solicitud, 
            fecha_registro, 
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) AS nombre_ciudadano,
            (SELECT nombre_comite FROM comites WHERE id_comites = id_comite_solicitante) AS nombre_comite,
            (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado, 
            (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) AS id_estado_solicitud 
            FROM solicitudes s 
            WHERE (id_solicitud LIKE '%$valorBuscado%' 
            OR (CASE WHEN tipo_solicitud = 0 THEN 'individual' ELSE 'colectiva' END) LIKE '%$valorBuscado%' 
            OR fecha_registro LIKE '%$valorBuscado%' 
            OR (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) LIKE '%$valorBuscado%'
            OR (SELECT nombre_comite FROM comites WHERE id_comites = id_comite_solicitante) LIKE '%$valorBuscado%'
            OR (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) LIKE '%$valorBuscado%' 
            OR (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) LIKE '%$valorBuscado%' 
            OR (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) LIKE '%$valorBuscado%')
            AND s.deleted = 0";
    } else {
        $sqlQuery = "SELECT 
            id_solicitud, 
            tipo_solicitud, 
            fecha_registro, 
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) AS nombre_ciudadano,
            (SELECT nombre_comite FROM comites WHERE id_comites = s.id_comite_solicitante) AS nombre_comite,
            (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado, 
            (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) AS id_estado_solicitud
            FROM solicitudes s 
            WHERE s.deleted = 0
            LIMIT $limite OFFSET $offset";
    }
} else {
    // Consultar la información de la tabla solicitudes.
    if ($buscando) {
        $sqlQuery = "SELECT 
            id_solicitud, 
            tipo_solicitud, 
            fecha_registro,
            (SELECT nombre FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) AS nombre_ciudadano,
            (SELECT nombre_comite FROM comites WHERE id_comites = id_comite_solicitante) AS nombre_comite,
            (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado, 
            (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) AS id_estado_solicitud 
            FROM solicitudes s 
            WHERE (id_solicitud LIKE '%$valorBuscado%' 
            OR (CASE WHEN tipo_solicitud = 0 THEN 'individual' ELSE 'colectiva' END) LIKE '%$valorBuscado%' 
            OR fecha_registro LIKE '%$valorBuscado%' 
            OR (SELECT nombre FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) LIKE '%$valorBuscado%'
            OR (SELECT nombre_comite FROM comites WHERE id_comites = id_comite_solicitante) LIKE '%$valorBuscado%'
            OR (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) LIKE '%$valorBuscado%' 
            OR (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) LIKE '%$valorBuscado%' 
            OR (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) LIKE '%$valorBuscado%')
            AND s.deleted = 0 AND s.id_departamento_asignado = $id_departamento";
    } else {
        $sqlQuery = "SELECT 
            id_solicitud, 
            tipo_solicitud, 
            fecha_registro, 
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) AS nombre_ciudadano,
            (SELECT nombre_comite FROM comites WHERE id_comites = s.id_comite_solicitante) AS nombre_comite,
            (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado, 
            (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) AS id_estado_solicitud
            FROM solicitudes s 
            WHERE s.deleted = 0 AND s.id_departamento_asignado = $id_departamento
            LIMIT $limite OFFSET $offset";
    }
}

    
    

    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    
    $cantidadResultados = $stmt -> rowCount(); 
    

?>

<h1 class="text-dark">Lista de solicitudes</h1>

<div class="card shadow mb-4"><br>
    
    <form action="index.php?page=Lista-de-solicitudes" method="POST">
    <div class="form-goup d-flex justify-content-center mx-4">
        <div class="form_group d-flex w-50 mx-auto">
            <input name="busqueda" class="form-control" type="text" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-primary w-25 mx-2" type="submit"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>
    </form>
    <?php if($buscando == 1) { ?>

    <div class="card-body d-flex">
    <br>
    <h5>
        Resultados de la búsqueda: <b><i><?= $valorBuscado; ?></b></i> (<?= $cantidadResultados; ?> resultado(s).)
    </h5>
        <a href="index.php?page=Lista-de-solicitudes" class="btn btn-sm btn-danger ml-2"><i class="fas fa-remove"></i> Limpiar búsqueda</a>
    </div>
    <?php } ?>

    <?php if($buscando  && $cantidadResultados > 0 || ! $buscando) { ?>
    <!-- Tabla para mostrar los resultados -->
    <div class="card-body">
        <div class="table-hover">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="align-bottom">
                    <tr>
                        <th class="align-top">Id</th>
                        <th class="align-top text-center">Nombre solicitante</th>
                        <th class="align-top text-center">Tipo de apoyo</th>
                        <th class="align-top">Tipo de solicitud</th>
                        <th class="align-top">Departamento</th>
                        <th class="align-top text-center">Estado</th>
                        <th class="align-top">Fecha de ingreso</th>
                        <th class="align-top text-center">Editar</th>
                        <th class="align-top text-center">Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <tr>
                            <td><?= $row['id_solicitud']; ?></td>
                            
                            <td><?php if ($row['tipo_solicitud'] == 0) { ?>
                                    <?= $row['nombre_ciudadano']; ?>
                                <?php } else { ?>
                                    <?= $row['nombre_comite']; ?>
                                <?php }  ?>
                            
                            <td><?= $row['id_tipo_apoyo']; ?></td>
                            <td><?php if ($row['tipo_solicitud'] == 0) { ?>
                                    INDIVIDUAL
                                <?php } else { ?>
                                    COLECTIVA
                                <?php }  ?>
                            </td>
                            <td><?= $row['id_departamento_asignado']; ?></td>
                            <td><?= $row['id_estado_solicitud']; ?></td>
                            <td><?= $row['fecha_registro']; ?></td>
                            <td>
                                <?php
                                    $editarLink = "";
                                    if ($row['tipo_solicitud'] == 0) {
                                        // Tipo de solicitud es INDIVIDUAL
                                        $editarLink = "index.php?page=Editar-solicitud-individual&id_solicitud=" . $row['id_solicitud'];
                                    } else {
                                        // Tipo de solicitud es COLECTIVA
                                        $editarLink = "index.php?page=Editar-solicitud-colectiva&id_solicitud=" . $row['id_solicitud'];
                                    }
                                ?>
                                <a href="<?= $editarLink; ?>"class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit" aria-hidden="true"></i> Editar
                                </a>
                            </td>
                            <td>
                                <?php
                                    $detallesLink = "";
                                    if ($row['tipo_solicitud'] == 0) {
                                        //consulta que verifica si existen evidencias asociadas a la solicitud individual
                                        $sqlQuery4 = "SELECT COUNT(*) AS count FROM evidencias e, evidencias_solicitudes es WHERE es.id_evidencia = e.id_evidencia AND es.id_solicitud = :solicitud;";
                                        $stmt4 = $conn->prepare($sqlQuery4);
                                        $stmt4->bindParam(':solicitud', $row['id_solicitud']);
                                        $stmt4->execute();
                                        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                                        $count = $row4['count'];
                                        $evidencias = ($count > 0) ? 1 : 0;
                                        // Tipo de solicitud es INDIVIDUAL
                                        $detallesLink = "index.php?page=Detalles-solicitud-individual&id=" . $row['id_solicitud']. "&id_estado_solicitud=" . $row['id_estado_solicitud'] . "&evidencias=" . $evidencias;
                                    } else {
                                        //consulta que verifica si existen evidencias asociadas a la solicitud colectiva
                                        $sqlQuery4 = "SELECT COUNT(*) AS count FROM evidencias e, evidencias_solicitudes es WHERE es.id_evidencia = e.id_evidencia AND es.id_solicitud = :solicitud;";
                                        $stmt4 = $conn->prepare($sqlQuery4);
                                        $stmt4->bindParam(':solicitud', $row['id_solicitud']);
                                        $stmt4->execute();
                                        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                                        $count = $row4['count'];
                                        $evidencias = ($count > 0) ? 1 : 0;
                                        // Tipo de solicitud es COLECTIVA
                                        $detallesLink = "index.php?page=Detalles-solicitud-colectiva&id=" . $row['id_solicitud']. "&id_estado_solicitud=" . $row['id_estado_solicitud']. "&evidencias=" . $evidencias;
                                    }
                                ?>
                                <a href="<?= $detallesLink ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i> Detalles
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } else { ?>

    <div class="card-body">
        <div class="alert alert-warning">
            No se encontraron resultados para la búsqueda.
        </div>
    </div>

    <?php } ?>

    <?php if($cantidadPaginas >= 2) {  ?> 
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($numeroPagina == 1)?"disabled":""; ?>">
        <a class="page-link" href="index.php?page=Lista-de-solicitudes&pagenum=<?= $numeroPagina-1; ?>">Anterior</a>
        </li>
    <?php for ($i=1; $i <= $cantidadPaginas ; $i++) {  ?>
        <li class="page-item <?= ($numeroPagina == $i)?"active":""; ?>"><a class="page-link" href="index.php?page=Lista-de-solicitudes&pagenum=<?= $i ?>"> <?= $i ?> </a></li>
    <?php } ?>
        <li class="page-item <?= ($numeroPagina == $cantidadPaginas)?"disabled":""; ?>">
        <a class="page-link" href="index.php?page=Lista-de-solicitudes&pagenum=<?= $numeroPagina+1; ?>">Siguiente</a>
        </li>
    </ul>
    </nav>
    <?php } ?>
</div>

