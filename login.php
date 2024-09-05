<?php

    session_start();
    if (isset($_SESSION['activo'])) {
        header("Location: index.php");
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inciar Sesión Atención Ciudadana</title>
    <link rel="website icon" type="png" href="img/favicon-16x16.png">
    
    <!-- BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body class="bg-gradient-primary">

<div class="container position-absolute top-50 start-50 translate-middle">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-primary">
                            <div class="text-center my-4">
                                <h1 class="h2 text-light">SISTEMA DE ATENCIÓN CIUDADANA</h1>
                            </div>
                            <img src="img/logo1.png"  class="img-fluid m-2 p-4" alt="">
                        </div>
                        <div class="col-lg-6 align-self-center">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-dark mb-4">INICIAR SESIÓN</h1>
                                </div>
                                <h1 class="h6 text-gray my-2">Bienvenido de nuevo</h1>
                                <form class="user" action="php/ulogin.php" method="post">
                                    <div class="form-group">
                                        <input name="username" type="text" class="form-control form-control-user shadow-sm"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Usuario">
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user shadow-sm"
                                                id="exampleInputPassword" placeholder="Contraseña">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Recordar contraseña</label>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-user btn-block shadow-lg">Iniciar Sesión</button>
                                    </div>
                                    <br>   
                                </form>
                                <br>
                                <?php if(isset($_GET['error'])) { ?>
                                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
                                    <script>
                                            Swal.fire({
                                                title: 'Usuario o contraseña incorrectos',
                                                text: 'Por favor, verfique que esta ingresando sus datos correctamente',
                                                icon: 'warning',
                                                confirmButtonColor: '#1FBF84',
                                                confirmButtonText: 'Aceptar',
                                                allowOutsideClick: false,
                                                customClass: {
                                                icon: 'fa-lg'
                                            },
                                            iconHtml: '<i class="fas fa-times"></i>' 
                                            });
                                    </script>
                                <?php } ?>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>