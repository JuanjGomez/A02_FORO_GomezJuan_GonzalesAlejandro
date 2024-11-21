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
    <title>Document</title>
</head>
<body>
    <form method="POST" action="">
        <label for="titulo">Introduce un titulo para tu pregunta:<input type="text" name="titulo" id="titulo"></label>
        <p id="errorTitulo" class="error"></p>
        <label for="descripcion">Introduce una descripcion para tu pregunta:<textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea></label>
        <p id="errorDescripcion" class="error"></p>
        <input type="submit" name="boton" value="Publicar" disabled>
    </form>
    <script src="../validations/js/verifPregunta.js"></script>
</body>
</html>