<?php

    include "../config.php";
    $conn = getConnection();

    $idDepto = $_GET['id_departamento'];

    $tipos = [];

    $sqlQuery1 = "SELECT * FROM tipos_apoyo WHERE id_departamento = :id AND deleted = 0;";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1 -> bindParam(':id', $idDepto);
    $stmt1 -> execute();

    while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
        array_push($tipos, $row);
    }

    echo json_encode($tipos, JSON_PRETTY_PRINT);

?>