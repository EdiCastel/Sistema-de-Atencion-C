<?php

    include "config.php";
    $conn = getConnection();
    
    // consulta ciudadano
    $id = 0;
    $id = $_GET['id_apoyo']; 
      
    $sqlQuery = "SELECT *, (SELECT departamento FROM departamentos WHERE id_departamento = t.id_departamento) AS id_departamento FROM tipos_apoyo t WHERE id_tipo_apoyo = '$id' AND deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC)
    

?>

<h1 class="text-dark">Eliminar tipo de apoyo</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container py-5">
    <form id="form-eliminar-apoyo" method="POST"> 
    <table class="table d-flex justify-content-center">
      <tr>
        <td colspan="2"><label class="h1 text-dark">Datos de apoyo</label></td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Nombre de apoyo: </label> </td>
        <td><label class="h4"><?= $row['nombre_apoyo']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h4 text-dark">Departamento: </label> </td>
        <td><label class="h4"><?= $row['id_departamento']; ?></label> </td>
      </tr>
    </table><br><br>

    <div class="form-group d-flex justify-content-center"> 
      <a href="index.php?page=Lista-de-apoyos" class="btn btn-primary mr-4 w-25">
        Cancelar
      </a>
      <button href="" type="submit" class="btn btn-danger ml-4 w-25">
        Eliminar tipo de apoyo  <i class="fas fa-trash"></i> 
      </button>
    </div>

    </form>
  </div>
</div>

<script>
    $(document).ready(function () {
        $("#form-eliminar-apoyo").submit(function (e) {
            e.preventDefault();

            // Obtener datos del formulario
            var id_apoyo = <?php echo $id; ?>;

            // Mostrar SweetAlert2 para confirmar la eliminación
          Swal.fire({
              title: "Eliminar",
              text: "¿Seguro que desea eliminar este apoyo?",
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
                      url: "pages/Formularios/eliminar_apoyo.php",
                      data: {
                          id_apoyo: id_apoyo,
                      },
                      success: function (response) {
                          Swal.fire({
                              title: "¡Eliminación exitosa!",
                              text: "Datos de apoyo eliminados correctamente",
                              icon: "success",
                              confirmButtonColor: "#1FBF84",
                              confirmButtonText: "Aceptar",
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
              }
          });
        });
    });
</script>
