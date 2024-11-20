<?php
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: ../index.php');
        exit();
    } else {
        require_once 'conexion.php';
        $username = htmlspecialchars(trim($_POST['username']));
        $nombreReal = htmlspecialchars(trim($_POST['nombreReal']));
        $email = htmlspecialchars(trim($_POST['email']));
        $pwd = htmlspecialchars(trim($_POST['pwd']));
        $pwdH = password_hash($pwd, PASSWORD_BCRYPT);
        $rol = htmlspecialchars(trim($_POST['rol']));

        try{
            $sqlSeguridad = "SELECT * FROM tbl_usuarios WHERE username_usu = :username_usu AND nombre_real = :nombre_real AND email_usu = :email_usu";


        $insertUser = "INSERT INTO tbl_usuarios VALUES (:username_usu, :nombre_real, :email_usu, :password_usu, :id_rol);";
        $stmtUser = $conn->prepare($insertUser);
        $stmtUser->bindParam(':username_usu', $username);
        $stmtUser->bindParam(':nombre_real', $nombreReal);
        $stmtUser->bindParam(':email_usu', $email);
        $stmtUser->bindParam(':password_usu', $pwdH);
        $stmtUser->bindParam(':id_rol', $rol);
        $stmtUser->execute();

        session_start();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header('Location:../view/inicio.php');
        exit();
        } catch (PDOException $e){
            echo "Error: ". $e->getMessage();
            die();
        }
    }