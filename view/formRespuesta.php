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
    require_once '../process/conexion.php';
    try{
        $sqlVerRespuesta = "SELECT * FROM tbl_preguntas WHERE id_preg = :id_preg";
        $stmtVerRespuesta = $conn->prepare($sqlVerRespuesta);
        $stmtVerRespuesta->bindParam(':id_preg', $idPregunta);
        $stmtVerRespuesta->execute();
        $resultados = $stmtVerRespuesta->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e){
        echo "Error: ". $e->getMessage();
        die();
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
    <form method="POST" action="verPregunta.php">
        <input type="hidden" name="idPregunta" id="idPregunta" value="<?php echo $idPregunta; ?>">
        <button type="submit" class="btn btn-danger">VOLVER</button>
        <div class="card">
            <h5><?php echo $resultados['titulo_preg']; ?></h5>
            <p><?php echo $resultados['descripcion_preg'];?></p>
        </div>
    </form>
    <form method="POST" action="../process/crearRespuesta.php">
        <input type="hidden" name="idPregunta" id="idPregunta" value="<?php echo $idPregunta; ?>">
        <label for="respuesta">Introduce tu respuesta:<textarea name="respuesta" id="respuesta"></textarea></label>
        <p id="errorRespuesta" class="error"></p>
        <input type="submit" id="boton" value="Enviar respuesta" disabled>
    </form>
    <script src="../validations/js/verifRespuesta.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>