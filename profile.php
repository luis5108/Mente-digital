<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
include 'header.php';
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

include 'eliminar-favoritos-celular.php';
// Redirige si el usuario no está logueado (no hay 'usuario_id' en la sesión)
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Obtiene el ID del usuario de la sesión
$user_id = $_SESSION["usuario_id"];
// Inicializa la variable para los datos del usuario
$user_data = null;
// Obtiene el mensaje de la URL si existe, si no, lo deja vacío
$message = $_GET['message'] ?? '';
// Obtiene el tipo de mensaje (success/error) de la URL si existe, si no, lo deja vacío
$message_type = $_GET['status'] ?? '';

// Prepara una consulta para obtener el nombre, apellido, email y rol del usuario actual
$stmt = $conexion->prepare("SELECT nombre, apellido, email, rol FROM usuarios WHERE id = ?");
// Vincula el ID del usuario a la consulta preparada (i = integer)
$stmt->bind_param("i", $user_id);
// Ejecuta la consulta
$stmt->execute();
// Obtiene el resultado de la consulta
$result = $stmt->get_result();

// Si se encontró el usuario en la base de datos
if ($result->num_rows > 0) {
    // Almacena los datos del usuario como un array asociativo
    $user_data = $result->fetch_assoc();
} else {
    // Si por alguna razón el usuario no se encuentra (ej. fue eliminado de la DB),
    // destruye la sesión y redirige al login con un mensaje de error
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: login.php?status=error&message=Usuario no encontrado.");
    exit;

}
// Obtener los celulares favoritos del usuario
$fav_query = $conexion->prepare("
    SELECT celulares.id, celulares.nombre, celulares.imagen, celulares.pantalla, celulares.procesador
    FROM favoritos
    INNER JOIN celulares ON favoritos.celular_id = celulares.id
    WHERE favoritos.usuario_id = ?
");
$fav_query->bind_param("i", $user_id);
$fav_query->execute();
$fav_result = $fav_query->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Mente-digital</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos específicos para la página de perfil */
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: #2a2a2a;
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 224, 224, 0.15);
            border: 1px solid rgba(0, 224, 224, 0.2);
        }

        .profile-container h2 {
            text-align: center;
            color: #00e0e0;
            margin-bottom: 2rem;
        }

        .profile-info p {
            margin-bottom: 1rem;
            color: #e0e0e0;
            font-size: 1.1rem;
        }

        .profile-info strong {
            color: #e000e0;
        }

        .profile-section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0, 224, 224, 0.1);
        }

        .profile-section h3 {
            color: #00e0e0;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .profile-form .form-group {
            margin-bottom: 1.5rem;
        }

        .profile-form label {
            display: block;
            margin-bottom: 0.5rem;
            color: #e0e0e0;
            font-weight: 500;
        }

        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            background-color: #1a1a1a;
            border: 1px solid rgba(0, 224, 224, 0.3);
            border-radius: 4px;
            color: #e0e0e0;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-form input[type="text"]:focus,
        .profile-form input[type="email"]:focus,
        .profile-form input[type="password"]:focus {
            border-color: #e000e0;
            box-shadow: 0 0 8px rgba(224, 0, 224, 0.5);
            outline: none;
        }

        .profile-form .btn-primary {
            margin-top: 1rem;
            width: auto;
            padding: 0.8rem 2rem;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .message.success {
            background-color: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #51cf66;
        }

        .message.error {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
        }
    </style>
</head>

<body>
    <main>
        <section class="section-padding">
            <div class="profile-container">
                <h2>Mi Perfil</h2>

                <?php if ($message): // Muestra el mensaje si existe ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="profile-info">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user_data['nombre']); ?></p>
                    <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user_data['apellido']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    <p><strong>Rol:</strong> <?php echo htmlspecialchars($user_data['rol']); ?></p>
                </div>

                <div class="profile-section">
                    <h3>Actualizar Información Personal</h3>
                    <form class="profile-form" action="profile-logica.php" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <!-- Campo oculto para indicar la acción -->
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre"
                                value="<?php echo htmlspecialchars($user_data['nombre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido"
                                value="<?php echo htmlspecialchars($user_data['apellido']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn-primary">Guardar Cambios</button>
                    </form>





                    <div class="profile-section">
                        <h3>Mis Celulares Favoritos</h3>
                        <?php if ($fav_result->num_rows > 0): ?>
                            <div class="favorites-grid"
                                style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                                <?php while ($cel = $fav_result->fetch_assoc()): ?>
                                    <div class="favorite-card"
                                        style="background: #1a1a1a; padding: 1rem; border-radius: 8px; border: 1px solid #00e0e050; box-shadow: 0 0 10px #00e0e020;">
                                        <img src="<?php echo htmlspecialchars($cel['imagen']); ?>"
                                            alt="<?php echo htmlspecialchars($cel['nombre']); ?>"
                                            style="width: 100%; height: 150px; object-fit: contain; border-radius: 6px;">
                                        <h4 style="color: #00e0e0; margin: 1rem 0 0.5rem;">
                                            <?php echo htmlspecialchars($cel['nombre']); ?>
                                        </h4>
                                        <p style="color: #ccc;"><strong>Pantalla:</strong>
                                            <?php echo htmlspecialchars($cel['pantalla']); ?></p>
                                        <p style="color: #ccc;"><strong>Procesador:</strong>
                                            <?php echo htmlspecialchars($cel['procesador']); ?></p>
                                        <?php
                                        echo '<form method="GET" action="profile.php">';
                                        echo '  <input type="hidden" name="celular_id" value="' . $cel['id'] . '">';
                                        echo '  <button type="submit" class="btn-secondary">Eliminar de Favoritos</button>';
                                        echo '</form>';

                                        ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p style="color: #ccc;">Aún no tienes celulares favoritos.</p>
                        <?php endif; ?>

                        <div class="profile-section">
                            <h3>Cambiar Contraseña</h3>
                            <form class="profile-form" action="profile-logica.php" method="POST">
                                <input type="hidden" name="action" value="change_password">
                                <!-- Campo oculto para indicar la acción -->
                                <div class="form-group">
                                    <label for="old_password">Contraseña Actual:</label>
                                    <input type="password" id="old_password" name="old_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" id="new_password" name="new_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_new_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" id="confirm_new_password" name="confirm_new_password"
                                        required>
                                </div>
                                <button type="submit" class="btn-primary">Cambiar Contraseña</button>
                                <?php if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === 'admin') {
                                echo'    <a href="dashboard.php" class="btn-primary"
                                        style="display:inline-block; padding:0.8rem 2rem; text-align:center; margin-top:1rem;">Ir
                                        al Dashboard</a>';}
                                ?>

                            </form>
                        </div>
                    </div>
        </section>
    </main>
    </div>
    <?php include 'footer.php'; // Incluye el pie de página ?>
</body>

</html>