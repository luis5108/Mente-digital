<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
require_once 'header.php';
// Incluye el archivo que contiene las funciones para interactuar con la base de datos
require_once 'data.php';

// Redirige si el usuario no es un administrador
if (!isset($_SESSION["usuario_rol"]) || $_SESSION["usuario_rol"] !== 'admin') {
   header("Location: login.php");
   exit;
}

// Comprueba si la solicitud HTTP es de tipo POST y si se ha enviado el 'codigo_id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo_id'])) {
   // Obtiene el 'codigo_id' del celular a eliminar desde los datos POST
   $celular_codigo_id = $_POST['codigo_id'];

   // Intenta eliminar el celular de la base de datos
   if (deleteCelular($celular_codigo_id)) {
       // Si la eliminación fue exitosa, redirige al dashboard con un mensaje de éxito
       header("Location: dashboard.php?status=success&message=Celular eliminado exitosamente.");
       exit;
   } else {
       // Si hubo un error al eliminar, redirige al dashboard con un mensaje de error
       header("Location: dashboard.php?status=error&message=Error al eliminar el celular.");
       exit;
   }
} else {
   // Si no se recibió un 'codigo_id' o la solicitud no es POST, redirige al dashboard con un mensaje de error
   header("Location: dashboard.php?status=error&message=Solicitud inválida para eliminar.");
   exit;
}
?>
