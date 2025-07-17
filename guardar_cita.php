<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("<div class='alert alert-danger mt-5'>Usuario no autenticado.</div>");
}

$conexion = new mysqli("localhost", "root", "", "barbitas");
if ($conexion->connect_error) {
    die("<div class='alert alert-danger mt-5'>Conexión fallida: " . $conexion->connect_error . "</div>");
}

$id_usuario = $_SESSION['usuario_id'];

$nombre_cliente = $conexion->real_escape_string($_POST['nombre']);
$apellido_cliente = $conexion->real_escape_string($_POST['apellido']);
$id_sucursal = intval($_POST['sucursal']);
$servicio = $conexion->real_escape_string($_POST['servicio']);
$id_barbero = intval($_POST['barbero']);
$fecha = $conexion->real_escape_string($_POST['fecha']);
$hora = $conexion->real_escape_string($_POST['hora']);
$cliente = $nombre_cliente . " " . $apellido_cliente;

// Supón que obtienes el precio del servicio desde la base de datos
$precio = 0;
$result = $conexion->query("SELECT precio FROM servicios WHERE nombre = '$servicio' LIMIT 1");
if ($row = $result->fetch_assoc()) {
    $precio = $row['precio'];
}

// Genera un número de factura único (puedes mejorarlo)
$numero_factura = uniqid('FAC-');

// Inserta en la tabla facturas
$sql_factura = "INSERT INTO facturas (id_usuario, fecha, hora, id_barbero, id_sucursal, cliente, total, numero_factura)
                VALUES ($id_usuario, '$fecha', '$hora', $id_barbero, $id_sucursal, '$cliente', $precio, '$numero_factura')";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Factura - Barbitas</title>
    <title>Agenda tu cita - Gentlemen's Barber Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-white text-white">
                <h4 class="mb-0">Generación de Factura</h4>
            </div>
            <div class="card-body">
                <?php
                if ($conexion->query($sql_factura) === TRUE) {
                    $id_factura = $conexion->insert_id;

                    // Inserta el detalle de la factura
                    $sql_detalle = "INSERT INTO factura_detalles (id_factura, servicio, precio)
                                    VALUES ($id_factura, '$servicio', $precio)";
                    $conexion->query($sql_detalle);

                    echo "<div class='alert alert-success'>Factura generada exitosamente.</div>";
                    echo "<ul class='list-group mb-3'>";
                    echo "<li class='list-group-item'><strong>Número de factura:</strong> $numero_factura</li>";
                    echo "<li class='list-group-item'><strong>Cliente:</strong> $cliente</li>";
                    echo "<li class='list-group-item'><strong>Servicio:</strong> $servicio</li>";
                    echo "<li class='list-group-item'><strong>Precio:</strong> $" . number_format($precio, 2) . "</li>";
                    echo "<li class='list-group-item'><strong>Fecha:</strong> $fecha</li>";
                    echo "<li class='list-group-item'><strong>Hora:</strong> $hora</li>";
                    echo "</ul>";
                    echo "<a href='index.php' class='btn btn-secondary' style='background-color: #6c757d; border-color: #6c757d; color: #fff; transition: background 0.3s, border 0.3s;' onmouseover=\"this.style.backgroundColor='#5a6268';this.style.borderColor='#545b62';\" onmouseout=\"this.style.backgroundColor='#6c757d';this.style.borderColor='#6c757d';\">Volver al inicio</a>";
                } else {
                    echo "<div class='alert alert-danger'>Error al generar la factura: " . $conexion->error . "</div>";
                    echo "<a href='javascript:history.back()' class='btn btn-primary'>Volver</a>";
                }
                $conexion->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>