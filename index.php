<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Mente-digital - Tu Guía Completa de Smartphones</title>
 <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
 <?php include 'header.php'; // Incluye la cabecera de la página, que ahora inicia la sesión ?>
 <?php include 'data.php'; // Incluye el archivo que contiene las funciones para interactuar con la base de datos ?>

 <main>
     <section class="hero">
         <div class="hero-content">
             <h1>Encuentra el Celular <span class="neon-text">Perfecto</span> para Ti</h1>
             <p>Explora especificaciones detalladas, compara modelos y toma la mejor decisión de compra.</p>
             <a href="catalogo.php" class="btn-primary">Explorar Catálogo</a>
         </div>
     </section>

     <section id="latest-phones" class="section-padding">
         <h2 class="section-title">Últimos <span class="neon-text">Lanzamientos</span></h2>
         <p class="section-description">Mantente al día con los smartphones más recientes y sus innovadoras características.</p>
         <div class="container">
             <?php
             // Obtiene todos los celulares de la base de datos
             $all_celulares = getAllCelulares();
             // Selecciona los últimos 3 celulares del array (asumiendo que son los "últimos lanzamientos")
             $latest_phones = array_slice($all_celulares, -3);
             // Comprueba si hay celulares para mostrar
             if (!empty($latest_phones)) {
                 // Itera sobre los últimos 3 celulares para mostrarlos en tarjetas
                 foreach ($latest_phones as $celular) {
                     echo '<div class="phone-card">';
                     echo '    <img src="' . htmlspecialchars($celular['imagen']) . '" alt="Imagen de ' . htmlspecialchars($celular['nombre']) . '">';
                     echo '    <h2>' . htmlspecialchars($celular['nombre']) . '</h2>';
                     echo '    <div class="specs">';
                     echo '        <p><strong>Pantalla:</strong> ' . htmlspecialchars($celular['pantalla']) . '</p>';
                     echo '        <p><strong>Procesador:</strong> ' . htmlspecialchars($celular['procesador']) . '</p>';
                     echo '        <p><strong>Cámara:</strong> ' . htmlspecialchars($celular['camara_principal']) . '</p>';
                     echo '        <p><strong>Almacenamiento:</strong> ' . htmlspecialchars($celular['almacenamiento']) . '</p>';
                     echo '    </div>';
                     echo '    <a href="catalogo.php" class="btn-secondary">Ver Mas</a>';
                     echo '</div>';
                 }
             } else {
                 // Si no hay celulares, muestra un mensaje
                 echo '<p class="text-center">No hay celulares disponibles para mostrar los últimos lanzamientos.</p>';
             }
             ?>
         </div>
         <div class="text-center mt-4">
             <a href="catalogo.php" class="btn-primary">Ver Catálogo Completo</a>
         </div>
     </section>

     <section id="why-us" class="section-padding bg-dark-alt">
         <h2 class="section-title">Nuestras <span class="neon-text">Ventajas</span></h2>
         <p class="section-description">Descubre por qué CelularInfo es tu mejor aliado para elegir tu próximo smartphone.</p>
         <div class="container features-grid">
             <div class="feature-item">
                 <h3>Datos Precisos</h3>
                 <p>Información técnica verificada y actualizada constantemente para tu tranquilidad.</p>
             </div>
             <div class="feature-item">
                 <h3>Comparaciones Claras</h3>
                 <p>Herramientas intuitivas para ver las diferencias clave entre modelos al instante.</p>
             </div>
             <div class="feature-item">
                 <h3>Amplia Variedad</h3>
                 <p>Un extenso catálogo con smartphones de todas las marcas y rangos de precio.</p>
             </div>
             <div class="feature-item">
                 <h3>Diseño Intuitivo</h3>
                 <p>Navega fácilmente y encuentra lo que buscas sin complicaciones.</p>
             </div>
         </div>
     </section>

     <section id="cta" class="section-padding text-center">
         <h2 class="section-title">¿Listo para Encontrar tu <span class="neon-text">Celular Ideal</span>?</h2>
         <p class="section-description">No pierdas más tiempo buscando. Empieza a explorar nuestro catálogo ahora mismo.</p>
         <a href="catalogo.php" class="btn-primary">¡Empieza Ahora!</a>
     </section>
 </main>

 <?php include 'footer.php'; // Incluye el pie de página ?>
</body>
</html>
