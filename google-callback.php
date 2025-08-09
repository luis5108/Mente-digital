<?php
session_start();
include 'conexion.php'; 
if (isset($_POST['credential'])) {
    $id_token = $_POST['credential'];

    // Validar token con Google
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($id_token);
    $response = file_get_contents($url);
    $payload = json_decode($response, true);

    if (isset($payload['email']) && isset($payload['aud'])) {
        // Verificamos que el token sea para nuestra app
        if ($payload['aud'] !== '593307192100-0u73s7s4vvm8dn4u78j0t6osjoqr7j41.apps.googleusercontent.com') {
            die("Token inválido: App incorrecta");
        }

        $email = $payload['email'];
        $name = $payload['name'] ?? '';
        
        // Buscar usuario en base de datos
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
        } else {
            // Crear nuevo usuario
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, '')");
            $stmt->bind_param("ss", $name, $email);
            $stmt->execute();

            $_SESSION['usuario_id'] = $stmt->insert_id;
            $_SESSION['usuario_nombre'] = $name;
        }

        header("Location: index.php");
        exit;
    } else {
        echo "Error: Token inválido";
    }
} else {
    echo "No se recibió token";
}
