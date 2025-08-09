<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Celulares - Mente-digital</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">



</head>

<body>
    <?php include 'header.php'; // Incluye la cabecera de la página, que ahora inicia la sesión ?>
    <?php include 'data.php'; // Incluye el archivo que contiene las funciones para interactuar con la base de datos ?>
    <?php include 'favoritos-celular.php'; ?>


    <main>
        <section id="catalogo" class="section-padding">
            <h2 class="section-title">Nuestros Celulares <span class="neon-text">Destacados</span></h2>
            <p class="section-description">Descubre una amplia gama de smartphones con las especificaciones más
                recientes y detalladas.</p>
            <div class="container">
                <?php
                // Obtiene todos los celulares de la base de datos
                $celulares = getAllCelulares();
                // Comprueba si el array de celulares no está vacío
                if (!empty($celulares)) {
                    // Itera sobre cada celular para mostrarlo en una "phone-card"
                    foreach ($celulares as $celular) {

                        echo '<div class="phone-card">';
                        echo '    <img src="' . htmlspecialchars($celular['imagen']) . '" alt="Imagen de ' . htmlspecialchars($celular['nombre']) . '">';
                        echo '    <h2>' . htmlspecialchars($celular['nombre']) . '</h2>';
                        echo '    <div class="specs">';
                        echo '        <p><strong>Pantalla:</strong> ' . htmlspecialchars($celular['pantalla']) . '</p>';
                        echo '        <p><strong>Procesador:</strong> ' . htmlspecialchars($celular['procesador']) . '</p>';
                        echo '        <p><strong>Cámara:</strong> ' . htmlspecialchars($celular['camara_principal']) . '</p>';
                        echo '        <p><strong>Almacenamiento:</strong> ' . htmlspecialchars($celular['almacenamiento']) . '</p>';
                        echo '    </div>';
                        echo '<form method="GET">';
                        echo '    <input type="hidden" name="celular_id" value="' . $celular['id'] . '">';
                        echo '    <button type="submit" class="btn-secondary">Añadir a Favoritos</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    // Si no hay celulares, muestra un mensaje
                    echo '<p class="text-center">No hay celulares disponibles en el catálogo.</p>';
                }
                ?>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn-primary">Volver al inicio</a>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; // Incluye el pie de página ?>
    <!-- Scripts opcionales de Bootstrap -->


</body>


</html>