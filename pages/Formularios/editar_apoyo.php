<?php

    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtener datos del formulario
        $id_tipo_apoyo = $_POST['id_tipo_apoyo'];
        $nombre_apoyo = $_POST['nombre_apoyo'];
        $id_departamento = $_POST['id_departamento'];
        
        //Actualiza los datos en la tabla tipos_apoyos          
        $sql = "UPDATE tipos_apoyo SET 
        nombre_apoyo = :nombre_apoyo,
        id_departamento = :id_departamento
        WHERE id_tipo_apoyo = :id_tipo_apoyo";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_tipo_apoyo', $id_tipo_apoyo);
        $stmt->bindParam(':nombre_apoyo', $nombre_apoyo);
        $stmt->bindParam(':id_departamento', $id_departamento);

        // Actualizar los datos en la base de datos
        if ($stmt->execute()) {
            echo "Apoyo actualizado correctamente.";
        } else {
            echo "Error al actualizar el apoyo.";
        }
    } else {
        echo "Acceso no autorizado.";
    }

?>
