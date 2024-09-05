<?php

    include "config.php";
    $conn = getConnection();
    
    // consulta ciudadano
    $id = 0;
    $id = $_GET['id_ciudadano']; 
      
    $sqlQuery = "SELECT *, (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad FROM ciudadanos c WHERE id_ciudadano = '$id' AND deleted = '0'";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt-> fetch(PDO::FETCH_ASSOC);
?>

<h1 class="text-dark">Eliminar ciudadano</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container py-5">
    <form id="form-eliminar-ciudadano" method="POST">
    <table class="table d-flex justify-content-center w-auto">
      <tr>
        <td colspan="2" class=""><label class="h1 text-dark">Datos del ciudadano</label></td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Nombre: </label> </td>
        <td><label class="h6" id="nombre"><?= $row['nombre']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Apellido paterno: </label> </td>
        <td><label class="h6" id="apellido_paterno"><?= $row['apellido_paterno']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark fl">Apellido materno: </label> </td>
        <td><label class="h6" id="apellido_materno"><?= $row['apellido_materno']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Sexo: </label> </td>
        <td><label class="h6" id="sexo"><?= $row['sexo']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">CURP: </label>  </td>
        <td><label class="h6" id="curp"><?= $row['curp']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Sección electoral: </label> </td>
        <td><label class="h6" id="seccion_electoral"><?= $row['seccion_electoral']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Localidad: </label> </td>
        <td><label class="h6" id="id_localidad"><?= $row['id_localidad']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Dirección: </label> </td>
        <td><label class="h6" id="direccion"><?= $row['direccion']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Referencia: </label> </td>
        <td><label class="h6" id="referencia"><?= $row['referencia']; ?></label> </td>
      </tr>
      <tr>
        <td><label class="h5 text-dark">Teléfono: </label> </td>
        <td><label class="h6" id="telefono"><?= $row['telefono']; ?></label> </td>
      </tr>
    </table><br><br>
 

    <div class="form-group d-flex justify-content-center"> 
      <a href="index.php?page=Lista-de-ciudadanos" class="btn btn-primary mr-4 w-25">
        Atrás
      </a>
      <button href="#" class="btn btn-danger ml-4 w-25" type="submit">
        Eliminar ciudadano  <i class="fas fa-trash"></i> 
      </button>
    </div>

    </form>
  </div>
</div>

<script>
    $(document).ready(function () {
          $("#form-eliminar-ciudadano").submit(function (e) {
              e.preventDefault();

              // Obtener datos del formulario
              var id_ciudadano = <?php echo $id; ?>;

              // Mostrar SweetAlert2 para confirmar la eliminación
              Swal.fire({
                title: "Eliminar",
                text: "¿Seguro que desea eliminar este ciudadano?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4E73DF",
                confirmButtonText: "Confirmar",
                cancelButtonColor: "#F24141",
                cancelButtonText: "Cancelar"
              }).then((result) => {
                if (result.isConfirmed) {
                  // Usuario confirmó, enviar datos al servidor mediante AJAX
                  $.ajax({
                    type: "POST",
                    url: "pages/Formularios/eliminar_ciudadano.php",
                    data: {
                      id_ciudadano: id_ciudadano,
                    },
                    success: function (response) {
                      Swal.fire({
                        title: "¡Eliminación exitosa!",
                        text: "Datos de ciudadano eliminados correctamente",
                        icon: "success",
                        confirmButtonColor: "#1FBF84",
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false,
                        customClass: {
                            icon: 'fa-lg'
                        },
                        iconHtml: '<i class="fas fa-check"></i>',
                      }).then((result) => {
                        window.location.href = "index.php?page=Lista-de-ciudadanos";
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