<?php

    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $departamento = $_POST['departamento'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $id_usuario = $_POST['id_usuario'];

        // Verifica si se proporciona la contraseña
        if (!empty($contraseña)) {

            $contraseñaCifrada = hash("sha512", $contraseña);
            
            $sql = "UPDATE usuarios SET 
            nombre = :nombre,
            apellido_paterno = :apellido_paterno,
            apellido_materno = :apellido_materno,
            usuario = :usuario,
            contraseña = :contrasena,
            id_departamento = :departamento,
            tipo_usuario = :tipo_usuario
            WHERE id_usuario = :id_usuario";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':contrasena', $contraseñaCifrada);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);


        } else {

            $sql = "UPDATE usuarios SET 
            nombre = :nombre,
            apellido_paterno = :apellido_paterno,
            apellido_materno = :apellido_materno,
            usuario = :usuario,
            id_departamento = :departamento,
            tipo_usuario = :tipo_usuario
            WHERE id_usuario = :id_usuario";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);

    
        }

        // Actualizar los datos en la base de datos
        if ($stmt->execute()) {
            echo "Usuario actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario.";
        }
    } else {
        echo "Acceso no autorizado.";
    }

?>


