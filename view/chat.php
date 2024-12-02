<?php
session_start();
include("../process/conexion.php");

if (!isset($_GET['user_id']) || !isset($_GET['friend_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = intval($_GET['user_id']);
$friend_id = intval($_GET['friend_id']);

// Enviar mensaje
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $message_content = trim($_POST["message"]);
    if (!empty($message_content)) {
        $insert_message = "INSERT INTO tbl_mensaje (contenido_men, id_usuario_remitente, id_usuario_destinatario) 
                           VALUES (:message_content, :user_id, :friend_id)";
        $stmt = $conn->prepare($insert_message);
        $stmt->execute(['user_id' => $user_id, 'friend_id' => $friend_id, 'message_content' => $message_content]);
    }
}

// Obtener mensajes
$messages_query = "SELECT u.username_usu, m.contenido_men, m.fecha_men 
                   FROM tbl_mensaje m 
                   JOIN tbl_usuarios u ON m.id_usuario_remitente = u.id_usu 
                   WHERE (m.id_usuario_remitente = :user_id AND m.id_usuario_destinatario = :friend_id) 
                   OR (m.id_usuario_remitente = :friend_id AND m.id_usuario_destinatario = :user_id)
                   ORDER BY m.fecha_men DESC";
$stmt = $conn->prepare($messages_query);
$stmt->execute(['user_id' => $user_id, 'friend_id' => $friend_id]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../styles/chat.css">
</head>
<body>
    <div class="chat-container">
        <h2>Chat con <?php echo htmlspecialchars($_GET['friend_id']); ?></h2>
        <div class="messages-container">
            <?php 
            if ($stmt->rowCount() > 0) {
                while ($message = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                    // Verificación de valores nulos antes de pasarlos a htmlspecialchars
                    $username = isset($message['username_usu']) ? htmlspecialchars($message['username_usu']) : 'Desconocido';
                    $content = isset($message['contenido_men']) ? htmlspecialchars($message['contenido_men']) : '';
                    $date = isset($message['fecha_men']) ? $message['fecha_men'] : 'Fecha desconocida';
            ?>
                    <div class="message">
                        <p><strong><?php echo $username; ?>:</strong> <?php echo $content; ?></p>
                        <span><?php echo $date; ?></span>
                    </div>
                <?php 
                } 
            } else { 
            ?>
                <p>No hay mensajes en este chat.</p>
            <?php } ?>
        </div>
        <form method="post" action="">
            <textarea name="message" placeholder="Escribe tu mensaje..." maxlength="250" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
