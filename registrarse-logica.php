<?php
// Este archivo ya no necesita session_start() porque registrarse.php lo incluye después de header.php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

// Inicializa variables para mensajes de estado
$message = '';
$message_type = '';

// Comprueba si se ha enviado el formulario de registro (botón con name="btn-primary")
if (!empty($_POST["btn-primary"])) {
    // Obtiene los datos del formulario, usando el operador null coalescing para evitar errores
    $nombre = $_POST["nombre"] ?? '';
    $apellido = $_POST["apellido"] ?? '';
    $fechaN = $_POST["fechaN"] ?? ''; // Se mantiene para el formulario, aunque no se usa en la tabla 'usuarios'
    $correo = $_POST["correo"] ?? '';
    $password_input = $_POST["password"] ?? '';
    $confirma_password = $_POST["C_password"] ?? '';

    // Valida si algún campo obligatorio está vacío
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($password_input) || empty($confirma_password)) {
        $message = 'Todos los campos son obligatorios.';
        $message_type = 'error';
    } elseif ($password_input !== $confirma_password) { // Valida si las contraseñas coinciden
        $message = 'Las contraseñas no coinciden.';
        $message_type = 'error';
    } else {
        // Prepara una consulta para verificar si el correo ya existe en la base de datos
        $stmt_check = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        // Vincula el parámetro del correo
        $stmt_check->bind_param("s", $correo);
        // Ejecuta la consulta
        $stmt_check->execute();
        // Obtiene el resultado
        $result_check = $stmt_check->get_result();

        // Si el correo ya está registrado
        if ($result_check->num_rows > 0) {
            $message = 'Este correo ya está registrado.';
            $message_type = 'error';
        } else {
            // Hashea la contraseña antes de guardarla en la base de datos por seguridad
            $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);
            // Define el rol por defecto para los nuevos usuarios
            $rol_default = 'usuario';

            // Prepara una consulta para insertar el nuevo usuario en la tabla 'usuarios'
            $stmt_insert = $conexion->prepare("INSERT INTO usuarios(nombre, apellido, email, password, rol) VALUES(?, ?, ?, ?, ?)");
            // Vincula los parámetros a la consulta preparada
            $stmt_insert->bind_param("sssss", $nombre, $apellido, $correo, $hashed_password, $rol_default);

            // Si la inserción fue exitosa
            if ($stmt_insert->execute()) {
                // Obtener los datos del usuario recién registrado para la sesión
                $stmt_get_user = $conexion->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE email = ?");
                $stmt_get_user->bind_param("s", $correo);
                $stmt_get_user->execute();
                $result_get_user = $stmt_get_user->get_result();
                $datos = $result_get_user->fetch_object();

                // Guarda los datos del nuevo usuario en variables de sesión
                $_SESSION["usuario_id"] = $datos->id;
                $_SESSION["usuario_correo"] = $datos->email;
                $_SESSION["usuario_nombre"] = $datos->nombre;
                $_SESSION["usuario_rol"] = $datos->rol;

                // Redirige al usuario a la página de inicio
                header("Location: index.php");
                exit; // Termina la ejecución del script
            } else {
                $message = 'Error al registrar el usuario.'; // Mensaje de error si la inserción falla
                $message_type = 'error';
            }
        }
    }
}
?>
<!-- El HTML de registro se ha movido a registrarse.php para una mejor estructura -->