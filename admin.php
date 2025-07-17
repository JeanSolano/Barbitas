<?php
session_start();

// Verificar que sea admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: Login.php");
    exit;
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "barbitas");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Variables para mensajes y errores
$message = '';
$error = '';

// CRUD para citas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar barbero
    if (isset($_POST['add_barber'])) {
        $nombre = $conexion->real_escape_string(trim($_POST['barber_name']));
        $especialidad = $conexion->real_escape_string(trim($_POST['barber_specialty']));
        $id_sucursal = intval($_POST['id_sucursal']);

        if ($nombre && $especialidad && $id_sucursal > 0) {
            $sql = "INSERT INTO barberos (nombre, especialidad, id_sucursal) VALUES ('$nombre', '$especialidad', $id_sucursal)";
            if ($conexion->query($sql)) {
                $message = "Barbero agregado correctamente.";
            } else {
                $error = "Error al agregar barbero: " . $conexion->error;
            }
        } else {
            $error = "Por favor, completa todos los campos para agregar barbero.";
        }
    }

    // Eliminar cita
    if (isset($_POST['delete_cita'])) {
        $cita_id = intval($_POST['cita_id']);
        $sql = "DELETE FROM citas WHERE id = $cita_id";
        if ($conexion->query($sql)) {
            $message = "Cita eliminada correctamente.";
        } else {
            $error = "Error al eliminar cita: " . $conexion->error;
        }
    }

    // Editar cita (actualizar)
    if (isset($_POST['edit_cita'])) {
        $cita_id = intval($_POST['cita_id']);
        $cliente = $conexion->real_escape_string(trim($_POST['cliente']));
        $fecha = $conexion->real_escape_string(trim($_POST['fecha']));
        $hora = $conexion->real_escape_string(trim($_POST['hora']));
        $barbero_id = intval($_POST['barbero_id']);

        if ($cliente && $fecha && $hora && $barbero_id > 0) {
            $sql = "UPDATE citas SET cliente='$cliente', fecha='$fecha', hora='$hora', id_barbero=$barbero_id WHERE id=$cita_id";
            if ($conexion->query($sql)) {
                $message = "Cita actualizada correctamente.";
            } else {
                $error = "Error al actualizar cita: " . $conexion->error;
            }
        } else {
            $error = "Completa todos los campos para actualizar la cita.";
        }
    }
}

// Obtener sucursales para el select
$sucursales_result = $conexion->query("SELECT * FROM sucursales");
$sucursales = [];
while ($row = $sucursales_result->fetch_assoc()) {
    $sucursales[] = $row;
}

// Filtrado por sucursal (si hay)
$sucursal_filtrar = isset($_GET['id_sucursal']) ? intval($_GET['id_sucursal']) : 0;

// Obtener citas (con join para obtener barbero y sucursal)
$citas_sql = "SELECT citas.id, citas.cliente, citas.fecha, citas.hora, barberos.nombre AS barbero_nombre, sucursales.nombre AS sucursal_nombre, citas.id_barbero AS barbero_id, barberos.id_sucursal
FROM citas
INNER JOIN barberos ON citas.id_barbero = barberos.id
INNER JOIN sucursales ON barberos.id_sucursal = sucursales.id";

if ($sucursal_filtrar > 0) {
    $citas_sql .= " WHERE sucursales.id = $sucursal_filtrar";
}
$citas_sql .= " ORDER BY citas.fecha, citas.hora";

$citas_result = $conexion->query($citas_sql);

// Obtener todos los barberos para usar en el formulario de edición y agregar
$barberos_result = $conexion->query("SELECT barberos.id, barberos.nombre, sucursales.nombre AS sucursal_nombre, barberos.id_sucursal FROM barberos INNER JOIN sucursales ON barberos.id_sucursal = sucursales.id");
$barberos = [];
while ($row = $barberos_result->fetch_assoc()) {
    $barberos[] = $row;
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administrador - Gentlemen's Barber Shop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;500&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-barber-shop.css" rel="stylesheet">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body class="admin-dark">
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
            <div class="position-sticky sidebar-sticky d-flex flex-column justify-content-center align-items-center h-100">
                <a class="navbar-brand" href="#">
                    <img src="images/templatemo-barber-logo.png" class="logo-image img-fluid" alt="Barber Shop Logo">
                </a>
                <ul class="nav flex-column w-100">
                    <li class="nav-item">
                        <div class="d-flex justify-content-center align-items-center w-100" style="height: 60px;">
                            <form action="logout.php" method="post" class="w-100 text-center m-0">
                                <button type="submit" class="btn btn-link nav-link text-center w-100" style="padding: 0;">Cerrar Sesión</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-5 bg-light min-vh-100">

            <div class="container">
                <h2 class="mb-4 text-center">Panel de Administrador</h2>

                <!-- Mensajes -->
                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <!-- Selector sucursal -->
                <form method="GET" class="mb-4">
                    <label for="id_sucursal" class="form-label">Filtrar citas por sucursal:</label>
                    <select id="id_sucursal" name="id_sucursal" class="form-select" onchange="this.form.submit()">
                        <option value="0">Todas las sucursales</option>
                        <?php foreach ($sucursales as $sucursal): ?>
                            <option value="<?php echo $sucursal['id']; ?>" <?php if ($sucursal_filtrar == $sucursal['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($sucursal['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <!-- Tabla citas -->
                <div class="table-responsive mb-5">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Barbero</th>
                            <th>Sucursal</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($citas_result && $citas_result->num_rows > 0): ?>
                            <?php while ($cita = $citas_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cita['cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['barbero_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['sucursal_nombre']); ?></td>
                                    <td>
                                        <!-- Botones Editar / Eliminar -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarCitaModal<?php echo $cita['id']; ?>">">Editar</button>
                                        <form method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que quieres eliminar esta cita?');">
                                            <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                            <button type="submit" name="delete_cita" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Editar cita -->
                                <div class="modal fade" id="editarCitaModal<?php echo $cita['id']; ?>" tabindex="-1" aria-labelledby="editarCitaModalLabel<?php echo $cita['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog"><div class="modal-content bg-white">
                                        <form method="POST" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editarCitaModalLabel<?php echo $cita['id']; ?>"><h5>Editar Cita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">

                                                <div class="mb-3">
                                                    <label for="cliente<?php echo $cita['id']; ?>" class="form-label">Cliente</label>
                                                    <input type="text" name="cliente" id="cliente<?php echo $cita['id']; ?>" class="form-control" value="<?php echo htmlspecialchars($cita['cliente']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fecha<?php echo $cita['id']; ?>" class="form-label">Fecha</label>
                                                    <input type="date" name="fecha" id="fecha<?php echo $cita['id']; ?>" class="form-control" value="<?php echo htmlspecialchars($cita['fecha']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="hora<?php echo $cita['id']; ?>" class="form-label">Hora</label>
                                                    <input type="time" name="hora" id="hora<?php echo $cita['id']; ?>" class="form-control" value="<?php echo htmlspecialchars($cita['hora']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="barbero_id<?php echo $cita['id']; ?>" class="form-label">Barbero</label>
                                                    <select name="barbero_id" id="barbero_id<?php echo $cita['id']; ?>" class="form-select" required>
                                                    <option value="">Selecciona un barbero</option>
                                                    <?php foreach ($barberos as $barbero): ?>
                                                        <?php if ($barbero['id_sucursal'] == $cita['id_sucursal']): ?>
                                                            <option value="<?php echo $barbero['id']; ?>" <?php if ($barbero['id'] == $cita['barbero_id']) echo 'selected'; ?>>
                                                                <?php echo htmlspecialchars($barbero['nombre']) . " (" . htmlspecialchars($barbero['sucursal_nombre']) . ")"; ?>
                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_cita" class="btn btn-primary">Guardar cambios</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div></form>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay citas para mostrar.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulario agregar barbero -->
                    <div class="card p-4">
                        <h4>Agregar Barbero</h4>
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="add_barber" value="1">
                            <div class="col-md-5">
                                <input type="text" name="barber_name" class="form-control" placeholder="Nombre del barbero" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="barber_specialty" class="form-control" placeholder="Especialidad" required>
                            </div>
                            <div class="col-md-2">
                                <select name="id_sucursal" class="form-select" required>
                                    <option value="">Sucursal</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal['id']; ?>"><?php echo htmlspecialchars($sucursal['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn custom-btn">Agregar Barbero</button>
                            </div>
                        </div></form>
                    </div>

                </div>

            </main>

        </div>

    <!-- Lista desplegable de barberos y sucursales -->
    <div class="card p-4 mt-5">
        <h4>Barberos Registrados</h4>
        <select class="form-select">
            <option value="">Seleccione un barbero</option>
            <?php foreach ($barberos as $barbero): ?>
                <option value="<?= $barbero['id'] ?>">
                    <?= htmlspecialchars($barbero['nombre']) ?> (<?= htmlspecialchars($barbero['sucursal_nombre']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
    </html>
<?php
// Cerrar conexión