<?php

//DEFINICIÓN DE FUNCION AUXILIAR PARA CREAR LAS VISTAS PREVIAS
function generarThumbnail($rutaArchivoOriginal, $carpetaThumbnail, $tamanoThumbnail = 150) {
    // Obtener las dimensiones de la imagen original
    list($anchoOriginal, $altoOriginal, $tipo) = getimagesize($rutaArchivoOriginal);

    // Calcular nuevas dimensiones para el thumbnail manteniendo la proporción original
    $anchoThumbnail = $tamanoThumbnail;
    $altoThumbnail = ceil($tamanoThumbnail * ($altoOriginal / $anchoOriginal));

    // Crear una nueva imagen en blanco para el thumbnail
    $thumbnail = imagecreatetruecolor($anchoThumbnail, $altoThumbnail);

    // Cargar la imagen original según el tipo de archivo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagenOriginal = imagecreatefromjpeg($rutaArchivoOriginal);
            break;
        case IMAGETYPE_PNG:
            $imagenOriginal = imagecreatefrompng($rutaArchivoOriginal);
            break;
        default:
            // Otros tipos de imagen no son compatibles
            return false;
    }

    // Redimensionar la imagen original y copiarla al thumbnail
    imagecopyresampled($thumbnail, $imagenOriginal, 0, 0, 0, 0, $anchoThumbnail, $altoThumbnail, $anchoOriginal, $altoOriginal);

    // Generar el nombre del archivo de thumbnail
    $nombreThumbnail = pathinfo($rutaArchivoOriginal, PATHINFO_FILENAME) . '.' . pathinfo($rutaArchivoOriginal, PATHINFO_EXTENSION);

    // Ruta completa para el thumbnail
    $rutaThumbnail = $carpetaThumbnail . '/' . $nombreThumbnail;

    // Guardar el thumbnail en un archivo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbnail, $rutaThumbnail, 75);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbnail, $rutaThumbnail);
            break;
    }

    // Liberar memoria
    imagedestroy($thumbnail);
    imagedestroy($imagenOriginal);

    return $nombreThumbnail;
}

// PROCESAR LA CARGA

// conexión a la base de datos
include "../config.php";
$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["evidencia"]["error"] == 0) {

        $fileTmpPath = $_FILES['evidencia']['tmp_name'];
        $fileName = $_FILES['evidencia']['name'];
        $fileSize = $_FILES['evidencia']['size'];
        $fileType = $_FILES['evidencia']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

        if (in_array($fileExtension, $allowedfileExtensions)) {

            $uploadFileDir = "\\xampp\\htdocs\\xampp\\atn\\evidencias\\";
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {

                // ok
                echo "Cargado correctamente: -";

                // Verificar si es un archivo de imagen antes de generar la miniatura
                if (in_array($fileExtension, array('jpg', 'jpeg', 'gif', 'png'))) {
                    generarThumbnail($dest_path, $uploadFileDir . "thumbs");
                }

                $idSolicitud = $_POST['id'];
                $comentarios = $_POST['comentarios'];
                $tipoSolicitud = $_POST['tipo_solicitud'];
                $tipoEvidencia = 0;

                $sqlQuery1 = "INSERT INTO evidencias VALUES (null, :archivo, :tipoEvidencia, :comentarios, 0);";
                $stmt1 = $conn->prepare($sqlQuery1);
                $stmt1->bindParam(':archivo', $newFileName);
                $stmt1->bindParam(':tipoEvidencia', $tipoEvidencia);
                $stmt1->bindParam(':comentarios', $comentarios);
                if ($stmt1->execute()) {
                    echo "insert evidencias ok \n\n";
                }

                $idEvidenciaInsertada = $conn->lastInsertId();

                $sqlQuery2 = "INSERT INTO evidencias_solicitudes VALUES (null, :solicitud, :evidencia);";
                $stmt2 = $conn->prepare($sqlQuery2);
                $stmt2->bindParam(':solicitud', $idSolicitud);
                $stmt2->bindParam(':evidencia', $idEvidenciaInsertada);
                if ($stmt2->execute()) {
                    echo "insert evidencias_solicitudes ok \n\n";
                }

                // REDIRIGIR
                if ($tipoSolicitud == "colectiva") {
                    header("Location: ../index.php?page=Detalles-solicitud-colectiva&id=" . $idSolicitud . "&evidencias=0");
                } else {
                    header("Location: ../index.php?page=Detalles-solicitud-individual&id=" . $idSolicitud . "&evidencias=0");
                }

            } else {
                echo "Error al mover el archivo.";
            }

        } else {
            echo "extensión no valida";
            $idSolicitud = $_POST['id'];
            $tipoSolicitud = $_POST['tipo_solicitud'];
            // REDIRIGIR
            if ($tipoSolicitud == "colectiva") {
                header("Location: ../index.php?page=Detalles-solicitud-colectiva&id=" . $idSolicitud . "&evidencias=0&error_evidencia=true");
            } else {
                header("Location: ../index.php?page=Detalles-solicitud-individual&id=" . $idSolicitud . "&evidencias=0&error_evidencia=true");
            }
        }

    } else {

        echo "Error al cargar el archivo.";
    }
}
?>
