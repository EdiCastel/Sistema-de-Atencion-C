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

    // consulta localidades
    $sqlQuery1 = "select * from localidades";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();


?>

<h1 class="text-dark">Editar ciudadano</h1>

<div class="card shadow mb-4">
  <div class="container py-5">
    <form id="form-editar-ciudadano" method="POST"
    >
      <div class="form-group">
        <?php 
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="form-group">
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
                <label for="">Sexo</label> <br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sexo-h" name="sexo" class="custom-control-input" value="HOMBRE" <?= ($row['sexo'] === 'HOMBRE') ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="sexo-h">Hombre</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sexo-m" name="sexo" class="custom-control-input" value="MUJER" <?= ($row['sexo'] === 'MUJER') ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="sexo-m">Mujer</label>
                </div>
            </div>



            <div class="form-group">
                <label >CURP</label>
                <input value="<?= $row['curp']; ?>" type="text" class="form-control" id="curp">
            </div>

            <div class="form-group">
                <label for="">Sección electoral INE</label>
                <input value="<?= $row['seccion_electoral']; ?>" type="text" class="form-control" id="seccion_electoral">
            </div>

            <div class="form-group">
                <label for="">Localidad:</label>
                <select class="form-control" id="id_localidad">
                    <option value="" selected disabled> <?= $row['id_localidad']; ?> </option>
                    <?php 
                        while($row2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option value="<?= $row2['id_localidad']; ?>"><?= $row2['nombre']; if($row2['nombre'] != $row2['nombre_referencia']) { echo ' - "' . $row2['nombre_referencia'] . '"' ; } ?></option>
                    <?php 
                        }
                        ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Dirección</label>
                <input value="<?= $row['direccion']; ?>" type="text" class="form-control" id="direccion">
            </div>
            
            <div class="form-group">
                <label for="">Referencia</label>
                <input value="<?= $row['referencia']; ?>" type="text" class="form-control" id="referencia">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input value="<?= $row['telefono']; ?>" type="text" class="form-control" id="telefono">
            </div>

        <?php 
            }
        ?>

      <div class="form-group d-flex justify-content-center"> 
        <a href="index.php?page=Lista-de-ciudadanos" class="btn btn-primary mr-5 w-25">
          Cancelar
        </a>
        <button href="#" class="btn btn-success mr-5 w-25" type="submit" id="editar-ciudadano">
          Actualizar ciudadano  <i class="fas fa-edit"></i> 
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
      $("#form-editar-ciudadano").submit(function (e) {
          e.preventDefault();

          // Obtener datos del formulario
          var id_ciudadano = <?php echo $id; ?>;
          var nombre = $('#nombre').val();
          var apellido_paterno = $('#apellido_paterno').val();
          var apellido_materno = $('#apellido_materno').val();
          var sexo = $('input[name="sexo"]:checked').val();
          var curp = $('#curp').val();
          var seccion_electoral = $('#seccion_electoral').val();
          var id_localidad = $('#id_localidad').val();
          var direccion = $('#direccion').val();
          var referencia = $('#referencia').val();
          var telefono = $('#telefono').val();

          // Enviar datos al servidor mediante AJAX
          $.ajax({
              type: "POST",
              url: "pages/Formularios/editar_ciudadano.php",
              data: {
                  id_ciudadano: id_ciudadano,
                  nombre: nombre,
                  apellido_paterno: apellido_paterno,
                  apellido_materno: apellido_materno,
                  sexo: sexo,
                  curp: curp,
                  seccion_electoral: seccion_electoral,
                  id_localidad: id_localidad,
                  direccion: direccion,
                  referencia: referencia,
                  telefono: telefono
              },
              success: function (response) {
                  Swal.fire({
                    title: 'Actualización Exitosa',
                    text: 'Datos de ciudadano actualizados correctamente.',
                    icon: 'success',
                    confirmButtonColor: "#1FBF84",
                    confirmButtonText: 'Aceptar',
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
      });
  });
</script>
