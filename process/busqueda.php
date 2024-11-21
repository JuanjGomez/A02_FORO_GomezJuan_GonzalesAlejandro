<?php
    require_once '../process/conexion.php';
    if($_GET['query']){
        try{
            // Consulta para buscar 
            $preguntas = htmlspecialchars(trim($_GET['query']));
            $sqlBusquedaPreguntas = "SELECT * FROM tbl_preguntas WHERE titulo_preg = :titulo_preg;";
            $stmtBusquedaPreguntas = $conn->prepare($sqlBusquedaPreguntas);
            $stmtBusquedaPreguntas->bindParam(':titulo_preg', $preguntas);
            $stmtBusquedaPreguntas->execute();
            $resultadosPreguntas = $stmtBusquedaPreguntas->fetch(PDO::FETCH_ASSOC);

            // Consulta para buscar usuarios
            $sqlBusquedaUsuarios = "SELECT * FROM tbl_usuarios WHERE (username_usu = :username_usu OR nombre_real = :nombre_real);";
            $stmtBusquedaUsuarios = $conn->prepare($sqlBusquedaUsuarios);
            $stmtBusquedaUsuarios->bindParam(':username_usu', $preguntas);
            $stmtBusquedaUsuarios->bindParam(':nombre_real', $preguntas);
            $stmtBusquedaUsuarios->execute();
            $resultadosUsuarios = $stmtBusquedaUsuarios->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo "Error: ". $e->getMessage();
            die();
        }
    }