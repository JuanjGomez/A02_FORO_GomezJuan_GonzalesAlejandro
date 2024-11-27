<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location:../index.php');
        exit();
    }
    require_once '../process/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/form.css">
    <title>Registrarse</title>
</head>
<body>
    <header>
        <a href="../index.php">INICIO</a><a href="login.php">LOGIN UP</a>
    </header>
    <h1>REGISTRARSE</h1>
    <div>
        <p id="indicaciones">Completa el formulario</p>
        <form method="POST" action="../process/crearUser.php">
            <label for="username">Nombre de usuario:
                <input type="text" name="username" id="username" value="<?php if(isset($_POST['username'])) { echo $_POST['username']; } ?>" placeholder="Introduce un username">
            </label>
            <p id="errorUser" class="error"></p>
            
            <label for="nombreReal">Nombre real:
                <input type="text" name="nombreReal" id="nombreReal" value="<?php if(isset($_POST['nombreReal'])) { echo $_POST['nombreReal']; } ?>" placeholder="Introduce tu nombre real">
            </label>
            <p id="errorReal" class="error"></p>
            
            <label for="email">Correo electrónico:
                <input type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" placeholder="Introduce tu correo electrónico">
            </label>
            <p id="errorEmail" class="error"></p>
            
            <label for="pwd">Contraseña:
                <input type="password" name="pwd" id="pwd" placeholder="Introduce una contraseña">
            </label>
            <p id="errorPwd" class="error"></p>
            
            <label for="pwd2">Confirmar contraseña:
                <input type="password" name="pwd2" id="pwd2" placeholder="Repite la contraseña">
            </label>
            <p id="errorPwd2" class="error"></p>
            
            <label for="rol">Rol:</label>
            <select name="rol" id="rol">
                <?php
                    if (isset($_SESSION['identico'])) {
                        echo '<p>El usuario o mail ya están siendo utilizados</p>';
                    }

                    try {
                        $sqlRol = $conn->prepare("SELECT * FROM tbl_rol");
                        $sqlRol->execute();
                        $roles = $sqlRol->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($roles as $rol) {
                            echo "<option value='". $rol['id_rol']. "'";
                            if (isset($_POST['rol']) && $_POST['rol'] == $rol['id_rol']) {
                                echo " selected";
                            }
                            echo ">". $rol['nombre_rol']. "</option>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                        die();
                    }
                ?>
            </select>
            <p id="errorRol" class="error"></p>
            
            <input type="submit" id="boton" value="Registrarse" disabled>
        </form>
    </div>
    <script src="../validations/js/verifRegister.js"></script>
</body>
</html>
