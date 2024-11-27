<?php
    session_start();
    if(isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']){
        $user = $_SESSION['username'];
        echo "<script> let loginSuccess = true; let username = '$user';</script>";
        unset($_SESSION['loginSuccess']);
    }
    require_once './process/conexion.php';
    try{
        // Se verifica si el usuario ya existe
        $sqlSeguridad = "SELECT p.id_preg, p.titulo_preg, p.descripcion_preg, p.fecha_publicacion, (SELECT COUNT(*) FROM tbl_respuestas r WHERE r.id_preg) AS num_respuestas FROM tbl_preguntas p";
        $stmtSeguridad = $conn->prepare($sqlSeguridad);
        $stmtSeguridad->execute();
        $resultados = $stmtSeguridad->fetchAll(PDO::FETCH_ASSOC);

        // Se verifica si hay un usuario que existe y es igual a el
        // if($resultados){  //cambiar esto
        //         $_SESSION['identico'] = true;
        //         header('Location: ../view/formRegistro.php');
        //         exit();
            
        // }


    } catch (PDOException $e){
        echo "Error: ". $e->getMessage();
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/inicio.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="formPregunta.php">NEW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formPregunta.php">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                
                <form class="d-flex" role="search" method="GET" action="">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    
                </form>
            </div>
        </div>
        <?php echo !isset($_SESSION['id']) ? "<form method='POST' action='./view/login.php'>
                                                <button type='submit' class='btn btn-primary'>Login</button>
                                            </form>" : ""; ?>
        <?php echo !isset($_SESSION['id']) ? "<form method='POST' action='./view/formRegistro.php'>
                                                <button type='submit' class='btn btn-success'>Registrarse</button>
                                            </form>" : ""; ?>
        <?php echo isset($_SESSION['id']) ? "<a href='./process/cerrarSession.php'><button class='btn btn-danger'>Cerrar Sesion</button></a>" : ""; ?>
    </nav>
    <div id="principal">
        <section id="left">
            <h3>Funcionalidades</h3>
        </section>
        <section id="center">
            <h3>Publicaciones</h3>
            <?php
                if(isset($_SESSION['id'])){
                    echo "<div>
                        <h5>¿Cual es tu duda?</h5>
                        <p>Realiza una publicacion --> <a href='./view/formPregunta.php'><button class='btn btn-primary'>Crear Pregunta</button></a></p>
                    </div>";
                }
                if($resultados){
                    foreach($resultados as $fila){
                        echo "<div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>".$fila['titulo_preg']."</h5>
                                    <p class='card-text'>".$fila['descripcion_preg']."</p>
                                    <p class='card-text'>".$fila['fecha_publicacion']."</p>
                                    <p class='card-text'>Respuestas: ".$fila['num_respuestas']."</p>
                                    <form method='POST' action='./view/verPregunta.php'>
                                        <input type='hidden' name='idPregunta' id='idPregunta' value='".$fila['id_preg']."'>
                                        <button type='submit' class='btn btn-primary'>Ver Pregunta</button>
                                    </form>
                                </div>
                            </div><br>";
                    }
                } else {
                    echo "<p>No hay publicaciones.</p>";
                }
            ?>
        </section>
        <section id="right">
            <h3>Solicitudes</h3>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" integrity="sha256-1m4qVbsdcSU19tulVTbeQReg0BjZiW6yGffnlr/NJu4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        if (typeof loginSuccess !== 'undefined' && loginSuccess) {
            Swal.fire({
                title: 'Sesión iniciada',
                text: '¡Bienvenido ' + username + '!',
                icon: 'success'
            });
        }
    </script>
</body>
</html>