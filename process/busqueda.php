<?php
    require_once '../process/conexion.php';
    if($_GET['query']){
        // Consulta para buscar 
        $pregunas = htmlspecialchars(trim($_GET['query']));
        $sqlBusquedaPreguntas = "SELECT * FROM tbl_preguntas WHERE titulo_preg = :titulo_preg;";
        $stmtBusquedaPreguntas = $conn->prepare($sqlBusquedaPreguntas);
        $stmtBusquedaPreguntas->bindParam(':titulo_preg', $preguntas);
        $stmtBusquedaPreguntas->execute();

    }