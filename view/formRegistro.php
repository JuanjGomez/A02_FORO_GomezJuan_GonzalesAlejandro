<?php
    require_once '../process/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="../index.php">INICIO</a><a href="login.php">LOGIN UP</a>
    </header>
    <h1>RESGISTRARSE</h1>
    <div>
        <p id="indicaciones">Completa el formulario</p>
        <form method="POST" action="../validations/crearUser.php">
            <label for="username">Nombre de usuario:<input type="text" name="username" id="username" placeholder="Introduce un username"></label><br>
            <p id="errorUser"></p>
            <label for="nombreReal">Nombre real:<input type="text" name="nombreReal" id="nombreReal" placeholder="Introduce tu nombre real"></label><br>
            <p id="errorReal"></p>
            <label for="email">Correo electrónico:<input type="email" name="email" id="email" placeholder="Introduce tu correo electrónico"></label><br>
            <p id="errorEmail"></p>
            <label for="pwd">Contraseña:<input type="password" name="pwd" id="pwd" placeholder="Introduce una contraseña"></label><br>
            <p id="errorPwd"></p>
            <label for="pwd2">Confirmar contraseña:<input type="password" name="pwd2" id="pwd2" placeholder="Repite la contraseña"></label><br>
            <p id="errorPwd2"></p>
            <label for="rol">Rol:</label>
            <select name="rol" id="rol">
                <?php
                    $sqlRol = $conn->prepare("SELECT * FROM tbl_rol");
                    $sqlRol->execute();
                    $roles = $sqlRol->fetchAll(PDO::FETCH_ASSOC);
                    foreach($roles as $rol) {
                        echo "<option value='". $rol['id_rol']. "'>". $rol['nombre_rol']. "</option>";
                    }
                ?>
            </select><br>
            <p id="errorRol"></p>
            <input type="submit" id="boton" value="Registrarse" disabled>
        </form>
    </div>
    <script src="../validations/js/verifRegister.js"></script>
</body>
</html>