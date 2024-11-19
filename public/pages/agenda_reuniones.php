<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "ID no válido";
  exit;
}
$idUsuario = $_GET['id'];
$con = conecta();
/*$con = conecta();

// <<-------------------------------------------------------- Esto de momento no se toca.
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Recuperar reuniones
$stmt = $pdo->query("SELECT * FROM reuniones ORDER BY fecha, hora");
$reuniones = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Reuniones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container, .meeting-list {
            margin-bottom: 20px;
        }
        .form-container input, .form-container button {
            margin: 5px 0;
        }
        .meeting-item {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Agenda de Reuniones</h1>

    <div class="form-container">
        <h2>Agendar Reunión</h2>
        <form action="procesar.php" method="post">
            <label for="title">Título:</label><br>
            <input type="text" id="title" name="title" required><br>
            <label for="date">Fecha:</label><br>
            <input type="date" id="date" name="date" required><br>
            <label for="time">Hora:</label><br>
            <input type="time" id="time" name="time" required><br>
            <label for="participants">Participantes (separados por comas):</label><br>
            <input type="text" id="participants" name="participants" required><br>
            <button type="submit">Añadir Reunión</button>
        </form>
    </div>

    <div class="meeting-list">
        <h2>Reuniones Programadas</h2>
        <?php if ($reuniones): ?>
            <?php foreach ($reuniones as $reunion): ?>
                <div class="meeting-item">
                    <strong><?php echo htmlspecialchars($reunion['titulo']); ?></strong><br>
                    Fecha: <?php echo htmlspecialchars($reunion['fecha']); ?><br>
                    Hora: <?php echo htmlspecialchars($reunion['hora']); ?><br>
                    Participantes: <?php echo htmlspecialchars($reunion['participantes']); ?><br>
                    <a href="procesar.php?download=1&id=<?php echo $reunion['id']; ?>">Añadir al Calendario</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay reuniones programadas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
