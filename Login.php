<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "barbitas");

// Verifica conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$login_error = '';

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conexion->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM usuarios WHERE email = '$username' OR nombre = '$username' LIMIT 1";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Comparación directa (sin password_hash, para pruebas)
        if ($password === $user['password']) {
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir a perfil.php
            header("Location: perfil.php");
            exit;
        } else {
            $login_error = "Contraseña incorrecta.";
        }
    } else {
        $login_error = "Usuario no encontrado.";
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gentlemen's Barber Shop</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">

    <!-- CSS Files - rutas absolutas (ajusta si estás en una subcarpeta) -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
            <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                <a class="navbar-brand" href="/index.html">
                    <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                </a>
                <ul class="nav flex-column w-100">
                    <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.html">Más sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="cita.html">Agenda tu cita</a></li>
                </ul>
                <div class="mt-auto mb-4 w-100 d-flex justify-content-center">
                    <a class="nav-link" href="Login.php"><i class="bi bi-person-circle" style="font-size: 2rem;"></i></a>
                </div>
            </div>
        </nav>

        <!-- Formulario -->
        <div class="col-md-6 ms-sm-auto col-lg-10 p-0">
            <section class="booking-section w-100" style="background: none; min-height: auto;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 col-12">
                            <form action="Login.php" method="post" class="custom-form booking-form" style="padding: 40px;" role="form">
                                <div class="text-center mb-5">
                                    <h2 class="mb-1">Iniciar Sesión</h2>
                                    <p>Accede a tu cuenta para reservar tu cita</p>
                                </div>

                                <?php if (!empty($login_error)): ?>
                                    <div class="alert alert-danger text-center"><?php echo $login_error; ?></div>
                                <?php endif; ?>

                                <div class="booking-form-body">
                                    <div class="mb-4">
                                        <input type="text" name="username" class="form-control" placeholder="Usuario o Email" required>
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                                    </div>
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Recordarme</label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn custom-btn">Entrar</button>
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="#">¿Olvidaste tu contraseña?</a><br>
                                        <span>¿No tienes cuenta? <a href="Registro.html">Regístrate</a></span>
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

<!-- Scripts -->
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/click-scroll.js"></script>
<script src="/js/custom.js"></script>

</body>
</html>
