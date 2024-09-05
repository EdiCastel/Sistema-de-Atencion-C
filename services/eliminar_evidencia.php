<?php
// conexión a la base de datos
include "../config.php";
$conn = getConnection();

// Carpeta donde se guardan las evidencias
$carpetaEvidencias = "/xampp/htdocs/xampp/atn/evidencias/";
$carpetaThumbnails = "/xampp/htdocs/xampp/atn/evidencias/thumbs/";

// Verificar si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el nombre del archivo a eliminar
    if (isset($_POST['ruta'])) {
        $archivoEliminar = $_POST['ruta'];

        // Ruta completa del archivo y el thumbnail
        $rutaArchivo = $carpetaEvidencias . $archivoEliminar;
        $rutaThumbnail = $carpetaThumbnails . $archivoEliminar;

        // Intentar eliminar el archivo y el thumbnail
        if (unlink($rutaArchivo) && unlink($rutaThumbnail)) {
            echo "Archivo eliminado correctamente.";
        } else {
            echo "Error al eliminar el archivo.";
        }
    } else {
        echo "Nombre del archivo no proporcionado.";
    }
} else {
    echo "Acceso no válido.";
}

// Verifica si se han enviado datos mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ruta = $_POST['ruta'];
    
    $sqlQuery = "SELECT id_evidencia FROM evidencias WHERE ruta = :ruta";
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindParam(':ruta', $ruta);
    $stmt->execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    $id_solicitud = $_POST['id_solicitud'];
    $id_evidencia = $row['id_evidencia'];
    
    $sqlQuery1 = "DELETE FROM evidencias_solicitudes WHERE id_solicitud = :id_solicitud AND id_evidencia = :id_evidencia";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1->bindParam(':id_solicitud', $id_solicitud);
    $stmt1->bindParam(':id_evidencia', $id_evidencia);
    $stmt1->execute();
    $row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
    
    $tipo_solicitud = $_POST['tipo_solicitud'];
    
    $sqlQuery2 = "DELETE FROM evidencias WHERE id_evidencia = :id_evidencia";
    $stmt2 = $conn->prepare($sqlQuery2);
    $stmt2->bindParam(':id_evidencia', $id_evidencia);
    if ($stmt2->execute()) {
        // echo "Éxito en la eliminación, redirigir";
        if ($tipoSolicitud == "colectiva") {
        header("Location: ../index.php?page=Detalles-solicitud-colectiva&id_solicitud=".$id_solicitud);
        } else {
        header("Location: ../index.php?page=Detalles-solicitud-individual&id_solicitud=".$id_solicitud);
        }
    } else {
    echo "Error al procesar la solicitud de eliminación.";
    }
    
} else {
    echo "Error: Método de solicitud no válido.";
}

?>

