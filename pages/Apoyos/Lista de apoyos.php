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

    $limite = 11; // Cantidad de datos a mostrar.

    $numeroPagina = 1;
    if(isset($_GET['pagenum'])) {
        $numeroPagina = $_GET['pagenum'];
    }

    // consultar cantidad de registros en tipos apoyo
    $sqlQuery = "SELECT count(*) as 'total' FROM tipos_apoyo WHERE deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRegistros = $fila['total'];

    $cantidadPaginas = ceil($totalRegistros / $limite);
    $offset = ($numeroPagina - 1) * $limite;

    // echo "Estamos viendo la pagina " . $numeroPagina;
    // echo "Total = " . $totalRegistros;
    // echo " offset = " . $offset;
    // echo " Cantidad de paginas = " . $cantidadPaginas;

    // Consultar la información de la tabla tipos apoyo.
    if ($buscando) {
        $sqlQuery = "SELECT id_tipo_apoyo, nombre_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = t.id_departamento) AS id_departamento 
            FROM tipos_apoyo t 
            WHERE nombre_apoyo LIKE '%$valorBuscado%' OR id_departamento LIKE '%$valorBuscado%' AND t.deleted = 0";
    } else {
    
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $id_departamento = $_SESSION['id_departamento'];
        
        if ($tipo_usuario == 'Administrador') {
            $sqlQuery = "SELECT id_tipo_apoyo, nombre_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = t.id_departamento) AS id_departamento 
            FROM tipos_apoyo t 
            WHERE t.deleted = 0
            LIMIT $limite OFFSET $offset";
        } else {
            $sqlQuery = "SELECT id_tipo_apoyo, nombre_apoyo, 
            (SELECT departamento FROM departamentos WHERE id_departamento = t.id_departamento) AS id_departamento 
            FROM tipos_apoyo t 
            WHERE t.deleted = 0 AND t.id_departamento = $id_departamento 
            LIMIT $limite OFFSET $offset";
        }
        
    }
    

    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    
    $cantidadResultados = $stmt -> rowCount(); 

?>

<h1 class="text-dark">Lista de apoyos</h1>

<div class="card shadow mb-4"><br>
    
    <form action="index.php?page=Lista-de-apoyos" method="POST">
    <div class="form-goup ml-4">
        <a href="index.php?page=Nuevo-tipo-apoyo" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo tipo de apoyo
        </a>
    </div>
    </form>

    <?php if($buscando == 1) { ?>

        <div class="card-body d-flex">
        <br>
        <h5>
            Resultados de la búsqueda: <b><i><?= $valorBuscado; ?></b></i> (<?= $cantidadResultados; ?> resultado(s).)
        </h5>
            <a href="index.php?page=Lista-de-apoyos" class="btn btn-sm btn-danger ml-2"><i class="fa fa-remove"></i> Limpiar búsqueda</a>
        </div>
    <?php } ?>

    <?php if($buscando  && $cantidadResultados > 0 || ! $buscando) { ?>
    <!-- Tabla para mostrar los resultados -->
    <div class="card-body">
        <div class="table-hover">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo de apoyo</th>
                        <th>Departamento</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <tr>
                            <td><?= $row['id_tipo_apoyo']; ?></td>
                            <td><?= $row['nombre_apoyo']; ?></td>
                            <td><?= $row['id_departamento']; ?></td>
                            <td>
                                <a href="index.php?page=Editar-apoyo&id_apoyo=<?= $row['id_tipo_apoyo']; ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit" aria-hidden="true"></i> Editar
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=Eliminar-apoyo&id_apoyo=<?= $row['id_tipo_apoyo']; ?>" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash" aria-hidden="true"></i> Eliminar
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
        <a class="page-link" href="index.php?page=Lista-de-apoyos&pagenum=<?= $numeroPagina-1; ?>">Anterior</a>
        </li>
    <?php for ($i=1; $i <= $cantidadPaginas ; $i++) {  ?>
        <li class="page-item <?= ($numeroPagina == $i)?"active":""; ?>"><a class="page-link" href="index.php?page=Lista-de-apoyos&pagenum=<?= $i ?>"> <?= $i ?> </a></li>
    <?php } ?>
        <li class="page-item <?= ($numeroPagina == $cantidadPaginas)?"disabled":""; ?>">
        <a class="page-link" href="index.php?page=Lista-de-apoyos&pagenum=<?= $numeroPagina+1; ?>">Siguiente</a>
        </li>
    </ul>
    </nav>

    <?php } ?>

</div>

