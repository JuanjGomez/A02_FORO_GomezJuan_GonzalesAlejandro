<?php
    if(isset($_GET['query'])){
        try{
            // Consulta para buscar 
            $preguntas = htmlspecialchars(trim($_GET['query']));
            $sqlBusquedaPreguntas = "SELECT *, (SELECT COUNT(*) FROM tbl_respuestas r WHERE r.id_preg) as num_respuestas FROM tbl_preguntas p WHERE titulo_preg LIKE :titulo_preg";
            $stmtBusquedaPreguntas = $conn->prepare($sqlBusquedaPreguntas);
            $searchTerm = "%" . $preguntas . "%";
            $stmtBusquedaPreguntas->bindParam(':titulo_preg', $searchTerm, PDO::PARAM_STR);
            $stmtBusquedaPreguntas->execute();
            $resultadosPreguntas = $stmtBusquedaPreguntas->fetchAll(PDO::FETCH_ASSOC);

            // Consulta para buscar usuarios
            $sqlBusquedaUsuarios = "SELECT * FROM tbl_usuarios WHERE (username_usu LIKE :username_usu OR nombre_real LIKE :nombre_real);";
            $stmtBusquedaUsuarios = $conn->prepare($sqlBusquedaUsuarios);
            $usuarios = "%" . $preguntas . "%";
            $stmtBusquedaUsuarios->bindParam(':username_usu', $usuarios, PDO::PARAM_STR);
            $stmtBusquedaUsuarios->bindParam(':nombre_real', $usuarios, PDO::PARAM_STR);
            $stmtBusquedaUsuarios->execute();
            $resultadosUsuarios = $stmtBusquedaUsuarios->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo "Error: ". $e->getMessage();
            die();
        }
    }