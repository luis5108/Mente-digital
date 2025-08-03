<?php include 'header.php'; ?>
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

            <form class="auth-form" action="login-logica.php" method="POST">
                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo" required />
                </div>

                <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required />
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="recordar" name="recordar" />
                    <label for="recordar">Recordarme</label>
                </div>

                <button type="submit" name="btn-login" value="OK">Iniciar sesión</button>
            </form>

            <div class="auth-links">
                <p>¿No tienes cuenta? <a href="registrarse.php">Regístrate</a></p>
            </div>
        </div>
    </div>
</body>

</html>