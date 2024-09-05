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


$sqlQuery2 = "SELECT * FROM departamentos WHERE deleted = '0'";
$stmt2 = $conn->prepare($sqlQuery2);
$stmt2->setFetchMode(PDO::FETCH_ASSOC);
$stmt2->execute();

$sqlQuery3 = "SELECT * FROM localidades";
$stmt3 = $conn->prepare($sqlQuery3);
$stmt3->setFetchMode(PDO::FETCH_ASSOC);
$stmt3->execute();
?>

<h1>Solicitud individual</h1>

<div class="card shadow mb-4"><br>
    <div class="row m-4">
        <div class="col">

            <h6 class="text-dark">DETALLES DE LA SOLICITUD</h6><br>

            <form action="." id="formulario-solicitud">
            
            <?php
            if ($_SESSION['tipo_usuario'] == 'Administrador') {
            ?>
                <div class="form-group">
                    <label for="">Departamento</label>
                    <select class="form-control" id="solicitud-departamento" required>
                        <option value="" selected disabled> Elegir departamento </option>
                        <?php 
                            while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
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
                <input type="hidden" id="solicitud-departamento" value="<?= $_SESSION['id_departamento']; ?>">
            </div>
            <?php
            }
            ?>
            
            

            <div class="form-group">
                <label for="">Tipo de apoyo</label>
                <select class="form-control" id="solicitud-tipo" required>
                <option value="" selected disabled> Elegir tipo de apoyo </option>
                    <?php 
                        while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <option value="<?= $row['id_tipo_apoyo']; ?>"><?= $row['nombre_apoyo']; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="">Descripción de la solicitud</label>
                <textarea name="descripcion" id="solicitud-descripcion" cols="30" rows="5" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="">Total aproximado de beneficiarios</label>
                <input name="total_beneficiarios" type="number" class="form-control" id="solicitud-beneficiarios" required>
            </div>

        </div>

        <div class="col">
            
            <h6 class="text-dark">CIUDADANO QUE REALIZARA LA SOLICITUD</h6>

            <div class="alert alert-info" id="seccionComiteSinIntegrantes">
                Seleccione o registre un ciudadano.
            </div>

            <ul id="seccionComiteListaIntegrantes">
                
            </ul>

            <div id="barra-busqueda-curp">
                <h6 class="text-dark">BUSCAR CIUDADANO</h6>
                <br>
                <label for="">CURP ciudadano</label>
                <div class="form-group d-flex">
                    <input name="curp" id="input-curp" class="form-control" type="text" placeholder="Ingrese CURP" aria-label="Search">
                    <button name="buscar" id="boton-buscar-curp" class="btn btn-primary w-25 ml-2" type="button"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        
            <div id="seccionNoEncontrado" class="alert alert-danger">
                <p class="text-danger"> Ciudadano no encontrado. </p>
                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"> </i> Registrar nuevo ciudadano.</button>
            </div>
        
            <div id="resultadosCurp">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            RESULTADOS DE LA BUSQUEDA:
                        </h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <i>CIUDADANO:</i> <b id="busqueda-por-curp-nombre"> Nombre </b><br>
                            <i>LOCALIDAD:</i> <b id="busqueda-por-curp-localidad"> Localidad </b> 
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <a href="#" id="btn-agregar-al-comite" class="btn btn-primary"><i class="fas fa-check"></i> Seleccionar ciudadano</a>
                    </div>
                </div>
            </div>

        </div>
        
    </div><br><br>
        <div class="form-group">
            <button class="btn btn-success float-right mr-4 w-25" type="submit">
                <i class="fas fa-save"></i> Registrar solicitud
            </button>
            <a href="index.php?page=Lista-de-solicitudes" type="submit" class="btn btn-primary float-right mr-4 w-25">
                Atrás
            </a>
        </div><br>
    </form>

</div>

<div class="modal fade bd-example-modal-lg" id="modal-ciudadano" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Ciudadano</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">   

        <form class="p-2" name="ciudadano" method="POST" action="#" id="form-ciudadano">

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
</div>

<script>

    var respuesta;
    var ciudadanoEncontrado;

    var listaIntegrantesComite = []; // lista vacía de integrantes

    $(document).ready(function(){
    
        // al cargar página, ocultar elementos no usados.
        $('#seccionNoEncontrado').hide();
        $('#resultadosCurp').hide();

        // evento del boton buscar curp
        $("#boton-buscar-curp").click(function(){
            
            var textoCurp = $("#input-curp").val();

            $.ajax({
                url: 'services/buscar_curp.php',
                method : 'get',
                data: {
                    'curp' : textoCurp
                },
                error : function() {
                    alert("El servidor no responde.");
                },
                success : function(respuestaServidor) {
                    respuesta = JSON.parse(respuestaServidor);
                    if(respuesta.curp_encontrada) {
                        // si hay curp
                        $('#seccionNoEncontrado').hide();
                        $('#resultadosCurp').show();
                        renderizarBusquedaCurp(respuesta.ciudadano);
                        ciudadanoEncontrado = respuesta.ciudadano;
                    } else {
                        // no encontró
                        $('#seccionNoEncontrado').show();
                        $('#resultadosCurp').hide();
                    }
                }
            });
            
        }); // fin evento  click buscar

        $('#btn-agregar-al-comite').click(function(e){
            e.preventDefault();
            ciudadanoEncontrado.ciudadano_existente = true;
            listaIntegrantesComite.push(ciudadanoEncontrado);
            renderizarListaIntegrantesComite();
            $("#input-curp").val("");
            $('#resultadosCurp').hide();
            $('#barra-busqueda-curp').hide();
        }); // fin click agregar al comité

        $('#form-ciudadano').submit(function(e){

            e.preventDefault();

            var ciudadano = {};

            // obtener datos del formulario
            ciudadano.nombre = $('#input-nc-nombre').val();
            ciudadano.apellido_paterno = $('#input-nc-apellido-paterno').val();
            ciudadano.apellido_materno = $('#input-nc-apellido-materno').val();
            ciudadano.sexo = $('#input-sexo-h').prop('checked') ? "HOMBRE" : "MUJER";
            ciudadano.curp = $('#input-nc-curp').val();
            ciudadano.seccion_electoral = $('#input-nc-seccion-ine').val();
            ciudadano.id_localidad = $('#input-nc-localidad').val();
            ciudadano.direccion = $('#input-nc-direccion').val();
            ciudadano.referencia = $('#input-nc-referencia').val();
            ciudadano.telefono = $('#input-nc-telefono').val();

            //console.log(ciudadano);
            listaIntegrantesComite.push(ciudadano);
            renderizarListaIntegrantesComite();
            
            //oculta
            $('#modal-ciudadano').modal('hide');

            //limpiar formulario
            $('#input-nc-nombre').val("");
            $('#input-nc-apellido-paterno').val("");
            $('#input-nc-apellido-materno').val("");
            $('#input-sexo-h').prop('checked', false);
            $('#input-sexo-m').prop('checked', false);
            $('#input-nc-curp').val("");
            $('#input-nc-seccion-ine').val("");
            $('#input-nc-localidad').val(0);
            $('#input-nc-direccion').val("");
            $('#input-nc-referencia').val("");
            $('#input-nc-telefono').val("");

            //actualizar UI
            $('#seccionNoEncontrado').hide();
            $("#input-curp").val("");
        });

        //catpurar submit general
        $('#formulario-solicitud').submit(function(e){
            e.preventDefault();
            if (listaIntegrantesComite.length > 0) {
                // hay al menos un integrante del comité

                var datosEnviar = {};

                var tipo_apoyo = $('#solicitud-tipo').val();
                var departamento = $('#solicitud-departamento').val();
                var descripcion_solicitud = $('#solicitud-descripcion').val();
                var beneficiarios = $('#solicitud-beneficiarios').val();
                

                datosEnviar.ciudadanos = listaIntegrantesComite;

                datosEnviar.tipo_apoyo = tipo_apoyo;
                datosEnviar.departamento = departamento;
                datosEnviar.descripcion_solicitud = descripcion_solicitud;
                datosEnviar.beneficiarios = beneficiarios;

                console.log(datosEnviar);

                //enviar los datos a php
                $.ajax({
                    url : 'pages/Formularios/insertar_solicitud_individual.php',
                    method : "POST",
                    data : datosEnviar,
                    error: function() {
                        alert("error de comunicación");    
                    },
                    success: function(data) {
                        console.log(data);
                        var id = JSON.parse(data).id_solicitud;
                        window.location.href = "index.php?page=Formato-imprimible-individual&accion=Insertar&idSolicitud="+ id;
                    }
                });

            } else {
                //alert("Seleccionar o registar al menos un integrante del comité.");
                Swal.fire({
                    title: '',
                    text: 'Seleccionar o registar al menos un integrante a la solicitud',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                });
            }
        });

        //capturar evento "mostrar" del dialogo modal.
        $('#modal-ciudadano').on('shown.bs.modal', function (e) {
            $('#input-nc-curp').val(
                $("#input-curp").val()
            );
        });

        renderizarListaIntegrantesComite();

    });

    function renderizarBusquedaCurp(ciudadano) {
        //console.log(ciudadano);
        $('#busqueda-por-curp-nombre').text(ciudadano.nombre + " " + ciudadano.apellido_paterno + " " + ciudadano.apellido_materno);
        $('#busqueda-por-curp-localidad').text(ciudadano.localidad);
    }

    function renderizarListaIntegrantesComite() {

        if (listaIntegrantesComite.length > 0) {
            $('#seccionComiteSinIntegrantes').hide();
            $('#seccionComiteListaIntegrantes').show();
        } else {
            $('#seccionComiteSinIntegrantes').show();
            $('#seccionComiteListaIntegrantes').hide();
        }

        $('#seccionComiteListaIntegrantes').empty();

        listaIntegrantesComite.forEach(function (elemento, index) {
            //console.log(elemento);
            $('#seccionComiteListaIntegrantes').append(
                '<li>' + elemento.nombre + ' ' + elemento.apellido_paterno + ' ' + elemento.apellido_materno + ' - <a href="#" class="text-danger boton-eliminar-ciudadano" data-indice="' + index + '"><i class="fas fa-trash"></i></a></li>'
            );
        });

        $('.boton-eliminar-ciudadano').click(function(e){
            e.preventDefault();
            var indiceEliminar = parseInt($(this).data("indice"));
            listaIntegrantesComite.splice(indiceEliminar, 1);
            renderizarListaIntegrantesComite();
        });

    }

</script>