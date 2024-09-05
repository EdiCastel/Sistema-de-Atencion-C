<?php

    include "../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $idSolicitud = $_POST['idSolicitud'];
        $estado = $_POST['nuevoEstado'];
        
        $sqlQuery1 = "UPDATE solicitudes SET id_estado_solicitud = :estado WHERE id_solicitud = :id;";
        $stmt1 = $conn->prepare($sqlQuery1);
        $stmt1 -> bindParam(':estado', $estado);
        $stmt1 -> bindParam(':id', $idSolicitud);
        
        if($stmt1 -> execute()) {
            echo "ok";
        } 
        
        $sql = "UPDATE historial_estados SET id_estado_solicitud = :estado_solicitud, fecha = now() WHERE id_solicitud = :id_solicitud";
        $stmt = $conn->prepare($sql);
        $stmt -> bindParam(':estado_solicitud', $estado);
        $stmt -> bindParam(':id_solicitud', $idSolicitud);
        $stmt -> execute();
        
    } else {
        echo "No autorizado";
    }

?>