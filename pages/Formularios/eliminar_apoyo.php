<?php
    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $id_tipo_apoyo = $_POST['id_apoyo'];
            
        $sql = "UPDATE tipos_apoyo SET 
        deleted = 1
        WHERE id_tipo_apoyo = :id_tipo_apoyo";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_tipo_apoyo', $id_tipo_apoyo);


        // Actualizar los datos en la base de datos
        if ($stmt->execute()) {
            echo "Apoyo eliminado correctamente.";
        } else {
            echo "Error al eliminar el apoyo.";
        }
    } else {
        echo "Acceso no autorizado.";
    }
?>