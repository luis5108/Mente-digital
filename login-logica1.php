<?php
include 'conexion.php';

if (!file_exists($conexion_path)) {
    die('Error: Archivo de conexión no encontrado');
}
include($conexion_path);

if (!empty($_POST["btn-primary"])) {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    if (empty($correo) || empty($clave)) {
        echo '<div class="alert alert-danger">LOS CAMPOS ESTÁN VACÍOS</div>';
    } else {
        // Consulta única (usuarios con correo y clave válidos)
        $sql = $conexion->query("SELECT * FROM usuarios WHERE email='$correo' AND password='$clave'");

        if ($datos = $sql->fetch_object()) {
            $_SESSION["usuario_id"] = $datos->id;
            $_SESSION["usuario_correo"] = $datos->email;
            $_SESSION["usuario_nombre"] = $datos->nombre;
            $_SESSION["es_admin"] = ($datos->rol === 'admin');

            // Redirige según el rol
            if ($datos->rol === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            echo '<div class="alert alert-danger">ACCESO DENEGADO</div>';
        }
    }
}
?>
