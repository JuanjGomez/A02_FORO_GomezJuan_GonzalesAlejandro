<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:../index.php');
        exit();
    }
    if(isset($_SESSION['respuestaSubida']) && $_SESSION['respuestaSubida']){
        echo "<script>let respuestaSubida = true;</script>";
        unset($_SESSION['respuestaSubida']);
    }
    if(isset($_SESSION['preguntaCreada']) && $_SESSION['preguntaCreada']){
        echo "<script>let preguntaCreada = true;</script>";
        unset($_SESSION['preguntaCreada']);
    }
    require_once '../process/conexion.php';

    // Recoge la id de la publicacion
    $idPregunta = htmlspecialchars(trim($_POST['idPregunta']));

    // Consulta para ver la pregunta
    try{
        $sqlPregunta = "SELECT * FROM tbl_preguntas p INNER JOIN tbl_usuarios u ON p.id_usu = u.id_usu WHERE id_preg = :id_preg";
        $stmtPregunta = $conn->prepare($sqlPregunta);
        $stmtPregunta->bindParam(':id_preg', $idPregunta);
        $stmtPregunta->execute();
        $pregunta = $stmtPregunta->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        die();
    }
    try{
        // Consulta para ver las respuestas
        $sqlRespuesta = "SELECT * FROM tbl_respuestas r INNER JOIN tbl_usuarios u ON r.id_usu = u.id_usu WHERE id_preg = :id ORDER BY r.fecha_resp_usu DESC";
        $stmtRespuestas = $conn->prepare($sqlRespuesta);
        $stmtRespuestas->bindParam(':id', $idPregunta);
        $stmtRespuestas->execute();
        $respuestas = $stmtRespuestas->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Error: ". $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/detallePregunta.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detalle de Pregunta</title>
</head>
<body>
    <div class="container">
        <a href="../index.php"><button class="btn btn-danger btn-back">VOLVER</button></a>
        <h1>PUBLICACIÓN</h1>

        <!-- Contenedor de la pregunta -->
        <div class="question">
            <?php
                if ($pregunta) {
                    echo "
                        <h3>" . htmlspecialchars($pregunta['titulo_preg']) . "</h3>
                        <p>" . htmlspecialchars($pregunta['descripcion_preg']) . "</p>
                        <p><strong>Creado por:</strong> " . htmlspecialchars($pregunta['username_usu']) . "</p>
                        <p><strong>Fecha de creación:</strong> " . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>
                    ";
                }
            ?>
        </div>

        <!-- Formulario de respuesta (si el usuario está logueado y no es el autor de la pregunta) -->
        <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $pregunta['id_usu']): ?>
            <form method="POST" action="formRespuesta.php">
                <input type="hidden" name="idPregunta" id="idPregunta" value="<?php echo htmlspecialchars($idPregunta); ?>">
                <input type="submit" value="Responder">
            </form>
        <?php endif; ?>

        <!-- Contenedor de respuestas -->
        <h3>RESPUESTAS</h3>
        <div>
            <?php
                if ($respuestas) {
                    foreach ($respuestas as $respuesta) {
                        echo "
                            <div class='answer'>
                                <p>" . htmlspecialchars($respuesta['contenido_resp']) . "</p>
                                <p><strong>Creado por:</strong> " . htmlspecialchars($respuesta['username_usu']) . "</p>
                                <p><strong>Fecha de creación:</strong> " . htmlspecialchars($respuesta['fecha_resp_usu']) . "</p>
                            </div>
                        ";
                    }
                } else {
                    echo "<p>No hay respuestas para esta pregunta</p>";
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        if (typeof respuestaSubida !== 'undefined' && respuestaSubida) {
            Swal.fire({
                title: 'Respuesta subida',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        }

        if (typeof preguntaCreada !== 'undefined' && preguntaCreada) {
            Swal.fire({
                title: 'Pregunta creada',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
</body>
</html>
