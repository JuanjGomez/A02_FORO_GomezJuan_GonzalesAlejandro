<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ../index.php');
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location:../view/formPregunta.php');
        exit();
    } else {
        require_once 'conexion.php';

        $titulo = htmlspecialchars(trim($_POST['titulo']));
        $descripcion = htmlspecialchars(trim($_POST['descripcion']));
        $id = htmlspecialchars(trim($_SESSION['id']));

        try{
            // Se verifica si el usuario ya existe

            // Si no hay resultados, se procede a insertar el nuevo usuario
            $insertUser = "INSERT INTO tbl_preguntas (titulo_preg, descripcion_preg, id_usu) VALUES (:titulo_preg, :descripcion_preg, :id_usu);";
            $stmtUser = $conn->prepare($insertUser);
            $stmtUser->bindParam(':titulo_preg', $titulo);
            $stmtUser->bindParam(':descripcion_preg', $descripcion);
            $stmtUser->bindParam(':id_usu', $id);
            $stmtUser->execute();

            header('Location:../index.php');
            exit();
        } catch (PDOException $e){
            echo "Error: ". $e->getMessage();
            die();
        }
    }

        
    