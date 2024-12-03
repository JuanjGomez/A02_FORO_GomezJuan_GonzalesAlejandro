<?php
session_start();
require_once './conexion.php';

$idUsuarioActual = $_SESSION['id'];
$idSolicitud = $_POST['idSolicitud'];
$accion = $_POST['accion'];

// Verifica si la solicitud existe
$sql = "SELECT * FROM tbl_solicitud WHERE id_soli = :idSolicitud AND (id_usuario_uno = :idUsuario OR id_usuario_dos = :idUsuario)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':idSolicitud', $idSolicitud, PDO::PARAM_INT);
$stmt->bindParam(':idUsuario', $idUsuarioActual, PDO::PARAM_INT);
$stmt->execute();
$solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

if ($solicitud) {
    // Define el nuevo estado de la solicitud según la acción
    if ($accion == 'aceptar') {
        $estado = 'aceptado';
    } elseif ($accion == 'rechazar') {
        $estado = 'rechazado';
    }

    // Actualiza el estado de la solicitud
    $sqlUpdate = "UPDATE tbl_solicitud SET estado_soli = :estado WHERE id_soli = :idSolicitud";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':idSolicitud', $idSolicitud, PDO::PARAM_INT);
    $stmtUpdate->execute();

    // Redirige al usuario a la página de solicitudes
    header('Location: ../view/solicitudes.php');
    exit;
} else {
    die("Solicitud no encontrada o no tienes permisos para gestionarla.");
}
?>
