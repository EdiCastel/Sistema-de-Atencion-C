<?php

    include "config.php";
    $conn = getConnection();
        
    $id = 0;
    $id = $_GET['id']; 
    
    $sqlQuery = "SELECT *, 
    (SELECT nombre_apoyo FROM tipos_apoyo WHERE id_tipo_apoyo = s.id_tipo_apoyo) AS id_tipo_apoyo,
    (SELECT departamento FROM departamentos WHERE id_departamento = s.id_departamento_asignado) AS id_departamento_asignado,
    (SELECT nombre FROM estados WHERE id_estado = s.id_estado_solicitud) AS id_estado_solicitud 
    from solicitudes s where id_solicitud = :id";
    $stmt = $conn -> prepare($sqlQuery);
    $stmt -> bindParam(':id', $id);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);    

    $sqlQuery1 = "SELECT *,
    (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad
    from comites c where id_comites = :id_comite";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> bindParam(':id_comite', $row['id_comite_solicitante']);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();

    $sqlQuery2 = "select ci.nombre, ci.apellido_materno, ci.apellido_paterno FROM ciudadanos ci, comites co, integrantes_comites ic WHERE ic.id_ciudadano = ci.id_ciudadano AND ic.id_comite = co.id_comites AND co.id_comites = :id_comite;";
    $stmt2 = $conn -> prepare($sqlQuery2);
    $stmt2 -> bindParam(':id_comite', $row['id_comite_solicitante']);
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt2 -> execute();

    $sqlQuery3 = "SELECT e.ruta, e.tipo_evidencia, e.comentarios FROM evidencias e, evidencias_solicitudes es WHERE es.id_evidencia = e.id_evidencia AND es.id_solicitud = :solicitud;";
    $stmt3 = $conn -> prepare($sqlQuery3);
    $stmt3 -> bindParam(':solicitud', $id);
    $stmt3 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt3 -> execute();
    
    $evidencias = $_GET['evidencias'];
    
    if(isset($_GET['error_evidencia']) && $_GET['error_evidencia'] === 'true') {
        // Mostrar alerta SweetAlert2
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Error al cargar evidencia',
                    text: 'Por favor, solo suba archivos con extensión .pdf, .jpg y .png',
                    icon: 'warning',
                    confirmButtonColor: '#1FBF84',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                });
            </script>";
    }

?>

<h1 class="text-dark">Detalles de solicitud colectiva</h1>

<div class="card shadow mb-4 d-flex align-items-center">
  <div class="container p-5">
    <!-- Muestra de los datos de la solicitud -->
    <div class = "row">

        <div class= "col" >

            <label class="h5 text-dark">Datos de la solicitud</label>
            <div class="form-group">
                <label class="h6 text-dark">Tipo de apoyo: </label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-black-50"> <?= $row['id_tipo_apoyo'];?> </label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Departamento: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['id_departamento_asignado'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Descripción de la solicitud: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['descripcion_solicitud'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Total de beneficiarios: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['beneficiarios'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Fecha de ingreso: </label>  
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"> <?= $row['fecha_registro'];?> </label> 
            </div>
            
            <div class="form-group d-flex flex-column">
                <label class="h6 text-dark">Estado de la solicitud: </label>
            </div>
            
            <div class="form-group d-flex flex-row justify-content-between">
                <div class="">
                    <label id="estado" class="h6 text-black-50"><?= $row['id_estado_solicitud'];?></label> 
                </div>
                <div class="">
                    <?php if ($row['id_estado_solicitud'] != "COMPLETADA") { ?>
                    <a href="#" class="btn btn-success" id="btn-act-estado">Actualizar Estado <i class="fas fa-refresh"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>  

        <div class="col">  
                <?php
                    while($row2 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                ?> 
            <label class="h5 text-dark">Detalles del comité</label>

            <div class="form-group">
                <label class="h6 text-dark">Nombre del comité: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row2['nombre_comite'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark fl">Detalles del comité: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row2['detalles_comite'];?></label> 
            </div>

            <div class="form-group">
                <label class="h6 text-dark">Localidad: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row2['id_localidad'];?></label> 
            </div>
            

            <div class="form-group">
                <label class="h6 text-dark">Lista de solicitantes: </label> 
                <ul>
                    <?php  while($row3 = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                        <li Class="h6 text-black-50"><?= $row3['nombre'] ?> <?= $row3['apellido_paterno'] ?> <?= $row3['apellido_materno'] ?></li>
                    <?php } ?>
                </ul>
            </div>
            <?php 
                }
            ?>
        </div>
    </div>
    <!-- Fin de la muestra de los datos de la solicitud -->
    
    <?php if ($evidencias > 0 ) { ?> 
                        
        <!-- INICIO DE CONTENEDOR DE LA EVIDENCIA -->
        <div class="card" id="evidencia-cargando">
            <div class="card-header text-center">
                <h6><b> EVIDENCIAS DE SOLICITUD </b></h6>
            </div>
            <div class="card-body flex-row">
                <div class="row">
                
                    <?php
                        while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                    ?>                    
                    <div class="col-2 mb-4">
                        <div class="card card-evidencias">
                            <div class="img-container border">
                            <?php
                            $ruta = $row3['ruta'];
                            if (pathinfo($ruta, PATHINFO_EXTENSION) === 'pdf') {
                                // Si es un archivo PDF, mostrar un enlace con la ruta del PDF en los datos
                                echo '<a href="#" class="file-viewer" data-file="evidencias/' . $ruta . '"><img src="evidencias/thumbs/pdf-icon.png" class="" alt="PDF"></a>';
                            } else {
                                // Si es una imagen, mostrar la imagen de baja calidad en la tarjeta
                                echo '<img src="evidencias/thumbs/' . $ruta . '" class="img-clickable" data-high-res="evidencias/' . $ruta . '" data-toggle="modal" data-target="#imageModal" alt="...">';
                            }
                            ?>
                            </div>
                            <div class="card-body bg-gray-200">
                                <p class="text-justify "><?= $row3['comentarios']; ?></p>
                                <br>
                            </div>
                        </div>
                    </div>                   
                    <?php
                        }
                    ?>
                    
                    <!-- Modal para mostrar imágenes en grande -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img src="" class="img-fluid" id="modalImage" alt="Imagen">
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                </div>
            </div>
        </div><br><br>
        <!-- FIN DEL CONTENEDOR DE LA EVIDENCIA -->
                    
        <!-- INICIO DE LOS BOTONES -->
        <div class="form-group d-flex justify-content-center"> 
            <a href="index.php?page=Lista-de-solicitudes" class="btn btn-primary mr-4 w-25">
                Atrás
            </a>

            <?php if ($_SESSION['tipo_usuario'] == 'Administrador') { ?>
            <a class="btn btn-danger mr-4 w-25 text-white" href="index.php?page=Detalles-solicitud-colectiva&id=<?= $_GET['id']; ?>&id_estado_solicitud=<?=$row['id_estado_solicitud']?>&evidencias=0">
                Editar <i class="fas fa-edit text-white"></i> 
            </a>
            <?php } ?>
        </div>
        <!-- FIN DE LOS BOTONES -->
    <?php } else { ?>
        
        <?php if ($row['id_estado_solicitud'] == 'COMPLETADA') { ?>   
            <!-- FORMULARIO PARA INGRESAR LA EVIDENCIA -->
            <div id="evidencias">
                <div class="row" id="carga-evidencia">
                    <div class="col-7">
                        <form action="services/carga_evidencia.php" enctype="multipart/form-data" method="post" id="form-carga">
                            <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                            <input type="hidden" name="tipo_solicitud" value="colectiva">
                            <hr>
                            <label class="h5 text-dark"> ADJUNTAR EVIDENCIAS:</label>
                            <div class="form-group">
                                <label class="text-dark">Descripción de la evidencia:</label> 
                                <input type="text" class="form-control" name="comentarios" id="descripcion-evidencia" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="file" class="form-control" name="evidencia" id="adjuntar_evidencia" required>
                                <button id="btn-cargar-evidencia" type="submit" class="btn btn-primary ml-4 w-25"><i class = "fas fa-upload"></i> Cargar</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <!-- FIN DEL FORMAULARIO PARA INGRESAR LA EVIDENCIA -->
                    
            <!-- INICIO DE CONTENEDOR DE LA EVIDENCIA -->
            <div class="card" id="evidencia-cargando">
                <div class="card-header text-center">
                    <h6><b> EVIDENCIAS DE SOLICITUD </b></h6>
                </div>
                <div class="card-body flex-row">
                    <div class="row">
                    
                        <?php
                            while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                        ?>                    
                        <div class="col-2 mb-4">
                            <div class="card card-evidencias">
                                <div class="img-container border">
                                <?php
                                $ruta = $row3['ruta'];
                                if (pathinfo($ruta, PATHINFO_EXTENSION) === 'pdf') {
                                    // Si es un archivo PDF, mostrar un enlace con la ruta del PDF en los datos
                                    echo '<a href="#" class="file-viewer" data-file="evidencias/' . $ruta . '"><img src="evidencias/thumbs/pdf-icon.png" class="" alt="PDF"></a>';
                                } else {
                                    // Si es una imagen, mostrar la imagen de baja calidad en la tarjeta
                                    echo '<img src="evidencias/thumbs/' . $ruta . '" class="img-clickable" data-high-res="evidencias/' . $ruta . '" data-toggle="modal" data-target="#imageModal" alt="...">';
                                }
                                ?>
                                </div>
                                <div class="card-body bg-gray-200">
                                    <p class="text-justify "><?= $row3['comentarios']; ?></p>
                                    <br>
                                </div>
                                <div class="card-footer text-center" id="btn-ocultar">
                                    <form name="eliminar-ciudadano" method="POST" action="#" id="form-eliminar-evidencia">
                                        <input type="hidden" id="id_solicitud" value="<?= $id; ?>">
                                        <input type="hidden" id="ruta" value="<?= $ruta; ?>">
                                        <input type="hidden" id="tipo_solicitud" value="colectiva">
                                        <button type="submit" class="btn btn-sm btn-danger btn-eliminar-evidencia" id="btn-eliminar-evidencia"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>                   
                        <?php
                            }
                        ?>
                        
                        <!-- Modal para mostrar imágenes en grande -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="" class="img-fluid" id="modalImage" alt="Imagen">
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                    </div>
                </div>
            </div><br><br>
            <!-- FIN DEL CONTENEDOR DE LA EVIDENCIA -->
                        
            <!-- INICIO DE LOS BOTONES -->
            <div class="form-group d-flex justify-content-center"> 
                <a href="index.php?page=Lista-de-solicitudes" class="btn btn-primary mr-4 w-25">
                    Atrás
                </a>
                    
                <a class="btn btn-success mr-4 w-25" id="btn-guardar-evidencia">
                    Guardar <i class="fas fa-save"></i> 
                </a> 
            </div>
            <!-- FIN DE LOS BOTONES -->
        <?php } ?>
        
    <?php } ?>
  </div>
</div>

<script>

    var idSolicitud = <?= $id; ?>;
    
    $(document).ready(function(){
        
        $('#btn-guardar-evidencia').click(function(e){
            e.preventDefault();
            Swal.fire({
                title: "Guardando evidencias",
                text: "¿Seguro que desea guardar las evidencias cargadas, recuerde verificarlas antes de guardar?",
                icon: "warning",
                confirmButtonColor: "#0d6efd",
                confirmButtonText: "Confirmar",
                cancelButtonColor: "#dc3545",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '¡Operación exitosa!',
                        text: 'Las evidencias han sido guardadas exitosamente',
                        icon: 'success',
                        confirmButtonColor: "#1FBF84",
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false,
                        customClass: {
                            icon: 'fa-lg'
                        },
                        iconHtml: '<i class="fas fa-check"></i>',
                    }).then((result) => {
                        window.location.href = "index.php?page=Detalles-solicitud-colectiva&id=<?= $_GET['id']; ?>&id_estado_solicitud=<?=$row['id_estado_solicitud']?>&evidencias=1";
                    });
                }
            });
        });
        
        $('.btn-eliminar-evidencia').click(function(e) {
            e.preventDefault();
            
            var id_solicitud = $('#id_solicitud').val();
            var ruta = $('#ruta').val();
            var tipo_solicitud = $('#tipo_solicitud').val();
        
            $.ajax({
                type: 'POST',
                url: 'services/eliminar_evidencia.php',
                data: {
                    id_solicitud: id_solicitud,
                    ruta: ruta,
                    tipo_solicitud: tipo_solicitud,
                },
                success: function(response) {
                    console.log(response); 
                    location.reload();
                },  
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    
        $('#btn-act-estado').click(function(e){
            e.preventDefault();
            // llamada al servicio que provee la lista de estados posibles.
            $.ajax({
                url: 'services/lista_estados.php',
                method: 'get',
                success: function(data) {
                    var estados = JSON.parse(data);
                    var map = new Map();
                    estados.forEach((estado) => map.set(estado.id_estado, estado.nombre));
                    Swal.fire({
                        title: "Actualizar estado de solicitud",
                        input: "select",
                        inputOptions: map,
                        showCancelButton: true,
                        cancelButtonText : "Atrás",
                        cancelButtonColor: "#0d6efd",
                        showConfirmButton: true,
                        confirmButtonText: 'Guardar <i class="fas fa-save"></i>',
                        confirmButtonColor: "#1FBF84",
                        reverseButtons: true
                    }).then(function (e) {
                        if(e.isConfirmed) {
                            var data = {};
                            data.idSolicitud = idSolicitud;
                            data.nuevoEstado = e.value;
                            // llamada al servicio que actualiza el estado.
                            $.ajax({
                                url : "services/actualizar_estado_solicitud.php",
                                method : "post",
                                data: data,
                                success: function (response) {
                                    console.log(response);
                                    if(response == "ok") {
                                        Swal.fire({
                                            title : "Actualización exitosa",
                                            text: "El estado de la solicitud ha sido actualizado correctamente.",
                                            icon : "success",
                                            showConfirmButton: true,
                                            confirmButtonText: 'Aceptar',
                                            allowOutsideClick: false,
                                            confirmButtonColor: "#198754",
                                            customClass: {
                                                icon: 'fa-lg'
                                            },
                                            iconHtml: '<i class="fas fa-check"></i>',
                                        }).then(function () {
                                        // Recargar la página después de hacer clic en "Aceptar" en el cuadro de diálogo
                                        location.reload();
                                        });
                                    }
                                },
                                error: function() {
                                    Swal.fire({
                                        text : "Error de comunicación.",
                                        icon : "error"
                                    });
                                }
                            });
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        text : "Error de comunicación.",
                        icon : "error"
                    });
                }
            });
            
        });
    });
    
    document.addEventListener("DOMContentLoaded", function () {
        // Manejar clic en imágenes
        const imgClickables = document.querySelectorAll('.img-clickable');
        imgClickables.forEach(function (imgClickable) {
            imgClickable.addEventListener('click', function () {
                const highResUrl = imgClickable.getAttribute('data-high-res');
                const modalImage = document.getElementById('modalImage');
                modalImage.setAttribute('src', highResUrl);
            });
        });

        // Manejar clic en archivos PDF
        const fileViewers = document.querySelectorAll('.file-viewer');
        fileViewers.forEach(function (fileViewer) {
            fileViewer.addEventListener('click', function (event) {
                event.preventDefault();
                const pdfUrl = fileViewer.getAttribute('data-file');
                window.open(pdfUrl, '_blank');
            });
        });
    });
</script>