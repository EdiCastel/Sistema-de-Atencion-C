<?php

    include "../config.php";
    $conn = getConnection();

    $respuesta = [
        'curp_encontrada' => 0
    ];

    if (isset($_GET['curp'])) {

        $curp = $_GET['curp'];

        $sqlQuery1 = "SELECT c.id_ciudadano, c.nombre, c.apellido_paterno, c.apellido_materno, l.nombre as 'localidad' FROM ciudadanos c, localidades l WHERE l.id_localidad = c.id_localidad AND curp = :curp";
        $stmt1 = $conn->prepare($sqlQuery1);
        $stmt1 -> bindParam(':curp', $curp);
        $stmt1 -> execute();
        $datos_ciudadano = $stmt1 -> fetch(PDO::FETCH_ASSOC);

        if ($stmt1->rowCount() > 0) {
            $respuesta['curp_encontrada'] = 1;
            $respuesta['ciudadano'] = $datos_ciudadano;
        } 

    } else {
        echo "No hay parámetro CURP.";
    }

    echo json_encode($respuesta, JSON_PRETTY_PRINT);

?>