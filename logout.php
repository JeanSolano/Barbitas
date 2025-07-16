<?php
session_start();
session_unset(); // Elimina variables de sesión
session_destroy(); // Destruye la sesión

// Borrar cookie 'usuario' si existe
if (isset($_COOKIE['usuario'])) {
    setcookie('usuario', '', time() - 3600, '/');
}

header("Location: Login.php");
exit;
?>
