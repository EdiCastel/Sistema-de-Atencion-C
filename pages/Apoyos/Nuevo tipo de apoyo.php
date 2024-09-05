<?php

    include "config.php";
    $conn = getConnection();

    // consulta departamentos
    $sqlQuery1 = "select * from departamentos WHERE deleted = '0'";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();
    // consulta tipos de usuario
    $sqlQuery2 = "select * from tipos_usuario";
    $stmt2 = $conn -> prepare($sqlQuery2);
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt2 -> execute();


?>


<h1 class="text-dark">Registrar nuevo tipo de apoyo</h1>

<div class="card shadow mb-4">
  <div class="container p-5">
    <form>
      <div class="form-group">
        <label>Nombre del apoyo</label>
        <input type="text" class="form-control" id="nombre" placeholder="Nombre">
      </div>
      
      <?php
      if ($_SESSION['tipo_usuario'] == 'Administrador') {
      ?>
        <div class="form-group">
          <label for="inputState">Departamento</label>
          <select id="departamento" class="form-control">
            <option value="" selected disabled>Seleccionar</option>
            <?php 
              while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <option value="<?= $row['id_departamento']; ?>"><?= $row['departamento']; ?></option>
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
          <input type="hidden" id="departamento" value="<?= $_SESSION['id_departamento']; ?>">
      </div>
      <?php
      }
      ?>

      <div class="form-group">
        <a href="index.php?page=Lista-de-apoyos" class="btn btn-success mr-4 w-25 float-right" id="registrarApoyoBtn">
          Registrar tipo de apoyo <i class="fas fa-save"></i> 
        </a>
        <a href="index.php?page=Lista-de-apoyos" class="btn btn-primary mr-4 w-25 float-right">
          Cancelar
        </a>
      </div>

    </form>
  </div>
</div>


<script>
    $(document).ready(function () {
        $("#registrarApoyoBtn").click(function (e) {
          e.preventDefault();

            // Obtener datos del formulario
            var nombre = $("#nombre").val();
            var departamento = $("#departamento").val();

            // Validar que todos los campos estén llenos
            if (nombre && departamento) {
                // Enviar datos al servidor mediante AJAX
                $.ajax({
                    type: "POST",
                    url: "pages/Formularios/insertar_apoyo.php",
                    data: {
                        nombre: nombre,
                        departamento: departamento
                    },
                    success: function (response) {
                      Swal.fire({
                        title: 'Registro Exitoso',
                        text: 'Datos de apoyo registrados correctamente.',
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
            } else {
                alert("Por favor, completa todos los campos");
            }
        });
    });
</script>