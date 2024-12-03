<?php
session_start();
require_once '../process/conexion.php';

// Verifica si se ha enviado un ID de usuario
if (!isset($_POST['idUsuario'])) {
    header("location:verPerfil.php");
}

$idUsuario = $_POST['idUsuario'];

if(isset($_SESSION['id']) && $_SESSION['id']){
    $idActual = $_SESSION['id'];
}

// Consulta datos del usuario
try {
    $sqlUsuario = "SELECT username_usu, nombre_real, email_usu FROM tbl_usuarios WHERE id_usu = :idUsuario";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->execute(['idUsuario' => $idUsuario]);
    $usuario = $stmtUsuario->fetch(mode: PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("location:verPerfil.php");
    }

    // Consulta estado de la relación
    if(isset($_SESSION['id']) && $_SESSION['id']){
        $sqlRelacion = "SELECT estado_soli FROM tbl_solicitud
                        WHERE (id_usuario_uno = :idActual AND id_usuario_dos = :idUsuario)
                        OR (id_usuario_uno = :idUsuario AND id_usuario_dos = :idActual)";
        $stmtRelacion = $conn->prepare($sqlRelacion);
        $stmtRelacion->execute(['idActual' => $idActual, 'idUsuario' => $idUsuario]);
        $relacion = $stmtRelacion->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?php echo htmlspecialchars($usuario['username_usu']); ?></title>
    <link rel="stylesheet" href="../styles/verPerfil.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <a href="../index.php"><button class="btn btn-danger btn-back">VOLVER</button></a>
    <div class="container">
        <h1>Perfil de <?php echo htmlspecialchars($usuario['username_usu']); ?></h1>
        <p>Nombre: <?php echo htmlspecialchars($usuario['nombre_real']); ?></p>
        <p>Email: <?php echo htmlspecialchars($usuario['email_usu']); ?></p>

        <?php if(isset($relacion)) : ?>
            <?php if ($relacion): ?>
                <!-- Si hay relación, no se muestra la opción de enviar solicitud -->
                <?php if ($relacion['estado_soli'] === 'pendiente' && $idActual !== $idUsuario): ?>
                    <p>Solicitud pendiente. Recuerda: Gestiona tus propias solicitudes en <a href="solicitudes.php">Mis Solicitudes</a>.</p>
                <?php elseif ($relacion['estado_soli'] === 'aceptado'): ?>
                    <p>Son amigos. <a href="chats.php?id=<?php echo $idUsuario; ?>">Chatear</a></p>
                <?php else: ?>
                    <p>Solicitud rechazada o pendiente.</p>
                <?php endif; ?>
            <?php else: ?>
                <!-- Si no hay relación, se muestra la opción de enviar solicitud -->
                <?php
                    echo isset($_SESSION['id']) ? "<form method='POST' action='../process/enviarSolicitud.php'>
                        <input type='hidden' name='idUsuario' value='$idUsuario'>
                        <button type='submit'>Enviar Solicitud de Amistad</button>
                    </form>" : "";
                ?>
            <?php endif; ?>
        <?php endif;?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0d5Xy4pt7rF4P6MQb9yX5dmb2K7/PUhZ5VV1VmJ5ZV/gxf8w" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
</body>
</html>
