<?php
// Iniciar sesión solo si no hay una sesión activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">mente<span class="neon-text">-digital</span></div>
            <ul class="nav-links">
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="comparador.php">Comparador</a></li>
                <li><a href="nosotros.php">Nosotros</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <?php if (isset($_SESSION["usuario_id"])): // Comprueba si el usuario está logueado (sea admin o no) ?>
                    <?php if (isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === 'admin'): // Si el rol del usuario es 'admin' ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="profile.php">Mi Perfil</a></li> <!-- Nuevo enlace al perfil del usuario -->
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: // Si el usuario no está logueado ?>
                    <li><a href="login.php">Acceder</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>