<?php
    //Verifica que el usuario sea administrador y en caso contrario, redirige al inicio de la pagina para evitar que se accedan a la 
    //pagina usuarios no autorizados ya que esta pagina solo tendra acceso el administrador.
    if(!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'Administrador') {
      echo "<script>window.location.href = 'index.php';</script>";
    }
    
    include "config.php";
    $conn = getConnection();
    
    // consulta usuario
    $id = 0;
    $id = $_GET['id_usuario']; 
      
    $sqlQuery = "SELECT nombre, apellido_paterno, apellido_materno, usuario, contraseña, id_departamento, tipo_usuario, (SELECT departamento FROM departamentos WHERE id_departamento = u.id_departamento) AS departamento, (SELECT nombre FROM tipos_usuario WHERE id_tipo_usuario = u.tipo_usuario) AS id_tipo_usuario FROM usuarios u WHERE id_usuario = '$id' AND deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();

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

<h1 class="text-dark">Editar usuario</h1>

<div class="card shadow mb-4">
  <div class="container p-5">
    <form id="form-editar-usuario" method="POST">
      <div class="form-group">
        <?php 
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <label>Nombre</label>
            <input value="<?= $row['nombre']; ?>" type="text" class="form-control" id="nombre">
      </div>

      <div class="form-group">
        <label>Apellido paterno</label>
            <input value="<?= $row['apellido_paterno']; ?>" type="text" class="form-control" id="apellido_paterno">
      </div>

      <div class="form-group">
        <label>Apellido materno</label>
            <input value="<?= $row['apellido_materno']; ?>" type="text" class="form-control" id="apellido_materno">
      </div>

      <div class="form-group">
        <label>Usuario</label>
            <input value="<?= $row['usuario']; ?>" type="text" class="form-control" id="usuario">
      </div>

      
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="mostrar-contraseña">
          <label class="form-check-label" for="mostrar-contraseña">Si desea cambiar la contraseña, marque la casilla</label>
        </div>
      </div>
      
      <div class="form-group" id="form-contraseña" style="display: none;">
        <label>Contraseña</label>
        <input type="text" class="form-control" id="contraseña">
      </div>


      <div class="form-group">
        <label>Departamento</label>
        <select id="departamento" class="form-control">
          <option value="<?= $row['id_departamento']; ?>" selected > <?= $row['departamento']; ?> </option>
          <?php 
            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <option value="<?= $row1['id_departamento']; ?>"> <?= $row1['departamento']; ?> </option>
          <?php 
            }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>Tipo de usuario</label>
        <select id="tipo_usuario" class="form-control">
            <option value="<?= $row['tipo_usuario']; ?>"  > <?= $row['id_tipo_usuario']; ?> </option>
          <?php 
            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <option value="<?= $row2['id_tipo_usuario']; ?>"><?= $row2['nombre'];?></option>
          <?php 
            }
          ?>
        </select>
      </div><br><br>

      <?php 
        }
      ?>

      <div class="form-group d-flex justify-content-center"> 
        <a href="index.php?page=Lista-de-usuarios" class="btn btn-primary mr-5 w-25">
          Cancelar
        </a>
        <button href="#" class="btn btn-success mr-5 w-25" type="submit" id="editar-usuario">
          Actualizar usuario  <i class="fas fa-pencil-square-o"></i> 
      </button>
      </div>
    </form>
  </div>
</div>

<script>
    document.getElementById('mostrar-contraseña').addEventListener('change', function () {
        var formContraseñaAdicional = document.getElementById('form-contraseña');
        formContraseñaAdicional.style.display = this.checked ? 'block' : 'none';
    });

  $(document).ready(function () {
      $("#form-editar-usuario").submit(function (e) {
          e.preventDefault();

          // Obtener datos del formulario
          var id_usuario = <?php echo $id; ?>;
          var nombre = $("#nombre").val();
          var apellido_paterno = $("#apellido_paterno").val();
          var apellido_materno = $("#apellido_materno").val();
          var usuario = $("#usuario").val();
          var contraseña = $("#contraseña").val();
          var departamento = $("#departamento").val();
          var tipo_usuario = $("#tipo_usuario").val();

          // Enviar datos al servidor mediante AJAX
          $.ajax({
              type: "POST",
              url: "pages/Formularios/editar_usuario.php",
              data: {
                  id_usuario: id_usuario,
                  nombre: nombre,
                  apellido_paterno: apellido_paterno,
                  apellido_materno: apellido_materno,
                  usuario: usuario,
                  contraseña: contraseña,
                  departamento: departamento,
                  tipo_usuario: tipo_usuario
              },
              success: function (response) {
                console.log(response);
                  Swal.fire({
                    title: 'Actualización Exitosa',
                    text: 'Datos de usuario actualizados correctamente.',
                    icon: 'success',
                    confirmButtonColor: "#1FBF84",
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
      });
  });
</script>

