<?php
    //Verifica que el usuario sea administrador y en caso contrario, redirige al inicio de la pagina para evitar que se accedan a la 
    //pagina usuarios no autorizados ya que esta pagina solo tendra acceso el administrador.
    if(!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'Administrador') {
        echo "<script>window.location.href = 'index.php';</script>";
    }

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

    // consultar cantidad de registros en usuarios
    $sqlQuery = "SELECT count(*) as 'total' FROM usuarios WHERE deleted = '0'";
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

    // Consultar la información de la tabla usuarios.
    if ($buscando) {
        $sqlQuery = "SELECT 
            id_usuario, nombre, 
            apellido_paterno, 
            apellido_materno, 
            usuario, 
            enabled, 
            (SELECT departamento FROM departamentos WHERE id_departamento = u.id_departamento) AS id_departamento,
            (SELECT nombre FROM tipos_usuario WHERE id_tipo_usuario = u.tipo_usuario) AS id_tipo_usuario 
            FROM usuarios u 
            WHERE concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$valorBuscado%'
            OR (SELECT departamento FROM departamentos WHERE id_departamento = u.id_departamento) LIKE '%$valorBuscado%'
            OR (SELECT nombre FROM tipos_usuario WHERE id_tipo_usuario = u.tipo_usuario) LIKE '%$valorBuscado%'
            OR usuario LIKE '%$valorBuscado%'
            AND u.deleted = 0";
    } else {
        $sqlQuery = "SELECT 
            id_usuario, nombre, 
            apellido_paterno, 
            apellido_materno, 
            usuario, 
            enabled, 
            (SELECT departamento FROM departamentos WHERE id_departamento = u.id_departamento) AS id_departamento, 
            (SELECT nombre FROM tipos_usuario WHERE id_tipo_usuario = u.tipo_usuario) AS id_tipo_usuario 
            FROM usuarios u 
            WHERE u.deleted = 0
            LIMIT $limite OFFSET $offset";
    }
    

    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    
    $cantidadResultados = $stmt -> rowCount(); 

?>


<h1 class="text-dark">Lista de usuarios</h1>

<div class="card shadow mb-4"><br>
    
    <form action="index.php?page=Lista-de-usuarios" method="POST">
    <div class="form-goup d-flex justify-content-end mx-4" >
        <a href="index.php?page=Nuevo-usuario" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo usuario
        </a>
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
        <a href="index.php?page=Lista-de-usuarios" class="btn btn-sm btn-danger ml-2"><i class="fas fa-remove"></i> Limpiar búsqueda</a>
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
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Habilitado</th>
                        <th>Departamento</th>
                        <th>Grupo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <tr>
                            <td><?= $row['id_usuario']; ?></td>
                            <td><?= $row['nombre']." ". $row['apellido_paterno']." ". $row['apellido_materno']; ?></td>
                            <td><?= $row['usuario']; ?></td>
                            <td>
                                <?php if ($row['enabled']) { ?>
                                    <i class="fas fa-circle text-success d-flex justify-content-center"></i>
                                <?php } else { ?>
                                    <i class="fas fa-circle text-danger d-flex justify-content-center"></i>
                                <?php }  ?>
                            </td>
                            <td><?= $row['id_departamento']; ?></td>
                            <td><?= $row['id_tipo_usuario']; ?></td>
                            <td>
                                <a href="index.php?page=Editar-usuario&id_usuario=<?= $row['id_usuario']; ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Editar
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=Eliminar-usuario&id_usuario=<?= $row['id_usuario']; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Eliminar
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
            <a class="page-link" href="index.php?page=Lista-de-usuarios&pagenum=<?= $numeroPagina-1; ?>">Anterior</a>
            </li>
        <?php for ($i=1; $i <= $cantidadPaginas ; $i++) {  ?>
            <li class="page-item <?= ($numeroPagina == $i)?"active":""; ?>"><a class="page-link" href="index.php?page=Lista-de-usuarios&pagenum=<?= $i ?>"> <?= $i ?> </a></li>
        <?php } ?>
            <li class="page-item <?= ($numeroPagina == $cantidadPaginas)?"disabled":""; ?>">
            <a class="page-link" href="index.php?page=Lista-de-usuarios&pagenum=<?= $numeroPagina+1; ?>">Siguiente</a>
            </li>
        </ul>
        </nav>
    <?php } ?>
</div>
