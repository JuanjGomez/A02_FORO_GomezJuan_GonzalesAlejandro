<?php
session_start();  // Inicia la sesión para acceder a las variables de sesión

require_once '../process/conexion.php';  // Incluye la conexión a la base de datos

$idUsuarioActual = $_SESSION['id'];  // Obtiene el ID del usuario actual

// Consulta para obtener las solicitudes pendientes donde el usuario actual es el receptor
$sqlSolicitudes = "SELECT * FROM tbl_solicitud WHERE id_usuario_dos = :idUsuario AND estado_soli = 'pendiente'";
$stmt = $conn->prepare($sqlSolicitudes);
$stmt->bindParam(':idUsuario', $idUsuarioActual, PDO::PARAM_INT);
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtiene todas las solicitudes pendientes
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes</title>
    <link rel="stylesheet" href="../styles/solicitudes.css"> 
</head>


<div>
    <h3>Solicitudes de Amistad</h3>
    <?php if ($solicitudes): ?>
        <?php foreach ($solicitudes as $solicitud): ?>
            <div>
                <!-- Muestra el ID del usuario que envió la solicitud -->
                <p>Solicitud de: Usuario <?= htmlspecialchars($solicitud['id_usuario_uno']) ?></p>
                <!-- Formulario para aceptar o rechazar la solicitud -->
                <form method="POST" action="../process/gestionarSolicitud.php">
                    <input type="hidden" name="idSolicitud" value="<?= htmlspecialchars($solicitud['id_soli']) ?>">
                    <!-- Botones para aceptar o rechazar -->
                    <button type="submit" name="accion" value="aceptar" class="btn btn-success">Aceptar</button>
                    <button type="submit" name="accion" value="rechazar" class="btn btn-danger">Rechazar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tienes solicitudes pendientes.</p>
    <?php endif; ?>
</div>
