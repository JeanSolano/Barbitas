<?php
echo "Nombre: " . htmlspecialchars($_POST['bb-name'] ?? '') . "<br>";
echo "Teléfono: " . htmlspecialchars($_POST['bb-phone'] ?? '') . "<br>";
echo "Hora: " . htmlspecialchars($_POST['bb-time'] ?? '') . "<br>";
echo "Sucursal: " . htmlspecialchars($_POST['bb-branch'] ?? '') . "<br>";
echo "Fecha: " . htmlspecialchars($_POST['bb-date'] ?? '') . "<br>";
echo "Número de personas: " . htmlspecialchars($_POST['bb-number'] ?? '') . "<br>";
echo "Barbero: " . htmlspecialchars($_POST['bb-message'] ?? '') . "<br>";
?>