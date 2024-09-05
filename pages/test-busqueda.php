<!-- <h1>Busqueda dinámica</h1> -->
<?php
include "config.php";
$conn = getConnection();

$tipo_usuario = $_SESSION['tipo_usuario'];
$id_departamento = $_SESSION['id_departamento'];

if ($tipo_usuario == 'Administrador') {
    $sqlQuery1 = "SELECT * FROM tipos_apoyo WHERE deleted = '0'";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1->setFetchMode(PDO::FETCH_ASSOC);
    $stmt1->execute();
} else {
    $sqlQuery1 = "SELECT * FROM tipos_apoyo WHERE deleted = '0' AND id_departamento = $id_departamento";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1->setFetchMode(PDO::FETCH_ASSOC);
    $stmt1->execute();
}

$sqlQuery2 = "select * from departamentos WHERE deleted = '0'";
$stmt2 = $conn->prepare($sqlQuery2);
$stmt2->setFetchMode(PDO::FETCH_ASSOC);
$stmt2->execute();

$sqlQuery3 = "select * from localidades";
$stmt3 = $conn->prepare($sqlQuery3);
$stmt3->setFetchMode(PDO::FETCH_ASSOC);
$stmt3->execute();
?>
<div class="card shadow mb-4 d-flex justify-content-center modal-lg"> 
    <div class="form-group">
        <h5 class="float-start px-5 mt-4" id="exampleModalLabel">Nuevo Ciudadano</h5>
        <button type="button" class="close px-5 mt-4" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="container p-5">
    

            <form class="" name="ciudadano" method="POST" action="#" id="form-ciudadano">
    
                <div class="form-group">
                    <label>Nombre</label>
                    <input value="" type="text" class="form-control" id="input-nc-nombre" required>
                </div>
    
                <div class="form-group">
                    <label>Apellido paterno</label>
                    <input value="" type="text" class="form-control" id="input-nc-apellido-paterno" required>
                </div>
    
                <div class="form-group">
                    <label>Apellido materno</label>
                    <input value="" type="text" class="form-control" id="input-nc-apellido-materno" required>
                </div>
    
                <div class="form-group">
                    <label for="">Sexo</label> <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="customRadioInline" class="custom-control-input" id="input-sexo-h" required>
                        <label class="custom-control-label" for="input-sexo-h">Hombre</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="customRadioInline" class="custom-control-input" id="input-sexo-m" required>
                        <label class="custom-control-label" for="input-sexo-m">Mujer</label>
                    </div>
                </div>
    
                <div class="form-group">
                    <label >CURP</label>
                    <input name="curp" value="" type="text" class="form-control" id="input-nc-curp" required>
                </div>
    
                <div class="form-group">
                    <label for="">Sección electoral INE</label>
                    <input value="" type="text" class="form-control"  id="input-nc-seccion-ine" required>
                </div>
    
                <div class="form-group">
                    <label for="">Localidad:</label>
                    <select class="form-control" id="input-nc-localidad" required>
                        <option value="" selected disabled> Elegir Localidad </option>
                        <?php 
                            $sqlQuery3 = "select * from localidades";
                            $stmt3 = $conn->prepare($sqlQuery3);
                            $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                            $stmt3->execute();
                            while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?= $row3['id_localidad']; ?>"><?= $row3['nombre']; if($row3['nombre'] != $row3['nombre_referencia']) { echo ' - "' . $row3['nombre_referencia'] . '"' ; } ?></option>
                        <?php 
                        }
                        ?>
                    </select>
                </div>
    
                <div class="form-group">
                    <label>Dirección</label>
                    <input value="" type="text" class="form-control" id="input-nc-direccion" required>
                </div>
    
                <div class="form-group">
                    <label for="">Referencia</label>
                    <input value="" type="text" class="form-control" id="input-nc-referencia" required>
                </div>
    
                <div class="form-group">
                    <label>Teléfono</label>
                    <input value="" type="text" class="form-control" id="input-nc-telefono" required>
                </div>
    
                <div class="form-group">
                    <button name="insertar" class="btn btn-primary float-right" type="submit" id="btn-insertar-nc">
                    <i class="fas fa-plus"></i> Agregar cuidadano a la lista
                    </button>
                </div>
    
            </form>


</div>
</div>


<br><br>
<!-- <div class="row">
    <div class="col-4">
        <input type="text" class="form-control" placeholder="CURP" id="input-curp">

        <br><br> <p id="cargando">Esperando respuesta del servidor .... <i class="fas fa-spinner fa-spin"></i></p>
        <h1 id="valores"></h1>
    </div>
</div> -->




<script>

    $(document).ready(function(){


        $("#cargando").hide();
        
        // capturar escritura en el teclado, en el campo busqueda
        $('#input-curp').keyup(function (evt) {
            console.log("has oprimido una tecla");
            var buscando = $('#input-curp').val();
            console.log(buscando);
            $("#cargando").show();

            $.ajax(
                {
                    url: 'pages/servicio-busqueda.php',
                    method : 'post',
                    data : {
                        'cadena' : buscando
                    },
                    success : function(data) {
                        console.log("la pagina devolvio " + data);
                        $('#valores').text(data);
                        $("#cargando").hide();
                    },
                    error : function(data) {
                        alert("hubo un error al conectar con el servidor.");
                    }
                }
            );

        });
        
    });

</script>