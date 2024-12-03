<?php
session_start();
require_once '../process/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Obtener amigos con los que el usuario tiene una solicitud aceptada
$sqlAmigos = "SELECT u.id_usu, u.username_usu 
              FROM tbl_usuarios u
              JOIN tbl_solicitud s ON (s.id_usuario_uno = u.id_usu OR s.id_usuario_dos = u.id_usu)
              WHERE (s.id_usuario_uno = :userId OR s.id_usuario_dos = :userId) 
              AND s.estado_soli = 'aceptado' 
              AND u.id_usu != :userId"; // Excluye al propio usuario

$stmtAmigos = $conn->prepare($sqlAmigos);
$stmtAmigos->bindParam(':userId', $_SESSION['id']);
$stmtAmigos->execute();
$amigos = $stmtAmigos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Chats</title>
    <link rel="stylesheet" href="../styles/chats.css">
</head>
<body>
    <h2>Selecciona un amigo para chatear</h2>
    <div class="amigos-list">
        <?php if (count($amigos) > 0): ?>
            <?php foreach ($amigos as $amigo): ?>
                <a href="chat.php?user_id=<?php echo $_SESSION['id']; ?>&friend_id=<?php echo $amigo['id_usu']; ?>">
                    <?php echo htmlspecialchars($amigo['username_usu']); ?>
                </a><br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes amigos con los que chatear. Haz nuevas amistades.</p>
        <?php endif; ?>
    </div>
</body>
</html>
