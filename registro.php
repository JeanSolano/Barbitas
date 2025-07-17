<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "barbitas");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$registro_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conexion->real_escape_string(trim($_POST['nombre']));
    $apellido = $conexion->real_escape_string(trim($_POST['apellido']));
    $username = $conexion->real_escape_string(trim($_POST['username']));
    $correo_electronico = $conexion->real_escape_string(trim($_POST['correo']));
    $contraseña = trim($_POST['contraseña']);

    $sql = "INSERT INTO usuarios (nombre, apellido, correo_electronico, username, password)
            VALUES ('$nombre', '$apellido', '$correo_electronico', '$username', '$contraseña')";

    if ($conexion->query($sql) === TRUE) {
        // Obtener el ID del usuario recién creado
        $usuario_id = $conexion->insert_id;
        
        // Guardar tanto el nombre completo como el ID en la sesión
        $_SESSION['usuario'] = $nombre . ' ' . $apellido;
        $_SESSION['usuario_id'] = $usuario_id;

        setcookie('username', $username, time() + (86400 * 30), "/");

        header("Location: perfil.php");
        exit;
    } else {
        $registro_error = "Error al registrar: " . $conexion->error;
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Gentlemen's Barber Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
                <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                    <a class="navbar-brand" href="index..php">
                        <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                    </a>
                    <ul class="nav flex-column w-100">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="nosotros.php">Más sobre Nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="cita.php">Agenda tu cita</a></li>
                    </ul>
                    <div class="mt-auto mb-4 w-100 d-flex justify-content-center">
                        <a class="nav-link" href="Login.php" title="Iniciar sesión">
                            <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="col-md-6 ms-sm-auto col-lg-10 p-0">
                <section class="booking-section w-100" style="background: none; min-height: auto;">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8 col-12">
                                <form action="registro.php" method="post" class="custom-form booking-form" style="padding: 40px;" role="form">
                                    <div class="text-center mb-5">
                                        <h2 class="mb-1">Registro de Usuario</h2>
                                        <p>Crea tu cuenta para reservar tu cita</p>
                                    </div>
                                    <?php if (!empty($registro_error)): ?>
                                        <div class="alert alert-danger text-center"><?php echo $registro_error; ?></div>
                                    <?php endif; ?>
                                    <div class="custom-form-body">
                                        <div class="mb-4">
                                            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                                        </div>
                                        <div class="mb-4">
                                            <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                                        </div>
                                        <div class="mb-4">
                                            <input type="text" name="username" class="form-control" placeholder="Nombre de Usuario (username)" required>
                                        </div>
                                        <div class="mb-4">
                                            <input type="email" name="correo" class="form-control" placeholder="Correo Electronico" required>
                                        </div>
                                        <div class="mb-4">
                                            <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn custom-btn">Registrarse</button>
                                        </div>
                                        <div class="text-center mt-4">
                                            <span>¿Ya tienes cuenta? <a href="Login.php">Inicia sesión</a></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
