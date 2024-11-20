<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "bd_foro";

    try{
        $conn = new PDO("mysql:host=$host; dbname=$db", $user, $pass);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }