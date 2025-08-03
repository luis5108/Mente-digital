<?php
include 'conexion.php';
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

    <form class="auth-form" action="registrarse-logica.php" method="POST">
      <div class="form-row">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" required />
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" name="apellido" required />
        </div>
      </div>

      <div class="form-group">
        <label for="fechaN">Fecha de nacimiento</label>
        <input type="date" id="fechaN" name="fechaN" required />
      </div>

      <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" required />
      </div>

      <div class="form-group">
        <label for="clave">Contraseña</label>
        <input type="password" id="clave" name="clave" required />
      </div>

      <div class="form-group">
        <label for="C_clave">Confirmar contraseña</label>
        <input type="password" id="C_clave" name="C_clave" required />
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
