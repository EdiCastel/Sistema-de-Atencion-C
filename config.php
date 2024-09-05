<?php

    $params = [
        "database" => "bd_ac",
        "host" => "localhost",
        "port" => 3306,
        "username" => "root",
        "password" => "1234"
    ];

    function formatearFolio($idElemento, $anio) {
        return sprintf("%'.05d", $idElemento) . "/" . $anio;
    }

    function getConnection() {
        global $params;
        try {
            $dsn = "mysql:host=".$params['host'].";dbname=".$params["database"];
            $dbh = new PDO($dsn, $params['username'], $params['password']);
            return $dbh;
        } catch (PDOException $e){
            header("Location: error.php");
        }
    }

?>