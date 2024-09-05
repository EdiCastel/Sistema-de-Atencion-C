<?php

    include "../../config.php";
    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtener datos del formulario
        $id_ciudadano = $_POST['id_ciudadano'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $sexo = $_POST['sexo'];
        $curp = $_POST['curp'];
        $seccion_electoral = $_POST['seccion_electoral'];
        $id_localidad = $_POST['id_localidad'];
        $direccion = $_POST['direccion'];
        $referencia = $_POST['referencia'];
        $telefono = $_POST['telefono'];
        
        //Actualiza los datos en la tabla ciudadanos          
        $sql = "UPDATE ciudadanos SET 
        nombre = :nombre,
        apellido_paterno = :apellido_paterno,
        apellido_materno = :apellido_materno,
        sexo = :sexo,
        curp = :curp,
        seccion_electoral = :seccion_electoral,
        id_localidad = :id_localidad,
        direccion = :direccion,
        referencia = :referencia,
        telefono = :telefono
        WHERE id_ciudadano = :id_ciudadano";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_ciudadano', $id_ciudadano);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':apellido_materno', $apellido_materno);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":curp", $curp);
        $stmt->bindParam(":seccion_electoral", $seccion_electoral);
        $stmt->bindParam(":id_localidad", $id_localidad);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":referencia", $referencia);
        $stmt->bindParam(":telefono", $telefono);

        // Actualizar los datos en la base de datos
        if ($stmt->execute()) {
            echo "Ciudadano actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario.";
        }
    } else {
        echo "Acceso no autorizado.";
    }

?>
