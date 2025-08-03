<?php
$conexion = new mysqli("localhost", "root", "", "mente dijital");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
