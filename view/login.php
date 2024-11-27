<?php
    session_start();
    if(isset($_SESSION['id'])){
        header('Location:../index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/form.css">
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Inicio</a>
            <a href="formRegistro.php">Registrarse</a>
        </nav>
    </header>
    <main>
        <h1>Login</h1>
        <div>
            <form method="POST" action="../process/verificarLogin.php" id="loginForm">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Introduce tu username" required>
                <p id="errorUser" class="error"></p>

                <label for="pwd">Password:</label>
                <input type="password" name="pwd" id="pwd" placeholder="Introduce tu contraseña" required>
                <p id="errorPwd" class="error"></p>

                <input type="submit" id="boton" value="Login" disabled>
            </form>
        </div>
    </main>
    <script src="../validations/js/verifLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const urlParam = new URLSearchParams(window.location.search);
        if(urlParam.get('error') == '1'){
            Swal.fire({
                title: 'Error',
                text: 'Datos incorrectos',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
</body>
</html>
