<?php
include 'login-logica.php';
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
include 'header.php';
// Incluye el archivo de lógica de login para manejar el envío del formulario y la autenticación

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="neon-text">Bienvenido</h1>
                <p>Inicia sesión para continuar</p>
            </div>
            <?php if (!empty($error)): // Muestra el mensaje de error si la variable $error no está vacía ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form class="auth-form" method="POST">
                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" required
                        value="<?php echo isset($_POST["correo"]) ? htmlspecialchars($_POST["correo"]) : ''; ?>" />

                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="recordar" name="recordar" />
                    <label for="recordar">Recordarme</label>
                </div>

                <button type="submit" name="btn-login" value="OK">Iniciar sesión</button>
            </form>
            <!-- Google Sign-In -->
            <script src="https://accounts.google.com/gsi/client" async defer></script>

            <div id="g_id_onload"
                data-client_id="593307192100-0u73s7s4vvm8dn4u78j0t6osjoqr7j41.apps.googleusercontent.com"
                data-login_uri="http://localhost/phone-specs-page-(3)/google-callback.php" data-auto_prompt="false">
            </div>

            <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left">
            </div>
            <div class="auth-links">
                <p>¿No tienes cuenta? <a href="registrarse.php">Regístrate</a></p>
            </div>

        </div>
    </div>
</body>

</html>