<?php
    session_start();
    if(isset($_SESSION['id'])){
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/form.css">
    <title>Registrarse</title>
</head>
<body>
    <header>
        <a href="../index.php"><button class="btn btn-warning">INICIO</button></a><a href="login.php"><button class="btn btn-success">LOGIN UP</button></a>
    </header>
    <div>
        <form method="POST" action="../process/crearUser.php">
            <h1><strong>REGISTRARSE</strong></h1>
            <p id="indicaciones">Completa el formulario</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../validations/js/verifRegister.js"></script>
</body>
</html>