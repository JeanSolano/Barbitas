<?php
session_start();
if (!isset($_SESSION['usuario']) || isset($_SESSION['admin'])) {
    header("Location: Login.php");
    exit;
}

// Recuperar nombre completo desde la sesión (ya debe contener "Nombre Apellido")
$nombre_usuario = $_SESSION['usuario'];

// Verificar si el usuario es "admin admin"
$es_admin = (strtolower(trim($nombre_usuario)) === 'admin admin');
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil - Gentlemen's Barber Shop</title>
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

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
            <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                <a class="navbar-brand" href="index.html">
                    <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                </a>
                <ul class="nav flex-column w-100">
                    <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.html">Más sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="cita.html">Agenda tu cita</a></li>
                </ul>
                <div class="mt-auto mb-4 w-100 d-flex justify-content-center">
                    <a class="nav-link" href="Login.php" title="Iniciar sesión">
                        <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-5 bg-light min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9 col-12">
                        <div class="card shadow border-0">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <img src="images/templatemo-barber-logo.png" alt="Avatar" class="rounded-circle mb-3" width="80">
                                    <h2 class="fw-bold mb-1" style="font-family: 'Unbounded', cursive;">
                                        Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?> 👋
                                    </h2>
                                </div>

                                <?php if ($es_admin): ?>
                                    <div class="alert alert-info text-center mt-4">
                                        Eres administrador. Puedes gestionar citas, usuarios y servicios.
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="admin.php" class="btn btn-primary">Ir al Panel de Administrador</a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-success text-center mt-4">
                                        Eres cliente. Puedes agendar tu cita desde la sección correspondiente.
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <a href="cita.html" class="btn btn-outline-primary">Agendar Cita</a>
                                    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/click-scroll.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
