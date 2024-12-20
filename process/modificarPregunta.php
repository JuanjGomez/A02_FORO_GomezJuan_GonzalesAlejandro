<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once '../process/conexion.php';


$_SESSION['preguntaId'] = isset($_GET['id']) && $_GET['id'] !== '' ? $_GET['id'] : $_SESSION['preguntaId'];

if (isset($_SESSION['preguntaId'])) {
    try {
        // Consultar la pregunta actual para modificarla
        $sql = "SELECT * FROM tbl_preguntas WHERE id_preg = :id_preg AND id_usu = :id_usu";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_preg', $_SESSION['preguntaId'], PDO::PARAM_INT);
        $stmt->bindParam(':id_usu', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pregunta) {
            echo "Pregunta no encontrada o no tienes permisos para editarla.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "ID de pregunta no proporcionado.";
    exit();
}

// Procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    try {
        // Actualizar la pregunta
        $sql = "UPDATE tbl_preguntas SET titulo_preg = :titulo, descripcion_preg = :descripcion WHERE id_preg = :id_preg";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id_preg', $_SESSION["preguntaId"], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../view/miPregunta.php');  // Redirigir después de actualizar
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Pregunta</title>
    <link rel="stylesheet" href="../styles/formBasico.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <a href="../view/miPregunta.php"><button class="btn btn-danger">VOLVER</button></a>
    <div class="container mt-5">
        <form method="POST" action="modificarPregunta.php">
            <input type="hidden" name="id_preg" value="<?php echo $pregunta['id_preg']; ?>">
            <h2><strong>Modificar Pregunta</strong></h2>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($pregunta['titulo_preg']); ?>">
                <p id="errorTitulo" class="error"></p>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($pregunta['descripcion_preg']); ?></textarea>
                <p id="errorDescripcion" class="error"></p>
            </div>
            <input type="submit" id="boton" class="btn btn-primary" disabled></button>
        </form>
    </div>
    <script src="../validations/js/verifPregunta.js"></script>
</body>
</html>
