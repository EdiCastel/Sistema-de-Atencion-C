<?php

    include "config.php";
    $conn = getConnection();
    
    // consulta ciudadano
    $id = 0;
    $id = $_GET['id_comites']; 

      
    $sqlQuery = "SELECT *, (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad FROM comites c WHERE id_comites = '$id' AND deleted ='0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sqlQuery1 = "select ci.nombre, ci.apellido_materno, ci.apellido_paterno FROM ciudadanos ci, comites co, integrantes_comites ic WHERE ic.id_ciudadano = ci.id_ciudadano AND ic.id_comite = co.id_comites AND co.id_comites = :id_comite;";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> bindParam(':id_comite', $id);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();
?>

<h1 class="text-dark">Detalles de comité</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container p-5">
    <form>

    <div class="form-group">
        <h5>Nombre del comité </h5>  
    </div>
    <div class="form-group">
        <label><?= $row['nombre_comite']; ?></label> 
    </div>
    <div class="form-group">
        <h5>Detalles del comité </h5> 
    </div>
    <div class="form-group">
        <label><?= $row['detalles_comite']; ?></label> 
    </div>
    <div class="form-group">
        <h5>Localidad</h5> 
    </div>
    <div class="form-group"> 
        <label><?= $row['nombre_comite']; ?></label> 
    </div>
    <div class="form-group">
        <h5>Lista de integrantes </h5> 
        <label>
            <ul>
                <?php  while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) { ?>
                    <li><?= $row1['nombre'] ?> <?= $row1['apellido_paterno'] ?> <?= $row1['apellido_materno'] ?></li>
                <?php } ?>
            </ul>
        </label> 
    </div>
    <div class="form-group d-flex justify-content-center"> 
      <a href="index.php?page=Lista-de-comités" class="btn btn-primary mr-4 w-25">
        Atrás
      </a>
    </div>

    </form>
  </div>
</div>