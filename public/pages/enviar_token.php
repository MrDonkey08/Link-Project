<?php
require '../src/server/conecta.php';
$con = conecta();

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Obtener correo del cliente
$data = json_decode(file_get_contents("php://input"), true);
$correo = $data['correo'];

// Verificar si el correo existe
$query = "SELECT id, nombre FROM usuarios WHERE correo = $1";
$result = pg_query_params($conn, $query, array($correo));

if (pg_num_rows($result) > 0) {
    // Generar un token único
    $token = rand(1000, 9999);
    $row = pg_fetch_assoc($result);
    $user_id = $row['id'];
    $nombre = $row['nombre'];

    // Insertar o actualizar token en la tabla `tokens`
    $insert_query = "
        INSERT INTO tokens (user_id, token, creado_en, valido_hasta)
        VALUES ($1, $2, NOW(), NOW() + INTERVAL '15 minutes')
        ON CONFLICT (user_id) DO UPDATE
        SET token = $2, creado_en = NOW(), valido_hasta = NOW() + INTERVAL '15 minutes';
    ";
    pg_query_params($conn, $insert_query, array($user_id, $token));

    // Enviar correo al usuario
    $asunto = "Recuperación de contraseña";
    $mensaje = "Hola $nombre,\n\nEste es tu número de token: $token\n\nUtilízalo para cambiar tu contraseña.";
    $cabeceras = "From: no-reply@example.com";

    if (mail($correo, $asunto, $mensaje, $cabeceras)) {
        echo json_encode(["status" => "success", "message" => "Token enviado a $correo"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo enviar el correo."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Correo no encontrado."]);
}

pg_close($conn);
?>
