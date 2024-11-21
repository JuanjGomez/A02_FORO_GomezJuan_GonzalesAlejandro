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
        
    }