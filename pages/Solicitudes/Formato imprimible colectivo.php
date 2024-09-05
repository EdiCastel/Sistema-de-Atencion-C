<?php

    include "config.php";
    $conn = getConnection();
  
    $id = $_GET['idSolicitud'];
    $accion = $_GET['accion'];

    $sql = "SELECT 
    folio_seguimiento,
    descripcion_solicitud,
    fecha_registro,
    (SELECT nombre_comite FROM comites WHERE  id_comites = s.id_comite_solicitante) AS id_comite_solicitante,
    (SELECT departamento FROM departamentos WHERE  id_departamento = s.id_departamento_asignado) AS id_departamento_asignado
    FROM solicitudes s
    WHERE id_solicitud = :id";
    $stmt = $conn->prepare($sql);
    $stmt -> bindParam(':id', $id);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //Creacion de la clave encriptada para la consulta de la solicitud del ciudadano
    $clave = substr(md5($row['folio_seguimiento']. "Zentla24"), 0 , 6);
    
?>

<h1 class="text-dark d-print-none">Formato imprimible</h1>

<div class="mb-4">
  <div class="container p-5">
      <div class="d-flex justify-content-between">
        <img class="img-profile mt-1" src="img/logo.png" width="60" height="60">
        <h2 class="text-center">Formato para consulta de estado de solicitudes</h2>
        <img class="img-profile mt-1" src="img/ESCUDO-ARMAS.png" width="60" height="60">
      </div>

      <hr class="border border-dark border-3 opacity-75">
      <div class="row d-flex justify-content-center">
        <div class="col">
            <h5>Comité:</h5>
            <h5>Descripción:</h5>
            <h5>Departamento:</h5>
            <h5>Fecha:</h5>
        </div>
        <div class="col">
            <h5><?= $row['id_comite_solicitante'] ?></h5>
            <h5><?= $row['descripcion_solicitud'] ?> </h5>
            <h5><?= $row['id_departamento_asignado'] ?> </h5>
            <h5><?= $row['fecha_registro'] ?> </h5>
        </div>
      </div>
      <hr class="border border-dark border-1">
      <div class="">
        <h5>Para consultar el estado de su solicitud ingresa a: <a href="" class="link-underline-primary" >www.zentla.gob.mx/Solicitudes</a></h5>  
      </div><br>

      <h5>Ingresa los siguientes datos:</h5><br>

      <div class="d-flex justify-content-center">
        <table class="table table-bordered border-dark w-25">
            <tr>
                <td>Folio:</td>    
                <td><?= $row['folio_seguimiento'] ?></td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td><?= $clave ?></td>
            </tr>
        </table><br>
      </div><br>

      <div class="copyright text-center my-auto d-print-none">
            <span>Copyright &copy; 2024. H. Ayuntamiento de Zentla, Ver.</span>
      </div><br>

      <hr class="border border-dark border-1 d-print-none"><br>

      <div class="form-group d-flex justify-content-center"> 
        <a href="#" class="btn btn-primary mr-5 w-25 d-print-none" onclick="window.print();">
          Imprimir formato <i class="fas fa-print"></i> 
        </a>
        <button class="btn btn-success mr-5 w-25 d-print-none" type="button" id="btnSalirCo">
          Finalizar 
        </button>
      </div>
      <input type="hidden" id="accion" value="<?=$accion?>">
  </div>
</div>


<script>

$("#btnSalirCo").click(function (e) {
    e.preventDefault();
    
    // Obtener el valor de la variable $accion
    var accion = $("#accion").val();

    // Realizar la comprobación según el valor de la variable accion
    if (accion == "Insertar") {
      mostrarAlerta("¿Seguro que desea salir?", "Recuerde imprimir el formato de consulta de la solicitud antes de salir.", "¡Registro exitoso!", "La solicitud ha sido ingresada correctamente");
    } else {
      mostrarAlerta("¿Seguro que desea salir?", "Recuerde reimprimir el formato de consulta de la solicitud antes de salir.", "¡Actualización exitosa!", "La solicitud ha sido actualizada correctamente");
    }
  });
  // Función para mostrar las alertas de SweetAlert2
  function mostrarAlerta(confirmTitle, confirmText, successTitle, successText) {
    Swal.fire({
      title: confirmTitle,
      text: confirmText,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#4E73DF",
      confirmButtonText: "Confirmar",
      cancelButtonColor: "#F24141",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: successTitle,
          text: successText,
          icon: "success",
          confirmButtonColor: "#1FBF84",
          confirmButtonText: "Aceptar",
          allowOutsideClick: false,
          customClass: {
              icon: 'fa-lg'
          },
          iconHtml: '<i class="fas fa-check"></i>',
        }).then((result) => {
          window.location.href = "index.php?page=Lista-de-solicitudes";
        });
      }
    });
  }

</script>

