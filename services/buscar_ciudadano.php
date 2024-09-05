<?php
    include "../config.php";
    $conn = getConnection();

    $respuesta = [
        'curp_encontrada' => 0,
        'ciudadano' => []
    ];
    
    if ($_SERVER["REQUEST_METHOD"] == 'GET') {
            
        $sqlQuery6 = "SELECT ci.id_ciudadano, ci.nombre, ci.apellido_paterno, ci.apellido_materno, co.id_comites 
        FROM ciudadanos ci, comites co, integrantes_comites ic 
        WHERE ic.id_ciudadano = ci.id_ciudadano 
        AND ic.id_comite = co.id_comites 
        AND co.id_comites = :id_comites";
        
        $stmt6 = $conn->prepare($sqlQuery6);
        $stmt6->bindParam(':id_comites', $_GET['id_comites']);
        $stmt6->execute();
        
        while ($datos_ciudadano = $stmt6->fetch(PDO::FETCH_ASSOC)) {
            $respuesta['curp_encontrada'] = 1;
            $respuesta['ciudadano'] = $datos_ciudadano;
        }      
        
        
    } else {
        echo "Acceso no autorizado.";
    }
    
    echo json_encode($respuesta, JSON_PRETTY_PRINT);
?>