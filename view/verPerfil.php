<?php
session_start();
require_once '../process/conexion.php';

// Verifica si se ha enviado un ID de usuario
if (!isset($_POST['idUsuario'])) {
    header("location:verPerfil.php");
}

$idUsuario = $_POST['idUsuario'];
$idActual = $_SESSION['id'];

// Consulta datos del usuario
try {
    $sqlUsuario = "SELECT username_usu, nombre_real, email_usu FROM tbl_usuarios WHERE id_usu = :idUsuario";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->execute(['idUsuario' => $idUsuario]);
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("location:verPerfil.php");
    }

    // Consulta estado de la relación
    $sqlRelacion = "SELECT estado_soli FROM tbl_solicitud
                    WHERE (id_usuario_uno = :idActual AND id_usuario_dos = :idUsuario)
                       OR (id_usuario_uno = :idUsuario AND id_usuario_dos = :idActual)";
    $stmtRelacion = $conn->prepare($sqlRelacion);
    $stmtRelacion->execute(['idActual' => $idActual, 'idUsuario' => $idUsuario]);
    $relacion = $stmtRelacion->fetch(PDO::FETCH_ASSOC);
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
</head>
<body>
    <h1>Perfil de <?php echo htmlspecialchars($usuario['username_usu']); ?></h1>
    <p>Nombre: <?php echo htmlspecialchars($usuario['nombre_real']); ?></p>
    <p>Email: <?php echo htmlspecialchars($usuario['email_usu']); ?></p>

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
        <form method="POST" action="../process/enviarSolicitud.php">
            <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
            <button type="submit">Enviar Solicitud de Amistad</button>
        </form>
    <?php endif; ?>
</body>
</html>
