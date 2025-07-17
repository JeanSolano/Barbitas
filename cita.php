<?php

session_start();
$nombre_usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$conexion = new mysqli("localhost", "root", "", "barbitas");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$sucursales = $conexion->query("SELECT id, nombre FROM sucursales");

// NUEVO: Obtener servicios desde la base de datos
$servicios = $conexion->query("SELECT id, nombre, precio FROM servicios");
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda tu cita - Gentlemen's Barber Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
    <script>
    function cargarBarberos(idSucursal) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "obtener_barberos.php?id_sucursal=" + idSucursal, true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById("barbero").innerHTML = this.responseText;
            }
        };
        xhr.send();
    }
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
            <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                <a class="navbar-brand" href="index.php">
                    <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                </a>
                <ul class="nav flex-column w-100">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.php">Más sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="cita.php">Agenda tu cita</a></li>
                </ul>
                <div class="mt-auto mb-4 w-100 d-flex justify-content-center">
                        <a class="nav-link" href="<?= $nombre_usuario ? 'perfil.php' : 'Login.php' ?>" title="<?= $nombre_usuario ? 'Perfil' : 'Iniciar sesión' ?>">
                            <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                            <span style="font-size:1rem; margin-left: 8px;">
                                <?= $nombre_usuario ? htmlspecialchars($nombre_usuario) : 'Iniciar sesión' ?>
                            </span>
                        </a>
                    </div>
            </div>
        </nav>

        <div class="col-md-6 ms-sm-auto col-lg-10 p-0">
            <section class="booking-section section-padding" id="booking-section" style="position: relative; z-index: 1;">
                <div class="video-bg-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 0;">
                    <video autoplay muted loop playsinline class="video-bg" style="width: 100%; height: 100%; object-fit: cover; opacity: 100%;">
                        <source src="images/video-citas.mp4" type="video/mp4">
                        Tu navegador no soporta el video.
                    </video>
                </div>
                <div class="container position-relative" style="z-index: 2;">
                    <div class="row">
                        <div class="col-lg-10 col-12 mx-auto">
                            <?php if (!$nombre_usuario): ?>
                                <div class="alert alert-warning text-center mb-4" style="background-color: rgba(255, 193, 7, 0.9); border: none; border-radius: 10px;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <strong>¡Atención!</strong> Para agendar una cita necesitas 
                                    <a href="Login.php" class="alert-link text-decoration-underline">iniciar sesión</a> 
                                    o <a href="registro.php" class="alert-link text-decoration-underline">registrarte</a> primero.
                                </div>
                            <?php endif; ?>
                            
                            <form action="guardar_cita.php" method="post" class="custom-form booking-form" id="bb-booking-form" role="form" <?= !$nombre_usuario ? 'style="opacity: 0.6; pointer-events: none;"' : '' ?>>
                                <!-- Campo oculto para pasar el ID del usuario -->
                                <?php if ($nombre_usuario): ?>
                                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                                <?php endif; ?>
                                
                                <div class="text-center mb-5">
                                    <div class="bg-white rounded shadow p-4 mb-4 opacity-75">
                                        <h2 class="mb-1" style="color:#000;">Agenda una Cita!</h2>
                                        <p style="color:#000;">Por favor, complete el formulario y nos pondremos en contacto con usted</p>
                                    </div>
                                </div>
                                <div class="booking-form-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <select class="form-select form-control" name="sucursal" onchange="cargarBarberos(this.value)" required>
                                                <option value="">Seleccione sucursal</option>
                                                <?php while($row = $sucursales->fetch_assoc()): ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <select class="form-select form-control" name="servicio" required>
                                                <option value="">Seleccione servicio</option>
                                                <?php while($row = $servicios->fetch_assoc()): ?>
                                                    <option value="<?= htmlspecialchars($row['nombre']) ?>">
                                                        <?= htmlspecialchars($row['nombre']) ?> - $<?= number_format($row['precio'], 2) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <select class="form-select form-control" name="barbero" id="barbero" required>
                                                <option value="">Seleccione un barbero</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="date" name="fecha" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <input type="time" name="hora" class="form-control" required>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <button type="submit" class="form-control">Agendar Cita</button>
                                        </div>
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
