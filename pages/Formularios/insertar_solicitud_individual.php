<?php

    include "../../config.php";
    $conn = getConnection();

    // recorrer lista de ciudadanos. guardar ids existentes e inserta nuevos.
    $ids_ciudadanos = [];
    foreach ($_POST['ciudadanos'] as $ciudadano) {
        if(isset($ciudadano['ciudadano_existente'])) {
            // guarda ciudadanos exsitentes
            array_push($ids_ciudadanos, $ciudadano['id_ciudadano']);
        } else {
            // inserta ciudadanos nuevos y guarda los id insertados.
            $sql = "INSERT INTO ciudadanos VALUES (
                null,
                :nombre,
                :app,
                :apm,
                :sexo,
                :curp,
                :seccion,
                :id_localidad,
                :direccion,
                :referencia,
                :telefono,
                0
            );";

            $stmt1 = $conn->prepare($sql);
            $stmt1 -> bindParam(':nombre', $ciudadano['nombre']);
            $stmt1 -> bindParam(':app', $ciudadano['apellido_paterno']);
            $stmt1 -> bindParam(':apm', $ciudadano['apellido_materno']);
            $stmt1 -> bindParam(':sexo', $ciudadano['sexo']);
            $stmt1 -> bindParam(':curp', $ciudadano['curp']);
            $stmt1 -> bindParam(':seccion', $ciudadano['seccion_electoral']);
            $stmt1 -> bindParam(':id_localidad', $ciudadano['id_localidad']);
            $stmt1 -> bindParam(':direccion', $ciudadano['direccion']);
            $stmt1 -> bindParam(':referencia', $ciudadano['referencia']);
            $stmt1 -> bindParam(':telefono', $ciudadano['telefono']);

            $stmt1 -> execute();

            $id_insertado = $conn->lastInsertId();
            array_push($ids_ciudadanos, $id_insertado);

        }
    }

    // print_r($ids_ciudadanos);


    // insertar la solicitud.
    foreach ($ids_ciudadanos as $id_ciudadano) {
        $sql = "INSERT INTO solicitudes VALUES (
            null,
            '000000',
            0,
            :id_ciudadano,
            0,
            :descripcion_solicitud,
            1,
            now(),
            :tipo_apoyo,
            :id_departamento,
            :cantidad_beneficiarios,
            0
        );";
        $stmt1 = $conn->prepare($sql);
        $stmt1 -> bindParam(':id_ciudadano', $id_ciudadano);
        $stmt1 -> bindParam(':descripcion_solicitud', $_POST['descripcion_solicitud']);
        $stmt1 -> bindParam(':tipo_apoyo', $_POST['tipo_apoyo']);
        $stmt1 -> bindParam(':id_departamento', $_POST['departamento']);
        $stmt1 -> bindParam(':cantidad_beneficiarios', $_POST['beneficiarios']);
        $stmt1 -> execute();
        $idSolicitud = $conn->lastInsertId();

    }
    
    $idSolicitud = $conn->lastInsertId();
    $sqlFolio = "UPDATE solicitudes SET folio_seguimiento = concat(year(now()),lpad(:id,4,'0')) WHERE id_solicitud = :id;";
    $stmt1 = $conn->prepare($sqlFolio);
    $stmt1 -> bindParam(':id', $idSolicitud);
    $stmt1 -> execute();
    
    $respuesta = [
        "id_solicitud" => $idSolicitud
    ];
    echo json_encode($respuesta, JSON_PRETTY_PRINT);
    
    $sqlh_estado = "INSERT INTO historial_estados VALUES(
        null,
        :id_solicitud,
        now(),
        1        
    )";
    $stmt1 = $conn->prepare($sqlh_estado);
    $stmt1 -> bindParam(':id_solicitud', $idSolicitud);
    $stmt1 -> execute();

?>