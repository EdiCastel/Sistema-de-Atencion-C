<?php
// conexión a bd
include "../config.php";
$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id_ciudadano = $_GET['id_ciudadano'];
    $tipoSolicitud = $_GET['tipo_solicitud'];
    $id_comites = $_GET['id_comites'];
    $id_solicitud = $_GET['id_solicitud'];
    
    if ($tipoSolicitud == "colectiva") {
        $sqlQuery1 = "DELETE FROM integrantes_comites WHERE id_comite = :id_comite AND id_ciudadano = :id_ciudadano";
        $stmt1 = $conn->prepare($sqlQuery1);
        $stmt1->bindParam(':id_comite', $id_comites);
        $stmt1->bindParam(':id_ciudadano', $id_ciudadano);
    } else {
        $sqlQuery1 = "UPDATE solicitudes SET id_ciudadano = 0 WHERE id_solicitud = :id_solicitud";
        $stmt1 = $conn->prepare($sqlQuery1);
        $stmt1->bindParam(':id_solicitud', $id_solicitud);
    }

    
    
    if ($stmt1->execute()) {
        // echo "Éxito en la eliminación, redirigir";
        if ($tipoSolicitud == "colectiva") {
            header("Location: ../index.php?page=Editar-solicitud-colectiva&id_solicitud=".$_GET['id_solicitud']);
        } else {
            header("Location: ../index.php?page=Editar-solicitud-individual&id_solicitud=".$_GET['id_solicitud']);
        }
    } else {
    echo "Error al procesar la solicitud de eliminación.";
    }
}
?>