<?php

session_start();
$email = '';

$conexion_path = __DIR__ . '/conexion.php';

if (!empty($_POST["btn-primary"])) {
    

    $correo = $_POST["correo"];

    $clave = $_POST["clave"];

    $admin = isset($_POST["admin"]);
    

    $email = $correo;
    
    if (empty($correo) || empty($clave)) {
        $error = 'LOS CAMPOS ESTÁN VACÍOS';
    } else {

        if ($admin) {
            $sql = $conexion->query("SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$clave'");
        } else {
            $sql = $conexion->query("SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$clave'");
        }

        if ($datos = $sql->fetch_object()) {
            $_SESSION["usuario_id"] = $datos->id;
            
            $_SESSION["usuario_correo"] = $datos->correo;
            
            $_SESSION["es_admin"] = $admin;
            
            $_SESSION["usuario_nombre"] = $datos->nombre;
            
            if ($admin) {
                header("Location: ../index.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $error = 'ACCESO DENEGADO';
        }
    }
}
?>
