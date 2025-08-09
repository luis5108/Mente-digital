<?php
include 'conexion.php'; // Asegúrate de que este archivo tenga $conexion listo

// Validar que se haya recibido el celular_id por GET
if (isset($_GET['celular_id']) && is_numeric($_GET['celular_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $celular_id = intval($_GET['celular_id']); // Sanitiza el valor

    // Verificar si ya está en favoritos
    $verifica = $conexion->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND celular_id = ?");
    $verifica->bind_param("ii", $usuario_id, $celular_id);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        // Eliminar de favoritos
        $stmt = $conexion->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND celular_id = ?");
        $stmt->bind_param("ii", $usuario_id, $celular_id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">✅ Celular eliminado de favoritos con éxito.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">❌ Error al eliminar el celular de favoritos.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-info" role="alert">Este celular no está en tus favoritos.</div>';
    }

    $verifica->close();
} else {
    echo '<div class="alert alert-danger" role="alert">ID de celular no válido.</div>';
}
?>