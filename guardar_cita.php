<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "barbitas");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$factura_generada = false;
$mensaje_factura = '';
$datos_factura = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $sucursal = intval($_POST['sucursal']);
    $servicio = $conexion->real_escape_string($_POST['servicio']);
    $barbero = intval($_POST['barbero']);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $hora = $conexion->real_escape_string($_POST['hora']);
    $cliente = $nombre . ' ' . $apellido;
    
    // Obtener el ID del usuario logueado
    $usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : null;

    $sql = "INSERT INTO citas (cliente, id_barbero, fecha, hora, servicio, id_sucursal, usuario_id)
            VALUES ('$cliente', $barbero, '$fecha', '$hora', '$servicio', $sucursal, " . ($usuario_id ? $usuario_id : 'NULL') . ")";

    if ($conexion->query($sql) === TRUE) {
        // Generar número de factura único
        $numero_factura = uniqid('FAC-');

        // Obtener precio del servicio
        $resultado_precio = $conexion->query("SELECT precio FROM servicios WHERE nombre = '$servicio'");
        if ($fila = $resultado_precio->fetch_assoc()) {
            $precio = $fila['precio'];
        } else {
            $precio = 0;
        }

        // Insertar factura principal
        $sql_factura = "INSERT INTO facturas (numero_factura, cliente, fecha, hora, id_sucursal, usuario_id) VALUES ('$numero_factura', '$cliente', '$fecha', '$hora', $sucursal, " . ($usuario_id ? $usuario_id : 'NULL') . ")";
        if ($conexion->query($sql_factura) === TRUE) {
            $id_factura = $conexion->insert_id;

            // Inserta el detalle de la factura
            $sql_detalle = "INSERT INTO factura_detalles (id_factura, servicio, precio)
                            VALUES ($id_factura, '$servicio', $precio)";
            $conexion->query($sql_detalle);

            $factura_generada = true;
            $datos_factura = [
                'numero_factura' => $numero_factura,
                'cliente' => $cliente,
                'servicio' => $servicio,
                'precio' => $precio,
                'fecha' => $fecha,
                'hora' => $hora
            ];
        } else {
            $mensaje_factura = "Error al generar la factura: " . $conexion->error;
        }
    } else {
        $mensaje_factura = "Error al agendar la cita: " . $conexion->error;
    }
}
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
                if ($factura_generada) {
                    echo "<div class='alert alert-success'>Factura generada exitosamente.</div>";
                    echo "<ul class='list-group mb-3'>";
                    echo "<li class='list-group-item'><strong>Número de factura:</strong> {$datos_factura['numero_factura']}</li>";
                    echo "<li class='list-group-item'><strong>Cliente:</strong> {$datos_factura['cliente']}</li>";
                    echo "<li class='list-group-item'><strong>Servicio:</strong> {$datos_factura['servicio']}</li>";
                    echo "<li class='list-group-item'><strong>Precio:</strong> $" . number_format($datos_factura['precio'], 2) . "</li>";
                    echo "<li class='list-group-item'><strong>Fecha:</strong> {$datos_factura['fecha']}</li>";
                    echo "<li class='list-group-item'><strong>Hora:</strong> {$datos_factura['hora']}</li>";
                    echo "</ul>";
                    echo "<a href='index.php' class='btn btn-secondary' style='background-color: #6c757d; border-color: #6c757d; color: #fff; transition: background 0.3s, border 0.3s;' onmouseover=\"this.style.backgroundColor='#5a6268';this.style.borderColor='#545b62';\" onmouseout=\"this.style.backgroundColor='#6c757d';this.style.borderColor='#6c757d';\">Volver al inicio</a>";
                } elseif ($mensaje_factura) {
                    echo "<div class='alert alert-danger'>{$mensaje_factura}</div>";
                    echo "<a href='javascript:history.back()' class='btn btn-primary'>Volver</a>";
                }
                $conexion->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>