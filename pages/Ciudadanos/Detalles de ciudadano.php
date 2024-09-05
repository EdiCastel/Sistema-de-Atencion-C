<?php

    include "config.php";
    $conn = getConnection();
    
    // consulta ciudadano
    $id = 0;
    $id = $_GET['id_ciudadano']; 

    //consulta para mostrar los datos del ciudadano 
    $sqlQuery = "SELECT *, (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad FROM ciudadanos c WHERE id_ciudadano = '$id' AND deleted ='0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Se crea una lista para guardar los id's de los comités
    $comites = array();
    // Consulta para ver el historial de solicitudes individuales
    $sqlQuery1 = "SELECT
      id_solicitud,
      folio_seguimiento,
      tipo_solicitud,
      fecha_registro,
      id_comite_solicitante,
      (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo,
      (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado,
      (SELECT nombre FROM estados WHERE id_estado= s.id_estado_solicitud) AS id_estado_solicitud,
      (SELECT fecha FROM historial_estados WHERE id_solicitud = s.id_solicitud) AS fecha
      FROM solicitudes s
      WHERE
      id_ciudadano = :id_ciudadano AND tipo_solicitud = '0'";
      $stmt1 = $conn -> prepare($sqlQuery1);
      $stmt1 -> bindParam(':id_ciudadano', $id);
      $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
      $stmt1 -> execute();
      $comites[] = $stmt1->fetchAll();

    //Comprueba si existen solicitudes del cuidadano en algun comite
    $sqlQuery2 = "SELECT
      id_comite
      FROM integrantes_comites
      WHERE
      id_ciudadano = :id_ciudadano";
      $stmt2 = $conn -> prepare($sqlQuery2);
      $stmt2 -> bindParam(':id_ciudadano', $id);
      $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
      $stmt2 -> execute();

    //se pasan los id de los comites a los que pertenece
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $sqlQuery3 = "SELECT 
      id_solicitud,
      folio_seguimiento,
      tipo_solicitud,
      fecha_registro,
      id_comite_solicitante,
      (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo LIMIT 1) AS id_tipo_apoyo,
      (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado LIMIT 1) AS id_departamento_asignado,
      (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud LIMIT 1) AS id_estado_solicitud,
      (SELECT fecha FROM historial_estados WHERE id_solicitud = s.id_solicitud LIMIT 1) AS fecha
      FROM solicitudes s
      WHERE
      id_comite_solicitante = :id_comite AND tipo_solicitud = '1'";
      $stmt3 = $conn -> prepare($sqlQuery3);
      $stmt3 -> bindParam(':id_comite', $row2['id_comite']);
      $stmt3 -> setFetchMode(PDO::FETCH_ASSOC);
      $stmt3 -> execute();
      $comites[] = $stmt3->fetchAll();
    }
?>

<h1 class="text-dark">Detalles de ciudadano</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container p-5">
    <form>

    <table class="table table-borderless d-flex justify-content-start w-auto">
      <tr>
        <td><h5>Nombre: </h5> </td>
        <td><label class="h6"><?= $row['nombre']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Apellido paterno: </h5> </td>
        <td><label class="h6"><?= $row['apellido_paterno']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Apellido materno: </h5> </td>
        <td><label class="h6"><?= $row['apellido_materno']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Sexo: </h5> </td>
        <td><label class="h6"><?= $row['sexo']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>CURP: </h5>  </td>
        <td><label class="h6"><?= $row['curp']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Sección electoral: </h5> </td>
        <td><label class="h6"><?= $row['seccion_electoral']; ?></label> </td>
      </tr>
      <tr>
        <td><h5 >Localidad: </h5> </td>
        <td><label class="h6"><?= $row['id_localidad']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Dirección: </h5> </td>
        <td><label class="h6"><?= $row['direccion']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Referencia: </h5> </td>
        <td><label class="h6"><?= $row['referencia']; ?></label> </td>
      </tr>
      <tr>
        <td><h5>Teléfono: </h5> </td>
        <td><label class="h6"><?= $row['telefono']; ?></label> </td>
      </tr>
    </table><br>
    
    <label class="h1 text-dark"> Historial de solicitudes</label>
    <table class="table table-bordered">
        <tr>
          <td><label class="h6 text-dark">Tipo de apoyo </label> </td>
          <td><label class="h6 text-dark">Tipo de solicitud </label> </td>
          <td><label class="h6 text-dark">Departamento </label> </td>
          <td><label class="h6 text-dark">Fecha de ingreso </label> </td>
          <td><label class="h6 text-dark">Estado de la solicitud </label> </td>
          <td><label class="h6 text-dark">Fecha de cambio </label> </td>
        </tr>
        <?php  

        foreach ($comites as $comite) { 
          foreach ($comite as $res) {
          ?>
        <tr>
          <td><label class="h6"><?= $res['id_tipo_apoyo']; ?></label> </td>
          <td><label class="h6"><?= $res['tipo_solicitud'] == 0 ? 'INDIVIDUAL' : 'COLECTIVA' ?></label></td>
          <td><label class="h6"><?= $res['id_departamento_asignado']; ?></label> </td>
          <td><label class="h6"><?= $res['fecha_registro']; ?></label> </td>
          <!-- Debe cambiarse a la fecha en la que se reistre un cambio en la tabla historial estados este campo es provicional -->
          <td><label class="h6"><?= $res['id_estado_solicitud']; ?></label> </td>
          <td><label class="h6"><?= $res['fecha']; ?></label> </td>
        </tr>
        <?php
          }
        } 

       ?>
    </table><br><br>
    

    <div class="form-group d-flex justify-content-center"> 
      <a href="index.php?page=Lista-de-ciudadanos" class="btn btn-primary mr-4 w-25">
        Atrás
      </a>
    </div>

    </form>
  </div>
</div>