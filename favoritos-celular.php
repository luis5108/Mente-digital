<?php
include 'conexion.php'; // Asegúrate de que este archivo tenga $conexion listo


// Validar que se haya recibido el celular_id por GET
if (isset($_GET['celular_id']) && is_numeric($_GET['celular_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $celular_id = intval($_GET['celular_id']); // Sanitiza el valor

    // Verificar si ya está en favoritos (opcional pero recomendable)
    $verifica = $conexion->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND celular_id = ?");
    $verifica->bind_param("ii", $usuario_id, $celular_id);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        echo '<div class="alert alert-info" role="alert">Este celular ya está en tus favoritos.</div>';
    } else {
        // Insertar en la tabla de favoritos
        $stmt = $conexion->prepare("INSERT INTO favoritos (usuario_id, celular_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $usuario_id, $celular_id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">✅ Celular añadido a favoritos con éxito.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">❌ Error al añadir el celular a favoritos.</div>';
        }
        $stmt->close();
    }

    $verifica->close();
} else {
    echo '<div class="alert alert-danger" role="alert">ID de celular no válido.</div>';
}
?>