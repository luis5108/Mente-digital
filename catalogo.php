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
    <?php include 'header.php'; ?>
    <?php include 'data.php'; // Incluimos los datos de los celulares ?>

    <main>
        <section id="catalogo" class="section-padding">
            <h2 class="section-title">Nuestros Celulares <span class="neon-text">Destacados</span></h2>
            <p class="section-description">Descubre una amplia gama de smartphones con las especificaciones más
                recientes y detalladas.</p>
            <div class="container">
                <?php
                // Iterar sobre todos los celulares disponibles en data.php
                foreach ($celulares_data as $celular) {
                    echo '<div class="phone-card">';
                    echo '    <img src="' . htmlspecialchars($celular['imagen']) . '" alt="Imagen de ' . htmlspecialchars($celular['nombre']) . '">';
                    echo '    <h2>' . htmlspecialchars($celular['nombre']) . '</h2>';
                    echo '    <div class="specs">';
                    echo '        <p><strong>Pantalla:</strong> ' . htmlspecialchars($celular['pantalla']) . '</p>';
                    echo '        <p><strong>Procesador:</strong> ' . htmlspecialchars($celular['procesador']) . '</p>';
                    echo '        <p><strong>Cámara:</strong> ' . htmlspecialchars($celular['camara_principal']) . '</p>';
                    echo '        <p><strong>Almacenamiento:</strong> ' . htmlspecialchars($celular['almacenamiento']) . '</p>';
                    echo '    </div>';
                    echo '    <a href="#" class="btn-secondary">Ver Detalles</a>'; // Podrías enlazar a una página de detalles aquí
                    echo '</div>';
                }
                ?>
            </div>
            <div class="text-center mt-4">
                <!-- En un entorno PHP puro, "Cargar Más" implicaría recargar la página con un offset o un nuevo conjunto de datos. -->
                <!-- Para esta demostración, ya estamos mostrando todos los celulares del array. -->
                <a href="catalogo.php" class="btn-primary">Cargar Más Celulares</a>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>