<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/form.css">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="../index.php">INICIO</a><a href="formRegistro.php">RESGISTRARSE</a>
    </header>
    <h1>LOGIN</h1>
    <div>
        <form method="POST" action="../process/verificarLogin.php">
            <label for="username">Username:<input type="text" name="username" id="username" placeholder="Introduce tu username"></label>
            <p id="errorUser" class="error"></p>
            <label for="pwd">Password:<input type="password" name="pwd" id="pwd" placeholder="Introduce tu contrasena"></label>
            <p id="errorPwd" class="error"></p>
            <input type="submit" id="boton" value="Login" disabled>
        </form>
    </div>
    <script src="../validations/js/verifLogin.js"></script>
</body>
</html>