<?php
// Incluye el archivo de cabecera para asegurar que la sesión esté iniciada
require_once 'header.php';
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

// Redirige si el usuario no está logueado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Obtiene el ID del usuario de la sesión
$user_id = $_SESSION["usuario_id"];
// Inicializa variables para mensajes de estado
$message = '';
$status = '';

// Comprueba si la solicitud HTTP es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene la acción a realizar (update_profile o change_password) desde los datos POST
    $action = $_POST['action'] ?? '';

    // Si la acción es actualizar el perfil
    if ($action === 'update_profile') {
        // Obtiene los nuevos datos del perfil desde el formulario
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $email = $_POST['email'] ?? '';

        // Valida si los campos obligatorios están vacíos
        if (empty($nombre) || empty($apellido) || empty($email)) {
            $message = 'Todos los campos son obligatorios.';
            $status = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Valida el formato del email
            $message = 'Formato de email inválido.';
            $status = 'error';
        } else {
            // Prepara una consulta para verificar si el nuevo email ya existe para otro usuario
            $stmt_check_email = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            // Vincula los parámetros: el email y el ID del usuario actual (para excluirlo de la búsqueda)
            $stmt_check_email->bind_param("si", $email, $user_id);
            // Ejecuta la consulta
            $stmt_check_email->execute();
            // Obtiene el resultado
            $result_check_email = $stmt_check_email->get_result();

            // Si el email ya está registrado por otro usuario
            if ($result_check_email->num_rows > 0) {
                $message = 'Este email ya está registrado por otro usuario.';
                $status = 'error';
            } else {
                // Prepara una consulta para actualizar el nombre, apellido y email del usuario
                $stmt_update = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
                // Vincula los parámetros a la consulta preparada
                $stmt_update->bind_param("sssi", $nombre, $apellido, $email, $user_id);

                // Si la actualización fue exitosa
                if ($stmt_update->execute()) {
                    // Actualiza las variables de sesión con los nuevos datos
                    $_SESSION["usuario_nombre"] = $nombre;
                    $_SESSION["usuario_correo"] = $email;
                    $message = 'Información personal actualizada exitosamente.';
                    $status = 'success';
                } else {
                    $message = 'Error al actualizar la información personal.';
                    $status = 'error';
                }
            }
        }
    } elseif ($action === 'change_password') { // Si la acción es cambiar la contraseña
        // Obtiene las contraseñas desde el formulario
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_new_password = $_POST['confirm_new_password'] ?? '';

        // Valida si los campos de contraseña están vacíos
        if (empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
            $message = 'Todos los campos de contraseña son obligatorios.';
            $status = 'error';
        } elseif ($new_password !== $confirm_new_password) { // Valida si la nueva contraseña y su confirmación coinciden
            $message = 'La nueva contraseña y su confirmación no coinciden.';
            $status = 'error';
        } elseif (strlen($new_password) < 6) { // Ejemplo de validación de longitud mínima para la nueva contraseña
            $message = 'La nueva contraseña debe tener al menos 6 caracteres.';
            $status = 'error';
        } else {
            // Prepara una consulta para obtener la contraseña hasheada actual del usuario
            $stmt_get_password = $conexion->prepare("SELECT password FROM usuarios WHERE id = ?");
            // Vincula el ID del usuario
            $stmt_get_password->bind_param("i", $user_id);
            // Ejecuta la consulta
            $stmt_get_password->execute();
            // Obtiene el resultado
            $result_get_password = $stmt_get_password->get_result();
            // Almacena la fila como un array asociativo
            $user_db = $result_get_password->fetch_assoc();

            // Verifica si se encontró el usuario y si la contraseña antigua ingresada coincide con la hasheada en la DB
            if ($user_db && password_verify($old_password, $user_db['password'])) {
                // Hashea la nueva contraseña antes de guardarla
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Prepara una consulta para actualizar la contraseña del usuario
                $stmt_update_password = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                // Vincula los parámetros
                $stmt_update_password->bind_param("si", $hashed_new_password, $user_id);

                // Si la actualización de la contraseña fue exitosa
                if ($stmt_update_password->execute()) {
                    $message = 'Contraseña cambiada exitosamente.';
                    $status = 'success';
                } else {
                    $message = 'Error al cambiar la contraseña.';
                    $status = 'error';
                }
            } else {
                $message = 'La contraseña actual es incorrecta.'; // Mensaje de error si la contraseña antigua no coincide
                $status = 'error';
            }
        }
    }
}

// Redirige de vuelta a la página de perfil con el mensaje y el estado en la URL
header("Location: profile.php?status=" . urlencode($status) . "&message=" . urlencode($message));
exit; // Termina la ejecución del script
?>
