<?php
/*$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
} */
require '../src/server/conecta.php';
$con = conecta();

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Obtener datos del cliente
$data = json_decode(file_get_contents("php://input"), true);
$correo = $data['correo'];
$token = $data['token'];

// Verificar si el token es válido
$query = "
    SELECT t.token
    FROM tokens t
    JOIN usuarios u ON u.id = t.user_id
    WHERE u.correo = $1 AND t.token = $2 AND t.valido_hasta > NOW();
";
$result = pg_query_params($conn, $query, array($correo, $token));

if (pg_num_rows($result) > 0) {
    echo json_encode(["status" => "success", "message" => "Token válido."]);
} else {
    echo json_encode(["status" => "error", "message" => "Token incorrecto o expirado."]);
}

pg_close($conn);
?>
