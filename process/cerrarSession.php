<?php
    session_start();
    if(isset($_SESSION['id']) && $_SESSION['id']){
        unset($_SESSION['id']);
    }
    session_destroy();
    header('Location: ../index.php');
    exit();