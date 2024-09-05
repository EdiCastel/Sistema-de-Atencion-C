<?php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getConnection();

    // Recibir datos del formulario
    $usuario = $_POST["usuario"];
    $contraseña = hash('sha256', $_POST["contraseña"]); // Aplicar hash SHA-256
    $nombre = $_POST["nombre"];
    $apellido_paterno = $_POST["apellido_paterno"];
    $apellido_materno = $_POST["apellido_materno"];
    $departamento = $_POST["departamento"];
    $tipo_usuario = $_POST["tipo_usuario"];
   

    // Insertar datos en la tabla usuarios
    $sql = "INSERT INTO usuarios VALUES (null, '$usuario', '$contraseña', '$nombre', '$apellido_paterno', '$apellido_materno', $departamento, $tipo_usuario, 1, 0);";

    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        echo "¡Usuario registrado correctamente!";

    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
} else {
    echo "Acceso no permitido";
}
?>
