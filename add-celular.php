<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
require_once 'header.php';
// Incluye el archivo que contiene las funciones para interactuar con la base de datos
require_once 'data.php';

// Redirige si el usuario no es un administrador
if (!isset($_SESSION["usuario_rol"]) || $_SESSION["usuario_rol"] !== 'admin') {
   header("Location: login.php");
   exit;
}

// Inicializa variables para mensajes de estado
$message = '';
$message_type = '';

// Define un array con los nombres de los campos del formulario y sus valores por defecto (vacíos)
$form_data = [
   'codigo_id' => '', 'nombre' => '', 'imagen' => '', 'pantalla' => '',
   'procesador' => '', 'ram' => '', 'almacenamiento' => '', 'camara_principal' => '',
   'camara_frontal' => '', 'bateria' => '', 'sistema_operativo' => '', 'resistencia_agua' => '',
   'precio' => ''
];

// Comprueba si la solicitud HTTP es de tipo POST (es decir, si se envió el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Recorre el array $form_data para asignar los valores recibidos por POST a cada campo
   foreach ($form_data as $key => $value) {
       $form_data[$key] = $_POST[$key] ?? ''; // Usa el operador null coalescing para evitar errores si el campo no existe
   }

   // Valida si ya existe un celular con el mismo 'codigo_id' en la base de datos
   if (getCelularByCodigoId($form_data['codigo_id'])) {
       $message = 'Error: Ya existe un celular con este Código ID. Por favor, usa uno diferente.';
       $message_type = 'error';
   } else {
       // Si el 'codigo_id' no existe, intenta añadir el nuevo celular a la base de datos
       if (addCelular($form_data)) {
           $message = 'Celular añadido exitosamente.';
           $message_type = 'success';
           // Limpia los campos del formulario después de una inserción exitosa
           $form_data = [
               'codigo_id' => '', 'nombre' => '', 'imagen' => '', 'pantalla' => '',
               'procesador' => '', 'ram' => '', 'almacenamiento' => '', 'camara_principal' => '',
               'camara_frontal' => '', 'bateria' => '', 'sistema_operativo' => '', 'resistencia_agua' => '',
               'precio' => ''
           ];
       } else {
           $message = 'Error al añadir el celular.';
           $message_type = 'error';
       }
   }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Añadir Celular - Mente-digital</title>
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <style>
       .form-container {
           max-width: 800px;
           margin: 2rem auto;
           background-color: #2a2a2a;
           padding: 2.5rem;
           border-radius: 8px;
           box-shadow: 0 4px 15px rgba(0, 224, 224, 0.15);
           border: 1px solid rgba(0, 224, 224, 0.2);
       }

       .form-container h2 {
           text-align: center;
           color: #00e0e0;
           margin-bottom: 2rem;
       }

       .form-container .form-group {
           margin-bottom: 1.5rem;
       }

       .form-container label {
           display: block;
           margin-bottom: 0.5rem;
           color: #e0e0e0;
           font-weight: 500;
       }

       .form-container input[type="text"],
       .form-container input[type="url"] {
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

       .form-container input[type="text"]:focus,
       .form-container input[type="url"]:focus {
           border-color: #e000e0;
           box-shadow: 0 0 8px rgba(224, 0, 224, 0.5);
           outline: none;
       }

       .form-actions {
           display: flex;
           justify-content: flex-end;
           gap: 1rem;
           margin-top: 2rem;
       }

       .form-actions .btn-primary {
           padding: 0.8rem 2rem;
           font-size: 1rem;
       }

       .form-actions .btn-secondary {
           padding: 0.8rem 2rem;
           font-size: 1rem;
           background-color: #444;
           color: #e0e0e0;
           border: 1px solid rgba(255, 255, 255, 0.2);
       }

       .form-actions .btn-secondary:hover {
           background-color: #555;
           box-shadow: none;
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
   <?php include 'header.php'; // Incluye la cabecera de la página ?>

   <main>
       <section class="section-padding">
           <div class="form-container">
               <h2>Añadir Nuevo Celular</h2>

               <?php if ($message): // Muestra el mensaje si existe ?>
                   <div class="message <?php echo $message_type; ?>">
                       <?php echo $message; ?>
                   </div>
               <?php endif; ?>

               <form action="add-celular.php" method="POST">
                   <div class="form-group">
                       <label for="codigo_id">Código ID (Único, sin espacios ni caracteres especiales):</label>
                       <input type="text" id="codigo_id" name="codigo_id" required value="<?php echo htmlspecialchars($form_data['codigo_id']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="nombre">Nombre:</label>
                       <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($form_data['nombre']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="imagen">URL de la Imagen (ej: img/nombre-imagen.png):</label>
                       <input type="url" id="imagen" name="imagen" required value="<?php echo htmlspecialchars($form_data['imagen']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="pantalla">Pantalla:</label>
                       <input type="text" id="pantalla" name="pantalla" value="<?php echo htmlspecialchars($form_data['pantalla']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="procesador">Procesador:</label>
                       <input type="text" id="procesador" name="procesador" value="<?php echo htmlspecialchars($form_data['procesador']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="ram">RAM:</label>
                       <input type="text" id="ram" name="ram" value="<?php echo htmlspecialchars($form_data['ram']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="almacenamiento">Almacenamiento:</label>
                       <input type="text" id="almacenamiento" name="almacenamiento" value="<?php echo htmlspecialchars($form_data['almacenamiento']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="camara_principal">Cámara Principal:</label>
                       <input type="text" id="camara_principal" name="camara_principal" value="<?php echo htmlspecialchars($form_data['camara_principal']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="camara_frontal">Cámara Frontal:</label>
                       <input type="text" id="camara_frontal" name="camara_frontal" value="<?php echo htmlspecialchars($form_data['camara_frontal']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="bateria">Batería:</label>
                       <input type="text" id="bateria" name="bateria" value="<?php echo htmlspecialchars($form_data['bateria']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="sistema_operativo">Sistema Operativo:</label>
                       <input type="text" id="sistema_operativo" name="sistema_operativo" value="<?php echo htmlspecialchars($form_data['sistema_operativo']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="resistencia_agua">Resistencia al Agua:</label>
                       <input type="text" id="resistencia_agua" name="resistencia_agua" value="<?php echo htmlspecialchars($form_data['resistencia_agua']); ?>">
                   </div>
                   <div class="form-group">
                       <label for="precio">Precio:</label>
                       <input type="text" id="precio" name="precio" value="<?php echo htmlspecialchars($form_data['precio']); ?>">
                   </div>

                   <div class="form-actions">
                       <a href="dashboard.php" class="btn-secondary">Cancelar</a>
                       <button type="submit" class="btn-primary">Añadir Celular</button>
                   </div>
               </form>
           </div>
       </section>
   </main>

   <?php include 'footer.php'; // Incluye el pie de página ?>
</body>

</html>
