<?php
session_start();
include 'conexion.php';

if (isset($_POST['btn-login'])) {
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['password']);

    if (empty($correo) || empty($clave)) {
        $error = "Los campos están vacíos.";
    } else {
        $sql = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        $sql->bind_param("ss", $correo, $clave);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($datos = $resultado->fetch_object()) {
            $_SESSION["usuario_id"] = $datos->id;
            $_SESSION["usuario_correo"] = $datos->email;
            $_SESSION["usuario_nombre"] = $datos->nombre;
            $_SESSION["usuario_rol"] = trim(strtolower($datos->rol));

            if ($_SESSION["usuario_rol"] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    }
}

?>