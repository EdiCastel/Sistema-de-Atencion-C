<?php

    $usr = $_POST['username'];
    $pwd = $_POST['password'];

    // sanitizar inputs..... 
    
    $hashedPassword = hash("sha512", $pwd);

    include "../config.php";

    $conn = getConnection();

    $stmt = $conn -> prepare("SELECT COUNT(*) AS 'N' FROM usuarios WHERE enabled = 1 AND usuario=:usr AND contraseña = :pwd");
    $stmt -> bindParam(':usr', $usr);
    $stmt -> bindParam(':pwd', $hashedPassword);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row['N'] == "1") {
        // Sesión Válida...

        session_start();
        $_SESSION['activo'] = 1;

        // OBTENER DATOS DEL USUARIO
        $sqlUser = "SELECT u.nombre as 'nombre', u.apellido_paterno as 'apellido_paterno', u.apellido_materno as 'apellido_materno', u.id_usuario as 'id_usuario', d.departamento as 'departamento', d.id_departamento as 'id_departamento', tu.nombre as 'tipo_usuario', tu.id_tipo_usuario as 'id_tipo_usuario' FROM usuarios u, departamentos d, tipos_usuario tu WHERE u.usuario = :username and d.id_departamento = u.id_departamento and tu.id_tipo_usuario = u.tipo_usuario";

        $stmtUsr = $conn -> prepare($sqlUser);
        $stmtUsr -> bindParam(':username', $usr);
        $stmtUsr -> setFetchMode(PDO::FETCH_ASSOC);
        $stmtUsr -> execute();
        $rowUsr = $stmtUsr -> fetch(PDO::FETCH_ASSOC);

        $_SESSION['nombre'] = $rowUsr['nombre'] . " " . $rowUsr['apellido_paterno'] . " " . $rowUsr['apellido_materno'];
        $_SESSION['id_usuario'] = $rowUsr['id_usuario'];
        $_SESSION['departamento'] = $rowUsr['departamento'];
        $_SESSION['id_departamento'] = $rowUsr['id_departamento'];
        $_SESSION['tipo_usuario'] = $rowUsr['tipo_usuario'];
        $_SESSION['id_tipo_usuario'] = $rowUsr['id_tipo_usuario'];

        header("Location: ../index.php");

    } else {
        // Sesión inválida...
        header("Location: ../login.php?error=1");
        
    }

?>