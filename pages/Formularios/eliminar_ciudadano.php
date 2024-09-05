<?php
    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $id_ciudadano = $_POST['id_ciudadano'];
            
        $sql = "UPDATE ciudadanos SET 
        deleted = 1
        WHERE id_ciudadano = :id_ciudadano";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_ciudadano', $id_ciudadano);


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
