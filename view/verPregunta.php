<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:../index.php');
        exit();
    }
    require_once '../process/conexion.php';

    // Recoge la id de la publicacion
    $idPregunta = htmlspecialchars(trim($_POST['idPregunta']));

    // Consulta para ver la pregunta
    try{
        $sqlPregunta = "SELECT * FROM tbl_preguntas WHERE id_preg = :id_preg";
        $stmtPregunta = $conn->prepare($sqlPregunta);
        $stmtPregunta->bindParam(':id_preg', $idPregunta);
        $stmtPregunta->execute();
        $pregunta = $stmtPregunta->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>PUBLICACION</h1>
    
</body>
</html>