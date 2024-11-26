<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: ../index.php');
        exit();
    } else {
        require_once 'conexion.php';

        // Se reciben los datos del formulario
        $username = htmlspecialchars(trim($_POST['username']));
        $nombreReal = htmlspecialchars(trim($_POST['nombreReal']));
        $email = htmlspecialchars(trim($_POST['email']));
        $pwd = htmlspecialchars(trim($_POST['pwd']));
        $pwdH = password_hash($pwd, PASSWORD_BCRYPT);
        $rol = htmlspecialchars(trim($_POST['rol']));

        try{
            // Se verifica si el usuario ya existe
            $sqlSeguridad = "SELECT * FROM tbl_usuarios WHERE username_usu = :username_usu";
            $stmtSeguridad = $conn->prepare($sqlSeguridad);
            $stmtSeguridad->bindParam(':username_usu', $username);
            $stmtSeguridad->execute();
            $resultados = $stmtSeguridad->fetch(PDO::FETCH_ASSOC);

            // Se verifica si hay un usuario que existe y es igual a el
            if($resultados){  //cambiar esto
                    $_SESSION['identico'] = true;
                    header('Location: ../view/formRegistro.php');
                    exit();
                
            }

            // Si no hay resultados, se procede a insertar el nuevo usuario
            $insertUser = "INSERT INTO tbl_usuarios (username_usu, nombre_real, email_usu, password_usu, id_rol) VALUES (:username_usu, :nombre_real, :email_usu, :password_usu, :id_rol);";
            $stmtUser = $conn->prepare($insertUser);
            $stmtUser->bindParam(':username_usu', $username);
            $stmtUser->bindParam(':nombre_real', $nombreReal);
            $stmtUser->bindParam(':email_usu', $email);
            $stmtUser->bindParam(':password_usu', $pwdH);
            $stmtUser->bindParam(':id_rol', $rol);
            $stmtUser->execute();

            // Se guarda el id del insert de usuario que se hizo
            $lastId = $conn->lastInsertId();

            // Se da acceso al usuario
            $_SESSION['loginSuccess'] = true;
            $_SESSION['id'] = $lastId;
            $_SESSION['username'] = $username;
            header('Location:../index.php');
            exit();
        } catch (PDOException $e){
            echo "Error: ". $e->getMessage();
            die();
        }
    }