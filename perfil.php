<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit;
}

$nombre_usuario = $_SESSION['usuario'];
$rol_usuario = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - Gentlemen's Barber Shop</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?> 👋</h2>
        
        <p class="text-center">
            Has iniciado sesión como <strong><?php echo htmlspecialchars($rol_usuario); ?></strong>.
        </p>

        <?php if ($rol_usuario === 'admin'): ?>
            <div class="alert alert-info text-center mt-4">
                Eres administrador. Puedes gestionar citas, usuarios y servicios.
            </div>
        <?php else: ?>
            <div class="alert alert-success text-center mt-4">
                Eres cliente. Puedes agendar tu cita desde la sección correspondiente.
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.html" class="btn btn-primary">Ir al Inicio</a>
            <a href="logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>
</div>

<!-- JS -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
