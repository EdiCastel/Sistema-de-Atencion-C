<?php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getConnection();

    // Recibir datos del formulario
    $nombre = $_POST["nombre"];
    $departamento = $_POST['departamento'];
   

    // Insertar datos en la tabla tipos_apoyo
    $sql = "INSERT INTO tipos_apoyo VALUES (null, '$nombre', '$departamento', 0);";

    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        echo "¡Apoyo registrado correctamente!";

    } catch (PDOException $e) {
        echo "Error al registrar apoyo: " . $e->getMessage();
    }
} else {
    echo "Acceso no permitido";
}
?>
