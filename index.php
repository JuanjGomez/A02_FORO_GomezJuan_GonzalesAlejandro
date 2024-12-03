<?php
session_start();
if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']) {
    $user = $_SESSION['username'];
    echo "<script> let loginSuccess = true; let username = '$user';</script>";
    unset($_SESSION['loginSuccess']);
}
require_once './process/conexion.php';

try {
    // Se verifica si el usuario ya existe
    $sqlSeguridad = "SELECT p.id_preg, p.titulo_preg, p.descripcion_preg, p.fecha_publicacion, 
                    (SELECT COUNT(*) FROM tbl_respuestas r WHERE r.id_preg = p.id_preg) AS num_respuestas 
                     FROM tbl_preguntas p";
    $stmtSeguridad = $conn->prepare($sqlSeguridad);
    $stmtSeguridad->execute();
    $resultados = $stmtSeguridad->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Comprobación de amigos con los que el usuario puede chatear
$misChats = '';
if (isset($_SESSION['id_usuario'])) {
    // Obtener el ID del usuario logueado
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener los amigos (amistades aceptadas)
    $sql = "SELECT u.id_usu, u.username_usu
            FROM tbl_usuarios u
            JOIN tbl_solicitud s ON (s.id_usuario_uno = u.id_usu OR s.id_usuario_dos = u.id_usu)
            WHERE (s.id_usuario_uno = :id_usuario OR s.id_usuario_dos = :id_usuario)
              AND s.estado_soli = 'aceptado' 
              AND u.id_usu != :id_usuario";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    $amigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($amigos) {
        $misChats = "<li class='nav-item'>
                        <a class='nav-link' href='chats.php'>Mis Chats</a>
                      </li>";
    }
}
require_once './process/busqueda.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" integrity="sha256-qWVM38RAVYHA4W8TAlDdszO1hRaAq0ME7y2e9aab354=" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/inicio.css">
    <title>Página Principal</title>
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
                    <?php
                    // Si el usuario está logueado, mostrar "Mis Preguntas" y "Mis Solicitudes"
                    echo isset($_SESSION['id']) ? "<li class='nav-item'>
                                                    <a class='nav-link active' aria-current='page' href='./view/miPregunta.php'>Mis Preguntas</a>
                                                </li>" : "";
                    echo isset($_SESSION['id']) ? "<li class='nav-item'>
                                                    <a class='nav-link active' href='./view/solicitudes.php'>Mis Solicitudes</a>
                                                </li>" : "";
                    // Mostrar "Mis Chats" solo si tiene amigos con los que chatear
                    echo $misChats;
                    ?>
                </ul>
                <?php
                    echo isset($_GET['query']) ? "<a href='index.php' class='dropdown-item'>Borrar Filtros</a>" : "";
                ?>
                <form class="d-flex" role="search" method="GET" action="">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
        <?php echo !isset($_SESSION['id']) ? "<form method='POST' action='./view/login.php'>
                                                <button type='submit' class='btn btn-primary'>Login</button>
                                            </form>" : ""; ?>
        <?php echo !isset($_SESSION['id']) ? "<form method='POST' action='./view/formRegistro.php'>
                                                <button type='submit' class='btn btn-success'>Registrarse</button>
                                            </form>" : ""; ?>
        <?php echo isset($_SESSION['id']) ? "<a href='./process/cerrarSession.php'><button class='btn btn-danger'>Cerrar Sesión</button></a>" : ""; ?>
    </nav>
    <div id="principal" class="container mt-4">
        <section id="left" class="mb-3">
            <h3 class="center">Funcionalidades</h3>
        </section>
        <section id="center">
            <h3 class="center">Publicaciones</h3>
            <?php
                if (isset($_SESSION['id'])) {
                    echo "<div class='card mb-3'>
                        <h5 class='card-header'>¿Cuál es tu duda?</h5>
                        <div class='card-body'>
                            <p>Realiza una publicación --> 
                            <a href='./view/formPregunta.php' class='btn btn-primary'>Crear Pregunta</a></p>
                        </div>
                    </div>";
                }
                if (!isset($_GET['query'])) {
                    if ($resultados) {
                        foreach ($resultados as $fila) {
                            echo "<div class='card mb-3'>
                                    <div class='card-body'>
                                        <h5 class='card-title'><strong>".$fila['titulo_preg']."</strong></h5>
                                        <p class='card-text'>".$fila['descripcion_preg']."</p>
                                        <p class='card-text'><small class='text-muted'>".$fila['fecha_publicacion']."</small></p>
                                        <p class='card-text'>Respuestas: ".$fila['num_respuestas']."</p>
                                        <form method='POST' action='./view/verPregunta.php'>
                                            <input type='hidden' name='idPregunta' value='".$fila['id_preg']."'>
                                            <button type='submit' class='btn btn-primary'>Ver Pregunta</button>
                                        </form>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<p>No hay publicaciones.</p>";
                    }
                } else {
                    if ($resultadosPreguntas) {
                        foreach ($resultadosPreguntas as $fila) {
                            echo "<div class='card mb-3'>
                                    <div class='card-body'>
                                        <h5 class='card-title'><strong>".$fila['titulo_preg']."</strong></h5>
                                        <p class='card-text'>".$fila['descripcion_preg']."</p>
                                        <p class='card-text'><small class='text-muted'>".$fila['fecha_publicacion']."</small></p>
                                        <p class='card-text'>Respuestas: ".$fila['num_respuestas']."</p>
                                        <form method='POST' action='./view/verPregunta.php'>
                                            <input type='hidden' name='idPregunta' value='".$fila['id_preg']."'>
                                            <button type='submit' class='btn btn-primary'>Ver Pregunta</button>
                                        </form>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<p>No hay publicaciones relacionadas con la búsqueda.</p>";
                    }
                }
            ?>
        </section>
        <section id="right">
            <h3 class="center">USUARIOS</h3>
            <?php
                if (isset($_GET['query'])) {
                    if ($resultadosUsuarios) {
                        echo "<div>";
                        foreach ($resultadosUsuarios as $fila) {
                            if (isset($fila['id_usu'])) {
                                echo "<div style='margin-bottom: 10px;'>
                                        <h5>Usuario: ".$fila['username_usu']."</h5>
                                        <p>Nombre: ".$fila['nombre_real']."</p>
                                        <form method='POST' action='./view/verPerfil.php'>
                                            <input type='hidden' name='idUsuario' value='".$fila['id_usu']."'>
                                            <button type='submit' class='btn btn-secondary'>Ver Perfil</button>
                                        </form>
                                      </div>";
                            }
                        }
                        echo "</div>";
                    }
                }
            ?>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0d5Xy4pt7rF4P6MQb9yX5dmb2K7/PUhZ5VV1VmJ5ZV/gxf8w" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
</body>
</html>
