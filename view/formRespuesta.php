<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location:../index.php');
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:../index.php');
        exit();
    } else {
        $idPregunta = htmlspecialchars(trim($_POST['idPregunta']));
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
    <form method="POST" action="../process/crearRespuesta.php">
        <input type="hidden" name="idPregunta" id="IdPregunta" value="<?php echo $idPregunta; ?>">
        <label for="respuesta">Introduce tu respuesta:<input type="textarea" name="respuesta" id="respuesta"></label>
        <p id="errorRespuesta" class="errorRespuesta"></p>
        <input type="submit" id="boton" value="Enviar respuesta">
    </form>
</body>
</html>