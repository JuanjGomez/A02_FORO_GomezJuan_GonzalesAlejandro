<?php
session_start();
require_once './conexion.php';

if (!isset($_SESSION['id'], $_POST['idUsuario'])) {
    die("Acceso no permitido.");
}

$idActual = $_SESSION['id'];
$idUsuario = $_POST['idUsuario'];

try {
    $sql = "INSERT INTO tbl_solicitud (id_usuario_uno, id_usuario_dos) VALUES (:idActual, :idUsuario)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['idActual' => $idActual, 'idUsuario' => $idUsuario]);
    header("Location: ../view/verPerfil.php?idUsuario=$idUsuario");
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
