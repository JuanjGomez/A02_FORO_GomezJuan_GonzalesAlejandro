<?php
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: ../index.php');
        exit;
    } else {
        require_once 'conexion.php';
        $username = htmlspecialchars(trim($_POST['username']));
        $pwd = htmlspecialchars(trim($_POST['pwd']));
        $sqlVerfUser = "SELECT * FROM tbl_usuarios WHERE username_usu = :username_usu";
        $stmtVerfUser = $conn->prepare($sqlVerfUser);
        $stmtVerfUser->bindParam(':username_usu', $username);
        $stmtVerfUser->execute();
        
    }