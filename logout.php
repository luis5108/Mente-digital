<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
require_once 'header.php';
// Elimina todas las variables de sesión
session_unset();
// Destruye la sesión actual
session_destroy();
// Redirige al usuario a la página de inicio
header("Location: index.php");
// Termina la ejecución del script
exit;
?>
