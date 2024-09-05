<?php

    include "config.php";
    $conn = getConnection();
    
    // consulta ciudadano
    $id = 0;
    $id = $_GET['id_apoyo']; 
      
    $sqlQuery = "SELECT *,
    (SELECT departamento FROM departamentos WHERE id_departamento = t.id_departamento) AS departamento 
    FROM tipos_apoyo t 
    WHERE id_tipo_apoyo = '$id' AND deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sqlQuery1 = "SELECT * FROM departamentos WHERE deleted = '0'";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();
    
?>

<h1 class="text-dark">Editar apoyo</h1>

<div class="card shadow mb-4">
  <div class="container p-5">
    <form id="form-editar-apoyo" method="POST">
      <div class="form-group">
          <label>Nombre del apoyo</label>
          <input value="<?= $row['nombre_apoyo']; ?>" type="text" class="form-control" id="nombre_apoyo">
      </div>
      
      <?php
      if ($_SESSION['tipo_usuario'] == 'Administrador') {
      ?>
      <div class="form-group">
        <label>Departamento</label>
        <select id="id_departamento" class="form-control">
          <option value="<?= $row['id_departamento']; ?>" selected><?= $row['departamento']; ?></option>
          <?php 
            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <option value="<?= $row1['id_departamento']; ?>"><?= $row1['departamento']; ?></option>
          <?php 
          }
          ?>
        </select>
      </div>
      <?php
      } else {
      ?>
      <div class="form-group">
          <label for="">Departamento</label>    
          <input type="text" class="form-control" value="<?= $_SESSION['departamento']; ?>" readonly>
          <input type="hidden" id="id_departamento" value="<?= $_SESSION['id_departamento']; ?>">
      </div>
      <?php
      }
      ?>

      <div class="form-group d-flex justify-content-center"> 
        <a href="index.php?page=Lista-de-apoyos" class="btn btn-primary mr-5 w-25">
          Cancelar
        </a>
        <button href="#" class="btn btn-success mr-5 w-25" type="submit" id="editar-apoyo">
          Actualizar tipo de apoyo  <i class="fas fa-edit"></i> 
        </button>
      </div>

    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
      $("#form-editar-apoyo").submit(function (e) {
          e.preventDefault();

          // Obtener datos del formulario
          var id_tipo_apoyo = <?php echo $id; ?>;
          var nombre_apoyo = $("#nombre_apoyo").val();
          var id_departamento = $("#id_departamento").val();
         

          // Enviar datos al servidor mediante AJAX
          $.ajax({
              type: "POST",
              url: "pages/Formularios/editar_apoyo.php",
              data: {
                  id_tipo_apoyo: id_tipo_apoyo,
                  nombre_apoyo: nombre_apoyo,
                  id_departamento: id_departamento
              },
              success: function (response) {
              console.log(response);
                  Swal.fire({
                    title: 'Actualización Exitosa',
                    text: 'Datos de apoyo actualizados correctamente.',
                    icon: 'success',
                    confirmButtonColor: "#20c997",
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                    customClass: {
                      icon: 'fa-lg'
                    },
                    iconHtml: '<i class="fas fa-check"></i>',
                  }).then((result) => {
                    window.location.href = "index.php?page=Lista-de-apoyos";
                  });
              },
              error: function (error) {
                  console.log(error);
              }
          });
      });
  });
</script>
