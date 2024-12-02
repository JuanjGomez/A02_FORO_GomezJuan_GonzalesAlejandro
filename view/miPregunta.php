<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');  // Redirige si el usuario no ha iniciado sesión.
    exit();
}

require_once '../process/conexion.php';

$userId = $_SESSION['id'];  // ID del usuario actual

try {
    // Consulta para obtener las preguntas del usuario
    $sql = "SELECT p.id_preg, p.titulo_preg, p.descripcion_preg, p.fecha_publicacion 
            FROM tbl_preguntas p
            WHERE p.id_usu = :id_usu";  // Asegúrate de que `id_usuario` está en la tabla `tbl_preguntas`
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usu', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/inicio.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mis Preguntas</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="formPregunta.php">Crear Pregunta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../process/cerrarSession.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Mis Preguntas</h2>
        
        <?php if (count($preguntas) > 0): ?>
            <div class="list-group">
                <?php foreach ($preguntas as $pregunta): ?>
                    <div class="list-group-item">
                        <h5 class="mb-1"><?php echo htmlspecialchars($pregunta['titulo_preg']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($pregunta['descripcion_preg']); ?></p>
                        <small>Fecha de publicación: <?php echo htmlspecialchars($pregunta['fecha_publicacion']); ?></small>
                        <br>
                        <form method="POST" action="verPregunta.php">
                            <input type="hidden" name="idPregunta" value="<?php echo $pregunta['id_preg']; ?>">
                            <button type="submit" class="btn btn-info btn-sm mt-2">Ver Pregunta</button>
                        </form>
                        <!-- Botones para modificar y eliminar -->
                        <a href="../process/modificarPregunta.php?id=<?php echo $pregunta['id_preg']; ?>" class="btn btn-warning btn-sm mt-2">Modificar</a>
                        <a href="../process/eliminarPregunta.php?id=<?php echo $pregunta['id_preg']; ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('¿Estás seguro de eliminar esta pregunta?');">Eliminar</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No has realizado ninguna pregunta aún.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
