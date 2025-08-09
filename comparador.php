<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Comparador de Celulares - Mente-digital</title>
 <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
 <?php include 'header.php'; // Incluye la cabecera de la página, que ahora inicia la sesión ?>
 <?php include 'data.php'; // Incluye el archivo que contiene las funciones para interactuar con la base de datos ?>

 <main>
     <section id="comparador" class="section-padding bg-dark-alt">
         <h2 class="section-title">Compara Modelos <span class="neon-text">Fácilmente</span></h2>
         <p class="section-description">Selecciona dos celulares para ver sus especificaciones lado a lado y tomar la mejor decisión de compra.</p>
         <div class="container">
             <form method="POST" action="comparador.php" class="comparison-form">
                 <div class="form-group">
                     <label for="celular1">Selecciona Celular 1:</label>
                     <select name="celular1" id="celular1" required>
                         <option value="">-- Selecciona --</option>
                         <?php
                         // Obtiene todos los celulares para llenar los selectores
                         $all_celulares = getAllCelulares();
                         // Itera sobre cada celular para crear una opción en el selector 1
                         foreach ($all_celulares as $celular): ?>
                             <option value="<?php echo htmlspecialchars($celular['codigo_id']); ?>"
                                 <?php echo (isset($_POST['celular1']) && $_POST['celular1'] === $celular['codigo_id']) ? 'selected' : ''; // Mantiene la opción seleccionada después de enviar el formulario ?>>
                                 <?php echo htmlspecialchars($celular['nombre']); ?>
                             </option>
                         <?php endforeach; ?>
                     </select>
                 </div>
                 <div class="form-group">
                     <label for="celular2">Selecciona Celular 2:</label>
                     <select name="celular2" id="celular2" required>
                         <option value="">-- Selecciona --</option>
                         <?php foreach ($all_celulares as $celular): // Itera sobre cada celular para crear una opción en el selector 2 ?>
                             <option value="<?php echo htmlspecialchars($celular['codigo_id']); ?>"
                                 <?php echo (isset($_POST['celular2']) && $_POST['celular2'] === $celular['codigo_id']) ? 'selected' : ''; // Mantiene la opción seleccionada después de enviar el formulario ?>>
                                 <?php echo htmlspecialchars($celular['nombre']); ?>
                             </option>
                         <?php endforeach; ?>
                     </select>
                 </div>
                 <button type="submit" class="btn-primary">Comparar</button>
             </form>

             <?php
             // Inicializa las variables para los datos de los celulares a comparar
             $celular1_data = null;
             $celular2_data = null;

             // Comprueba si la solicitud es POST y si se han enviado los IDs de ambos celulares
             if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['celular1']) && isset($_POST['celular2'])) {
                 // Obtiene los IDs de los celulares desde los datos POST
                 $id1 = $_POST['celular1'];
                 $id2 = $_POST['celular2'];

                 // Obtiene los datos completos de cada celular desde la base de datos
                 $celular1_data = getCelularByCodigoId($id1);
                 $celular2_data = getCelularByCodigoId($id2);

                 // Si ambos celulares se encontraron en la base de datos
                 if ($celular1_data && $celular2_data) {
                     echo '<div class="comparison-grid">';
                     // Muestra la tarjeta del Celular 1
                     echo '<div class="comparison-card">';
                     echo '    <h3>' . htmlspecialchars($celular1_data['nombre']) . '</h3>';
                     echo '    <img src="' . htmlspecialchars($celular1_data['imagen']) . '" alt="Imagen de ' . htmlspecialchars($celular1_data['nombre']) . '">';
                     echo '    <ul class="comparison-specs">';
                     echo '        <li><strong>Pantalla:</strong> ' . htmlspecialchars($celular1_data['pantalla']) . '</li>';
                     echo '        <li><strong>Procesador:</strong> ' . htmlspecialchars($celular1_data['procesador']) . '</li>';
                     echo '        <li><strong>RAM:</strong> ' . htmlspecialchars($celular1_data['ram']) . '</li>';
                     echo '        <li><strong>Almacenamiento:</strong> ' . htmlspecialchars($celular1_data['almacenamiento']) . '</li>';
                     echo '        <li><strong>Cámara Principal:</strong> ' . htmlspecialchars($celular1_data['camara_principal']) . '</li>';
                     echo '        <li><strong>Cámara Frontal:</strong> ' . htmlspecialchars($celular1_data['camara_frontal']) . '</li>';
                     echo '        <li><strong>Batería:</strong> ' . htmlspecialchars($celular1_data['bateria']) . '</li>';
                     echo '        <li><strong>Sistema Operativo:</strong> ' . htmlspecialchars($celular1_data['sistema_operativo']) . '</li>'; // Cambiado de 'os'
                     echo '        <li><strong>Resistencia al agua:</strong> ' . htmlspecialchars($celular1_data['resistencia_agua']) . '</li>';
                     echo '        <li><strong>Precio Aprox.:</strong> ' . htmlspecialchars($celular1_data['precio']) . '</li>';
                     echo '    </ul>';
                     echo '</div>';

                     echo '<div class="comparison-vs">VS</div>'; // Separador visual

                     // Muestra la tarjeta del Celular 2
                     echo '<div class="comparison-card">';
                     echo '    <h3>' . htmlspecialchars($celular2_data['nombre']) . '</h3>';
                     echo '    <img src="' . htmlspecialchars($celular2_data['imagen']) . '" alt="Imagen de ' . htmlspecialchars($celular2_data['nombre']) . '">';
                     echo '    <ul class="comparison-specs">';
                     echo '        <li><strong>Pantalla:</strong> ' . htmlspecialchars($celular2_data['pantalla']) . '</li>';
                     echo '        <li><strong>Procesador:</strong> ' . htmlspecialchars($celular2_data['procesador']) . '</li>';
                     echo '        <li><strong>RAM:</strong> ' . htmlspecialchars($celular2_data['ram']) . '</li>';
                     echo '        <li><strong>Almacenamiento:</strong> ' . htmlspecialchars($celular2_data['almacenamiento']) . '</li>';
                     echo '        <li><strong>Cámara Principal:</strong> ' . htmlspecialchars($celular2_data['camara_principal']) . '</li>';
                     echo '        <li><strong>Cámara Frontal:</strong> ' . htmlspecialchars($celular2_data['camara_frontal']) . '</li>';
                     echo '        <li><strong>Batería:</strong> ' . htmlspecialchars($celular2_data['bateria']) . '</li>';
                     echo '        <li><strong>Sistema Operativo:</strong> ' . htmlspecialchars($celular2_data['sistema_operativo']) . '</li>'; // Cambiado de 'os'
                     echo '        <li><strong>Resistencia al agua:</strong> ' . htmlspecialchars($celular2_data['resistencia_agua']) . '</li>';
                     echo '        <li><strong>Precio Aprox.:</strong> ' . htmlspecialchars($celular2_data['precio']) . '</li>';
                     echo '    </ul>';
                     echo '</div>';
                     echo '</div>';
                 } else {
                     // Si uno o ambos celulares no se encontraron, muestra un mensaje de error
                     echo '<p class="text-center mt-4">Por favor, selecciona dos celulares válidos para comparar.</p>';
                 }
             } else {
                 // Si el formulario no ha sido enviado, muestra un mensaje de instrucción
                 echo '<p class="text-center mt-4">Selecciona dos celulares de los menús desplegables para iniciar la comparación.</p>';
             }
             ?>
         </div>
     </section>
 </main>

 <?php include 'footer.php'; // Incluye el pie de página ?>
</body>
</html>
