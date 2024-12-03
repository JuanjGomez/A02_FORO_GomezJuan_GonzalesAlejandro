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
    echo "<form method='POST' action='../view/verPerfil.php' name='form'>
        <input type='hidden' name='idUsuario' value='$idUsuario'>
    </form>";
    echo "<script> document.form.submit() </script>";
    exit();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
