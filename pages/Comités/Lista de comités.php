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

    // consultar cantidad de registros en comités
    $sqlQuery = "SELECT count(*) as 'total' FROM comites WHERE deleted = '0'";
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

    // Consultar la información de la tabla comités.
    if ($buscando) {
        $sqlQuery = "SELECT 
            id_comites, 
            nombre_comite, 
            (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad 
            FROM comites c 
            WHERE id_comites LIKE '%$valorBuscado%'
            OR nombre_comite LIKE '%$valorBuscado%'
            OR (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad)  LIKE '%$valorBuscado%'
            AND c.deleted = 0";
    } else {
        $sqlQuery = "SELECT 
            id_comites, 
            nombre_comite, 
            (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad 
            FROM comites c 
            WHERE c.deleted = 0
            LIMIT $limite OFFSET $offset";
    }
    

    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    
    $cantidadResultados = $stmt -> rowCount(); 

?>


<h1 class="text-dark">Lista de comités</h1>

<div class="card shadow mb-4"><br>
    
    <form action="index.php?page=Lista-de-comités" method="POST">
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
            <a href="index.php?page=Lista-de-comités" class="btn btn-sm btn-danger ml-2"><i class="fas fa-remove"></i> Limpiar búsqueda</a>
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
                        <th>Nombre comité</th>
                        <th>Localidad</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <tr>
                            <td><?= $row['id_comites']; ?></td>
                            <td><?= $row['nombre_comite']; ?></td>
                            <td><?= $row['id_localidad']; ?></td>
                            <td>
                                <a href="index.php?page=Detalles-de-comité&id_comites=<?= $row['id_comites']; ?>" class="btn btn-sm btn-outline-info">
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
        <a class="page-link" href="index.php?page=Lista-de-comités&pagenum=<?= $numeroPagina-1; ?>">Anterior</a>
        </li>
    <?php for ($i=1; $i <= $cantidadPaginas ; $i++) {  ?>
        <li class="page-item <?= ($numeroPagina == $i)?"active":""; ?>"><a class="page-link" href="index.php?page=Lista-de-comités&pagenum=<?= $i ?>"> <?= $i ?> </a></li>
    <?php } ?>
        <li class="page-item <?= ($numeroPagina == $cantidadPaginas)?"disabled":""; ?>">
        <a class="page-link" href="index.php?page=Lista-de-comités&pagenum=<?= $numeroPagina+1; ?>">Siguiente</a>
        </li>
    </ul>
    </nav>
    <?php } ?>
</div>

