<?php

    include "../config.php";
    $conn = getConnection();

    $estados = [];

    $sqlQuery1 = "SELECT * FROM estados;";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1 -> execute();

    while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
        array_push($estados, $row);
    }

    echo json_encode($estados, JSON_PRETTY_PRINT);

?>