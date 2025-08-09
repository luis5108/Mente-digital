<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
include 'header.php';
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';
// Incluye el archivo de lógica de registro para manejar el envío del formulario y la creación de usuario
include 'registrarse-logica.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Registro</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <h1>Crear Cuenta</h1>
      <p>Regístrate para comenzar</p>
    </div>
    <?php if ($message): // Muestra el mensaje si la variable $message no está vacía ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form class="auth-form" action="registrarse-logica.php" method="POST">
      <div class="form-row">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); // Mantiene el valor del nombre en el campo ?>"/>
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" name="apellido" required value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); // Mantiene el valor del apellido en el campo ?>"/>
        </div>
      </div>

      <div class="form-group">
        <label for="fechaN">Fecha de nacimiento</label>
        <input type="date" id="fechaN" name="fechaN" value="<?php echo htmlspecialchars($_POST['fechaN'] ?? ''); // Mantiene el valor de la fecha de nacimiento en el campo ?>"/>
      </div>

      <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" required value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); // Mantiene el valor del correo en el campo ?>"/>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="C_password">Confirmar contraseña</label>
        <input type="password" id="C_password" name="C_password" required />
      </div>

      <button type="submit" name="btn-primary" value="OK">Registrarse</button>
    </form>

    <div class="auth-links">
      <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
  </div>
</div>
</body>

</html>
