<?php
    //Verifica que el usuario sea administrador y en caso contrario, redirige al inicio de la pagina para evitar que se accedan a la 
    //pagina usuarios no autorizados ya que esta pagina solo tendra acceso el administrador.
    if(!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'Administrador') {
      echo "<script>window.location.href = 'index.php';</script>";
    }
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


<h1 class="text-dark">Registrar nuevo usuario</h1>

<div class="card shadow mb-4">
  <div class="container p-5">
    <form id="registroUsuarioForm" method="POST">
      <div class="form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" id="nombre" placeholder="Nombre">
      </div>
      <div class="form-group">
        <label>Apellido paterno</label>
        <input type="text" class="form-control" id="apellido_paterno" placeholder="Apellido paterno">
      </div>
      <div class="form-group">
        <label>Apellido materno</label>
        <input type="text" class="form-control" id="apellido_materno" placeholder="Apellido materno">
      </div>
      <div class="form-group">
        <label>Usuario</label>
        <input type="text" class="form-control" id="usuario" placeholder="Usuario">
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="text" class="form-control" id="contraseña" placeholder="Contraseña">
      </div>

      <div class="form-group">
        <label>Departamento</label>
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

      <div class="form-group">
        <label>Tipo de usuario</label>
        <select id="tipo_usuario" class="form-control">
          <option value="" selected disabled>Seleccionar</option>
          <?php 
            while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <option value="<?= $row['id_tipo_usuario']; ?>"><?= $row['nombre']; ?></option>
          <?php 
            }
          ?>
        </select>
      </div><br><br>

      <div class="form-group d-flex justify-content-end">
      <a href="index.php?page=Lista-de-usuarios" class="btn btn-primary mr-2 w-25">
          Cancelar
        </a>
        <button type="submit" class="btn btn-success ml-2 w-25" id="registrarUsuarioBtn">
          Registrar nuevo usuario <i class="fas fa-save"></i>
        </button>
      </div>

    </form>
  </div>
</div>


<script>
    $(document).ready(function () {
        $("#registrarUsuarioBtn").click(function (e) {
          e.preventDefault();

            // Obtener datos del formulario
            var nombre = $("#nombre").val();
            var apellido_paterno = $("#apellido_paterno").val();
            var apellido_materno = $("#apellido_materno").val();
            var usuario = $("#usuario").val();
            var contraseña = $("#contraseña").val();
            var departamento = $("#departamento").val();
            var tipo_usuario = $("#tipo_usuario").val();

            // Validar que todos los campos estén llenos
            if (nombre && apellido_paterno && apellido_materno && usuario && contraseña && departamento && tipo_usuario) {
                // Enviar datos al servidor mediante AJAX
                $.ajax({
                    type: "POST",
                    url: "pages/Formularios/insertar_usuario.php",
                    data: {
                        nombre: nombre,
                        apellido_paterno: apellido_paterno,
                        apellido_materno: apellido_materno,
                        usuario: usuario,
                        contraseña: contraseña,
                        departamento: departamento,
                        tipo_usuario: tipo_usuario
                    },
                    success: function (response) {
                      Swal.fire({
                        title: 'Registro Exitoso',
                        text: 'Datos de usuario registrados correctamente.',
                        icon: 'success',
                        confirmButtonColor: "#20c997",
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        customClass: {
                          icon: 'fa-lg'
                        },
                        iconHtml: '<i class="fas fa-check"></i>',
                      }).then((result) => {
                        window.location.href = "index.php?page=Lista-de-usuarios";
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