<?php include 'header.php'; ?>
<?php
session_start();
include('conexion.php');
if (!empty($_POST["btn-primary"])) {
    if (
        !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["fechaN"]) && !empty($_POST["correo"]) && !empty($_POST["clave"]) && !empty($_POST["C_clave"])
    ) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $fechaN = $_POST["fechaN"];
        $correo = $_POST["correo"];
        $clave = $_POST["clave"];
        $confirma_clave = $_POST["C_clave"];

        // Validar que ambas claves coincidan
        if ($clave !== $confirma_clave) {
            echo '<div class="error-message">Las contraseñas no coinciden</div>';
        } else {
            // Verificar si el correo ya existe
            $verificar = $conexion->query("SELECT * FROM usuarios WHERE email='$correo'");
            if ($verificar->num_rows > 0) {
                echo '<div class="error-message">Este correo ya está registrado</div>';

            } else {

                $sql = $conexion->query("INSERT INTO usuarios(nombre, apellido,  email, contraseña) VALUES('$nombre', '$apellido',  '$correo', '$clave')");

                if ($sql === TRUE) {
                    $datos = $conexion->query("SELECT * FROM usuarios WHERE email='$correo'")->fetch_object();

                    $_SESSION["usuario_id"] = $datos->id;
                    $_SESSION["usuario_correo"] = $datos->correo;
                    header("Location: index.php");
                } else {
                    echo '<div class="alert alert-danger">Error al registrar persona</div>';
                }
            }
        }
    } else {
        echo '<div class="alert alert-warning">Todos los campos son obligatorios</div>';
    }
}
?>