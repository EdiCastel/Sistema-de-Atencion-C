<?php

    //Redirigir SI NO HAY SESIÓN.
    session_start();
    if (! isset($_SESSION['activo'])) {
        header("Location: login.php");
    }
    

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Atención Ciudadana</title>
    <link rel="website icon" type="png" href="img/favicon-16x16.png">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- BOOSTRAP -->
    <link href="css/bootstrap.min.css" rel="stylesheet" >
    
    <!-- cargar jquery -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css">


</head>


<body id="page-top" onload="noVolver();">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
            include "includes/sidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow border-bottom-secondary d-print-none">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- <img class="img-profile m-2 " src="img/ESCUDO-ARMAS.png" width="auto" height="60"> -->
                    <!-- <img class="img-profile m-2 " src="img/SEVIVEBIEN.png" width="auto" height="60"> -->
                    <img class="img-profile m-2 " src="img/logo.png" width="60" height="60">
                    <h5 class="align-text-bottom pt-2 ml-2"><b>SISTEMA DE ATENCIÓN CIUDADANA</b></h5>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <?php 
                        // include "includes/message-center.php"; 
                        ?>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <b><?= $_SESSION['nombre']; ?></b>
                                    <br>
                                    <b class="text-gray"><?= $_SESSION['departamento']; ?></b> (<i><?= $_SESSION['tipo_usuario']; ?></i>)
                                </span>
                                    <img class="img-profile rounded-circle" src="img/user-placeholder.jpg">
                                
                                
                                
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" id="btnSalir">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php
    
                        if(isset($_GET['page'])) {
                            switch($_GET['page']) {
                                case "hola-mundo":
                                    include "pages/ejemplo.php";
                                    break;
                                case "Lista-de-usuarios":
                                    include "pages/Usuarios/Lista de usuario.php";
                                    break;
                                case "Nuevo-usuario":
                                    include "pages/Usuarios/Nuevo usuario.php";
                                    break;
                                case "Editar-usuario":
                                    include "pages/Usuarios/Editar usuario.php";
                                    break;
                                case "Eliminar-usuario":
                                    include "pages/Usuarios/Eliminar usuario.php";
                                    break;
                                case "Lista-de-ciudadanos":
                                    include "pages/Ciudadanos/Lista de ciudadanos.php";
                                    break;
                                case "Editar-ciudadano":
                                    include "pages/Ciudadanos/Editar ciudadano.php";
                                    break;
                                case "Eliminar-ciudadano":
                                    include "pages/Ciudadanos/Eliminar ciudadano.php";
                                    break;
                                case "Detalles-de-ciudadano":
                                    include "pages/Ciudadanos/Detalles de ciudadano.php";
                                    break;
                                case "Lista-de-solicitudes":
                                    include "pages/Solicitudes/Lista de solicitudes.php";
                                    break;
                                case "Solicitud-individual":
                                    include "pages/Solicitudes/Solicitud individual.php";
                                    break;
                                case "Solicitud-colectiva":
                                    include "pages/Solicitudes/Solicitud colectiva.php";
                                    break;
                                case "Formato-imprimible-individual":
                                    include "pages/Solicitudes/Formato imprimible individual.php";
                                    break;
                                case "Formato-imprimible-colectivo":
                                    include "pages/Solicitudes/Formato imprimible colectivo.php";
                                    break;
                                case "Detalles-solicitud-individual":
                                    include "pages/Solicitudes/Detalles de solicitud individual.php";
                                    break;
                                case "Detalles-solicitud-colectiva":
                                    include "pages/Solicitudes/Detalles de solicitud colectiva.php";
                                    break;
                                case "Detalles-solicitud":
                                    include "pages/Solicitudes/Detalles de solicitud.php";
                                    break;
                                case "Editar-solicitud-individual":
                                    include "pages/Solicitudes/Editar solicitud individual.php";
                                    break;
                                case "Editar-solicitud-colectiva":
                                    include "pages/Solicitudes/Editar solicitud colectiva.php";
                                    break;
                                case "Lista-de-comités":
                                    include "pages/Comités/Lista de comités.php";
                                    break;
                                case "Detalles-de-comité":
                                    include "pages/Comités/Detalles de comité.php";
                                    break;
                                case "Lista-de-apoyos":
                                    include "pages/Apoyos/Lista de apoyos.php";
                                    break;
                                case "Nuevo-tipo-apoyo":
                                    include "pages/Apoyos/Nuevo tipo de apoyo.php";
                                    break;
                                case "Editar-apoyo":
                                    include "pages/Apoyos/Editar apoyo.php";
                                    break;
                                case "Eliminar-apoyo":
                                    include "pages/Apoyos/Eliminar apoyo.php";
                                    break;
                                case "Módulo-de-reportes":
                                    include "pages/Módulo de reportes.php";
                                    break;
                                case "reporte-1":
                                    include "pages/Reportes/reporte1.php";
                                    break;
                                case "test-busqueda":
                                    include "pages/test-busqueda.php";
                                    break;
                                default:
                                    include "pages/default.php";
                                    break;
                            }
                        } else {
                            include "pages/default.php";
                        }

                    ?>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer d-print-none bg-danger-subtle" > -->
                <div class="container sticky-footer d-print-none d-flex justify-content-center border-top border-secondary border-4 shadow">
                    <div class="row d-flex w-100">
                        <div class="col text-center my-1">
                            <h6><b>CONTACTO</b></h6>
                            <p ><i class="fas fa-map-marker"></i> AV. Reforma S/N.
                            C.P. 94220, Col. Manuel Gonzalez,
                            Zentla, Veracruz. <br>
                            <i class="fas fa-phone"></i>
                            (273) 73 5 31 11 <b>-</b> 73 5 30 99 <b>-</b> 73 5 30 77 <br>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:ayuntamientozentla2022.2025@gmail.com">ayuntamientozentla2022.2025@gmail.com</a></p>
                        </div>
                        
                        <div class="col my-2"> 
                            <div class="copyright text-center my-auto">
                                <img class="img-profile" src="img/SEVIVEBIEN.png" width="50%">
                                <p class="fs-6 mt-4"> Copyright &copy; 2024. H. Ayuntamiento de Zentla, Ver.</p>
                            </div>
                        </div>
    
                        <div class="col text-center">
                            <div class="social-icons d-flex justify-content-center">
                                <div class="d-flex flex-column">
                                    <h6><b> REDES </b></h6>
                                        
                                    <div class="d-flex flex-row">
                                        <div class="form-group d-flex flex-column">
                                            <a class="text-primary" href="https://www.facebook.com/Zentla2025" target="_blank"><i class="fab fa-facebook-square fa-lg"></i></a>
                                            <span class="text-primary">Facebook</span>
                                        </div>
                                    
                                        <div class="form-group d-flex flex-column">
                                            <a class="text-success" href="https://wa.me/2731111426" target="_blank"><i class="fab fa-whatsapp-square fa-lg"></i></a>
                                            <span class="text-success">Whatsapp</span>
                                        </div>
                                    </div>   
                                    
                                </div>
                                
                                <div class="d-flex flex-column">
                                    <h6><b>AYUDA</b></h6>
                                
                                    <div class="form-group d-flex flex-column">
                                        <a class="text-warning-emphasis" href="Manual/Manual.pdf" target="_blank"><i class="fas fa-book fa-lg"></i></a>
                                        <span class="text-warning-emphasis">Manual de usuario</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <!-- </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Librería Sweet Alert (Dialogos) -->
    <script src="js/sweetalert2@11.js"></script>

</body>

</html>
<script>
    $('#btnSalir').click(function(e){
    e.preventDefault();
        Swal.fire({
            title: "Cerrar Sesión",
            text: "¿Seguro que desea cerrar la sesión actual?",
            icon: "info",
            confirmButtonColor: "#0d6efd",
            confirmButtonText: "Confirmar",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            customClass: {
            icon: 'fa-2x'
        },
        iconHtml: '<i class="fas fa-door-open"></i>' 
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "¡Cerrando sesión!",
                    text: "Gracias por visitar nuestro modulo de consulta, vuelva pronto",
                    icon: "warning",
                    confirmButtonColor: "#1FBF84",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    customClass: {
                    icon: 'fa-2x'
                    },
                    iconHtml: '<i class="fas fa-door-closed"></i>' 
                }).then((result) => {
                    window.location.href = "php/logout.php";
                });
            }
        });
    });
    //funcion que se ejecuta cuando el usuario quiere volver atras mediante el navegador
    function noVolver() {
        window.history.forward();
    }
</script>