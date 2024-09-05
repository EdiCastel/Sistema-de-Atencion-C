<?php

include "../../config.php";
$conn = getConnection();

// recorrer lista de ciudadanos. guardar ids existentes e insertar nuevos.
$ids_ciudadanos_comite = [];

if (isset($_POST['ciudadanos']) && is_array($_POST['ciudadanos']) && count($_POST['ciudadanos']) > 0) {
    foreach ($_POST['ciudadanos'] as $ciudadano) {
        if (isset($ciudadano['ciudadano_existente'])) {
            // guarda ciudadanos existentes
            array_push($ids_ciudadanos_comite, $ciudadano['id_ciudadano']);
        } else {
            // inserta ciudadanos nuevos y guarda los id insertados.
            $sql = "INSERT IGNORE INTO ciudadanos VALUES (
                null,
                :nombre,
                :apellido_paterno,
                :apellido_materno,
                :sexo,
                :curp,
                :seccion_electoral,
                :id_localidad,
                :direccion,
                :referencia,
                :telefono,
                0
            )";
    
            $stmt1 = $conn->prepare($sql);
            $stmt1->bindParam(':nombre', $ciudadano['nombre']);
            $stmt1->bindParam(':apellido_paterno', $ciudadano['apellido_paterno']);
            $stmt1->bindParam(':apellido_materno', $ciudadano['apellido_materno']);
            $stmt1->bindParam(':sexo', $ciudadano['sexo']);
            $stmt1->bindParam(':curp', $ciudadano['curp']);
            $stmt1->bindParam(':seccion_electoral', $ciudadano['seccion_electoral']);
            $stmt1->bindParam(':id_localidad', $ciudadano['id_localidad']);
            $stmt1->bindParam(':direccion', $ciudadano['direccion']);
            $stmt1->bindParam(':referencia', $ciudadano['referencia']);
            $stmt1->bindParam(':telefono', $ciudadano['telefono']);
    
            $stmt1->execute();
    
            $id_insertado = $conn->lastInsertId();
            array_push($ids_ciudadanos_comite, $id_insertado);
        }
    }
    
    // insertar el comité
    $sql = "UPDATE comites SET
    nombre_comite = :nombre_comite,
    detalles_comite = :detalles_comite,
    id_localidad = :id_localidad
    WHERE id_comites = :id_comites;";
    
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':id_comites', $_POST['id_comite']);
    $stmt1->bindParam(':nombre_comite', $_POST['nombre_comite']);
    $stmt1->bindParam(':detalles_comite', $_POST['detalles_comite']);
    $stmt1->bindParam(':id_localidad', $_POST['localidad_comite']);
    
    $stmt1->execute();
    
    $id_comite = $_POST['id_comite'];
    
    // insertar integrantes del comité
    foreach ($ids_ciudadanos_comite as $id) {
    
    $sql = "SELECT COUNT(*) FROM integrantes_comites WHERE id_ciudadano = :id_ciudadano AND id_comite = :id_comite;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_ciudadano', $id);
    $stmt->bindParam(':id_comite', $id_comite);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Si no está asociado, insertar el nuevo registro
        $sql = "INSERT IGNORE INTO integrantes_comites VALUES(
            null,
            :id_ciudadano,
            :id_comite
        );";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':id_ciudadano', $id);
        $stmt1->bindParam(':id_comite', $id_comite);
        $stmt1->execute();
    }
    }
    
    // actualizar la solicitud.
    $sql = "UPDATE solicitudes SET
    descripcion_solicitud = :descripcion_solicitud,
    id_tipo_apoyo = :id_tipo_apoyo,
    id_departamento_asignado = :id_departamento_asignado,
    beneficiarios = :beneficiarios 
    WHERE id_solicitud = :id_solicitud;";
    
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':id_solicitud', $_POST['id_solicitud']);
    $stmt1->bindParam(':descripcion_solicitud', $_POST['descripcion_solicitud']);
    $stmt1->bindParam(':id_tipo_apoyo', $_POST['tipo_apoyo']);
    $stmt1->bindParam(':id_departamento_asignado', $_POST['departamento']);
    $stmt1->bindParam(':beneficiarios', $_POST['beneficiarios']);
    $stmt1->execute();
    
    $idSolicitud = $_POST['id_solicitud'];
    
    
    $respuesta = [
    "id_solicitud" => $idSolicitud
    ];
    
    echo json_encode($respuesta, JSON_PRETTY_PRINT);
    
    $sqlh_estado = "INSERT IGNORE INTO historial_estados VALUES(
    null,
    :id_solicitud,
    now(),
    :id_estado_solicitud        
    )";
    $stmt1 = $conn->prepare($sqlh_estado);
    $stmt1->bindParam(':id_solicitud', $idSolicitud);
    $stmt1->bindParam(':id_estado_solicitud', $_POST['id_estado_solicitud']);
    $stmt1->execute();
} else {
    // insertar el comité
    $sql = "UPDATE comites SET
    nombre_comite = :nombre_comite,
    detalles_comite = :detalles_comite,
    id_localidad = :id_localidad
    WHERE id_comites = :id_comites;";
    
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':id_comites', $_POST['id_comite']);
    $stmt1->bindParam(':nombre_comite', $_POST['nombre_comite']);
    $stmt1->bindParam(':detalles_comite', $_POST['detalles_comite']);
    $stmt1->bindParam(':id_localidad', $_POST['localidad_comite']);
    
    $stmt1->execute();
    
    $id_comite = $_POST['id_comite'];
    
    // insertar integrantes del comité
    foreach ($ids_ciudadanos_comite as $id) {
    
    $sql = "SELECT COUNT(*) FROM integrantes_comites WHERE id_ciudadano = :id_ciudadano AND id_comite = :id_comite;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_ciudadano', $id);
    $stmt->bindParam(':id_comite', $id_comite);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Si no está asociado, insertar el nuevo registro
        $sql = "INSERT IGNORE INTO integrantes_comites VALUES(
            null,
            :id_ciudadano,
            :id_comite
        );";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':id_ciudadano', $id);
        $stmt1->bindParam(':id_comite', $id_comite);
        $stmt1->execute();
    }
    }
    
    // actualizar la solicitud.
    $sql = "UPDATE solicitudes SET
    descripcion_solicitud = :descripcion_solicitud,
    id_tipo_apoyo = :id_tipo_apoyo,
    id_departamento_asignado = :id_departamento_asignado,
    beneficiarios = :beneficiarios 
    WHERE id_solicitud = :id_solicitud;";
    
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':id_solicitud', $_POST['id_solicitud']);
    $stmt1->bindParam(':descripcion_solicitud', $_POST['descripcion_solicitud']);
    $stmt1->bindParam(':id_tipo_apoyo', $_POST['tipo_apoyo']);
    $stmt1->bindParam(':id_departamento_asignado', $_POST['departamento']);
    $stmt1->bindParam(':beneficiarios', $_POST['beneficiarios']);
    $stmt1->execute();
    
    $idSolicitud = $_POST['id_solicitud'];
    
    
    $respuesta = [
    "id_solicitud" => $idSolicitud
    ];
    
    echo json_encode($respuesta, JSON_PRETTY_PRINT);
    
    $sqlh_estado = "INSERT IGNORE INTO historial_estados VALUES(
    null,
    :id_solicitud,
    now(),
    :id_estado_solicitud        
    )";
    $stmt1 = $conn->prepare($sqlh_estado);
    $stmt1->bindParam(':id_solicitud', $idSolicitud);
    $stmt1->bindParam(':id_estado_solicitud', $_POST['id_estado_solicitud']);
    $stmt1->execute();
}

?>
