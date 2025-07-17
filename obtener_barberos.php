<?php
$conexion = new mysqli("localhost", "root", "", "barbitas");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (isset($_GET['id_sucursal'])) {
    $id_sucursal = intval($_GET['id_sucursal']);
    $query = "SELECT id, nombre FROM barberos WHERE id_sucursal = $id_sucursal";
    $result = $conexion->query($query);

    echo "<option value=''>Seleccione un barbero</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
    }
}
?>