<?php
    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $id_usuario = $_POST['id_usuario'];
            
        $sql = "UPDATE usuarios SET 
        deleted = 1
        WHERE id_usuario = :id_usuario";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_usuario', $id_usuario);


        // Actualizar los datos en la base de datos
        if ($stmt->execute()) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar el usuario.";
        }
    } else {
        echo "Acceso no autorizado.";
    }
?>
