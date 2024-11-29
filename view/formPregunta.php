<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ../index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/formBasico.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <a href="../index.php"><button class="btn btn-danger">VOLVER</button></a>
    <form method="POST" action="../process/crearPregunta.php">
        <h1><strong>NUEVA PREGUNTA</strong></h1>
        <label for="titulo">Introduce un titulo para tu pregunta:</label>
        <input type="text" name="titulo" id="titulo">
        <p id="errorTitulo" class="error"></p>
        <label for="descripcion">Introduce una descripcion para tu pregunta:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
        <p id="errorDescripcion" class="error"></p>
        <input type="submit" id="boton" value="Publicar" disabled>
    </form>
    <script src="../validations/js/verifPregunta.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>