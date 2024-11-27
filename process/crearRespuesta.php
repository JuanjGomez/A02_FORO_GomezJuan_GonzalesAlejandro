<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location:../index.php');
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:../index.php');
        exit();
    } else {
        require_once 'conexion.php';

        // Se reciben los datos del formulario
        $id = htmlspecialchars(trim($_SESSION['id']));
        $idPregunta = htmlspecialchars(trim($_POST['idPregunta']));
        $respuesta = htmlspecialchars(trim($_POST['respuesta']));

        try{
            // Se realiza el insert en la tabla respuestas
            $sqlRespuestas = "INSERT INTO tbl_respuestas (contenido_resp, id_preg, id_usu) VALUES (:contenido_resp, :id_preg, :id_usu)";
            $stmtRespuestas = $conn->prepare($sqlRespuestas);
            $stmtRespuestas->bindParam(':contenido_resp', $respuesta);
            $stmtRespuestas->bindParam(':id_preg', $idPregunta);
            $stmtRespuestas->bindParam(':id_usu', $id);
            $stmtRespuestas->execute();

            $_SESSION['respuestaSubida'] = true;
            ?>
            <form method="POST" action="../view/verPregunta.php" name="formulario">
                <input type="hidden" name="idPregunta" value="<?php echo $idPregunta; ?>">
            </form>
            <script>
                document.formulario.submit();
            </script>
            <?php
            exit();
        } catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }
    }