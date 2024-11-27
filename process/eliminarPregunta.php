<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once '../process/conexion.php';

if (isset($_GET['id'])) {
    $preguntaId = $_GET['id'];

    try {
        // Eliminar la pregunta
        $sql = "DELETE FROM tbl_preguntas WHERE id_preg = :id_preg AND id_usu = :id_usu";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_preg', $preguntaId, PDO::PARAM_INT);
        $stmt->bindParam(':id_usu', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../view/miPregunta.php');  // Redirigir después de eliminar
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "ID de pregunta no proporcionado.";
    exit();
}
?>
