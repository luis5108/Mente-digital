<?php
// Define el nombre del servidor de la base de datos
$servername = "localhost";
// Define el nombre de usuario para acceder a la base de datos
$username = "root";
// Define la contraseña para el usuario de la base de datos (vacía en este caso)
$password = "";
// Define el nombre de la base de datos a la que se conectará
$dbname = "mente digital"; // Nombre de la base de datos según tu volcado

// Crea una nueva conexión a la base de datos usando MySQLi
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión a la base de datos fue exitosa
if ($conexion->connect_error) {
   // Si la conexión falla, termina el script y muestra un mensaje de error
   die("Conexión fallida: " . $conexion->connect_error);
}
?>
