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
      
    $sqlQuery = "SELECT nombre, apellido_paterno, apellido_materno, usuario, contraseña, (SELECT departamento FROM departamentos WHERE id_departamento = u.id_departamento) AS departamento, (SELECT nombre FROM tipos_usuario WHERE id_tipo_usuario = u.tipo_usuario) AS id_tipo_usuario FROM usuarios u WHERE id_usuario = '$id'";
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
    $row = $stmt-> fetch(PDO::FETCH_ASSOC); 
?>

<h1 class="text-dark">Eliminar usuario</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container py-5">
    <form id="form-eliminar-usuario" method="POST">
    
    <table class="table d-flex justify-content-center">
      <tr>
        <td colspan="2"><label class="h1 text-dark">Datos del usuario</label></td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Nombre: </label> </td>
        <td><label class="h4"><?= $row['nombre']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Apellido paterno: </label> </td>
        <td><label class="h4"><?= $row['apellido_paterno']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark fl">Apellido materno: </label> </td>
        <td><label class="h4"><?= $row['apellido_materno']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Usuario: </label> </td>
        <td><label class="h4"><?= $row['usuario']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Departamento: </label>  </td>
        <td><label class="h4"><?= $row['departamento']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Tipo de usuario: </label> </td>
        <td><label class="h4"><?= $row['id_tipo_usuario']; ?></label> </td>
      </tr>
    </table><br><br>
   

    <div class="form-group d-flex justify-content-center"> 
      <a href="index.php?page=Lista-de-usuarios" class="btn btn-primary mr-4 w-25">
        Cancelar
      </a>
      <button href="" type="submit" class="btn btn-danger ml-4 w-25">
        Eliminar usuario  <i class="fas fa-trash"></i> 
      </button>
    </div>

    </form>
  </div>
</div>

<script>
    $(document).ready(function () {
        $("#form-eliminar-usuario").submit(function (e) {
            e.preventDefault();

            // Obtener datos del formulario
            var id_usuario = <?php echo $id; ?>;

            // Mostrar SweetAlert2 para confirmar la eliminación
            Swal.fire({
                title: "Eliminar",
                text: "¿Seguro que desea eliminar este usuario?",
                icon: "warning",
                confirmButtonColor: "#0d6efd",
                confirmButtonText: "Confirmar",
                cancelButtonColor: "#dc3545",
                cancelButtonText: "Cancelar",
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Usuario confirmó, enviar datos al servidor mediante AJAX
                    $.ajax({
                        type: "POST",
                        url: "pages/Formularios/eliminar_usuario.php",
                        data: {
                            id_usuario: id_usuario,
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "¡Eliminación exitosa!",
                                text: "Datos de usuario eliminados correctamente",
                                icon: "success",
                                confirmButtonColor: "#1FBF84",
                                confirmButtonText: "Aceptar",
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
                }
            });
        });
    });
</script>
