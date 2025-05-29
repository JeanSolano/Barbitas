<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'barbitas';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_errno) {
    die('Error de conexión: ' . $conn->connect_errno);
} else {
    echo 'Conexión exitosa a la base de datos';
}
?>