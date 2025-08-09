<?php
// Incluye el archivo de cabecera, que se encarga de iniciar la sesión si no está activa
require_once 'header.php';
// Incluye el archivo que contiene las funciones para interactuar con la base de datos
require_once 'data.php';

// Verifica si la variable de sesión 'usuario_rol' está definida y si su valor NO es 'admin'
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}


// Obtiene todos los celulares de la base de datos usando la función definida en data.php
$celulares = getAllCelulares();

// Obtiene el mensaje de la URL si existe, si no, lo deja vacío
$message = $_GET['message'] ?? '';
// Obtiene el tipo de mensaje (success/error) de la URL si existe, si no, lo deja vacío
$message_type = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Mente-digital</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos específicos para el dashboard */
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 2.5rem;
            color: #e0e0e0;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background-color: #2a2a2a;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 224, 224, 0.15);
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 224, 224, 0.1);
            color: #e0e0e0;
        }

        .dashboard-table th {
            background-color: #0d0d0d;
            font-weight: bold;
            color: #00e0e0;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .dashboard-table tr:last-child td {
            border-bottom: none;
        }

        .dashboard-table tbody tr:hover {
            background-color: #3a3a3a;
        }

        .dashboard-table img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 4px;
        }

        .dashboard-actions a {
            margin-right: 0.5rem;
            color: #00e0e0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .dashboard-actions a:hover {
            color: #e000e0;
        }

        .dashboard-actions form {
            display: inline-block;
            margin: 0;
        }

        .dashboard-actions button {
            background: none;
            border: none;
            color: #e000e0;
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
            transition: color 0.3s ease;
        }

        .dashboard-actions button:hover {
            color: #00e0e0;
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

        @media (max-width: 768px) {

            .dashboard-table,
            .dashboard-table tbody,
            .dashboard-table tr,
            .dashboard-table th,
            .dashboard-table td {
                display: block;
            }

            .dashboard-table thead {
                display: none;
            }

            .dashboard-table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(0, 224, 224, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .dashboard-table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .dashboard-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 1rem;
                font-weight: bold;
                text-align: left;
                color: #00e0e0;
            }
        }
    </style>
</head>

<body>

    <main>
        <section id="dashboard" class="section-padding">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <h2 class="section-title">Gestión de Celulares</h2>
                    <a href="add-celular.php" class="btn-primary">Añadir Nuevo Celular</a>
                </div>

                <?php if ($message): // Comprueba si hay un mensaje para mostrar ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); // Muestra el mensaje, escapando caracteres especiales ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($celulares)): // Comprueba si el array de celulares está vacío ?>
                    <p class="text-center">No hay celulares registrados.</p>
                <?php else: // Si hay celulares, muestra la tabla ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Código ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Pantalla</th>
                                <th>Procesador</th>
                                <th>Almacenamiento</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($celulares as $celular): // Itera sobre cada celular para mostrarlo en una fila ?>
                                <tr>
                                    <td data-label="Código ID"><?php echo htmlspecialchars($celular['codigo_id']); ?></td>
                                    <td data-label="Imagen"><img src="<?php echo htmlspecialchars($celular['imagen']); ?>"
                                            alt="<?php echo htmlspecialchars($celular['nombre']); ?>"></td>
                                    <td data-label="Nombre"><?php echo htmlspecialchars($celular['nombre']); ?></td>
                                    <td data-label="Pantalla"><?php echo htmlspecialchars($celular['pantalla']); ?></td>
                                    <td data-label="Procesador"><?php echo htmlspecialchars($celular['procesador']); ?></td>
                                    <td data-label="Almacenamiento"><?php echo htmlspecialchars($celular['almacenamiento']); ?>
                                    </td>
                                    <td data-label="Precio"><?php echo htmlspecialchars($celular['precio']); ?></td>
                                    <td data-label="Acciones" class="dashboard-actions">
                                        <a
                                            href="edit-celular.php?codigo_id=<?php echo htmlspecialchars($celular['codigo_id']); ?>">Editar</a>
                                        <form action="delete-celular.php" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este celular?');">
                                            <input type="hidden" name="codigo_id"
                                                value="<?php echo htmlspecialchars($celular['codigo_id']); ?>">
                                            <button type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; // Incluye el pie de página ?>
</body>

</html>