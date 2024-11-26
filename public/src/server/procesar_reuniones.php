<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../../index.php");
    exit();
}
require 'conecta.php';
// Obtiene el ID que se envia desde el icono de "user"
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID no válido";
    exit;
}
$idUsuario = $_GET['id'];
$con = conecta();

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insertar una nueva reunión
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $participants = $_POST['participants'];

    $stmt = $pdo->prepare("INSERT INTO reuniones (titulo, fecha, hora, participantes) VALUES (:titulo, :fecha, :hora, :participantes)");
    $stmt->execute([
        ':titulo' => $title,
        ':fecha' => $date,
        ':hora' => $time,
        ':participantes' => $participants,
    ]);

    header('Location: index.php');
    exit();
}

if (isset($_GET['download']) && isset($_GET['id'])) {
    // Generar archivo .ics para una reunión específica
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM reuniones WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $reunion = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reunion) {
        header('Content-Type: text/calendar');
        header('Content-Disposition: attachment; filename="reunion.ics"');

        $icsContent = "BEGIN:VCALENDAR
        VERSION:2.0
        CALSCALE:GREGORIAN
        BEGIN:VEVENT
        SUMMARY:" . $reunion['titulo'] . "
        DTSTART:" . formatDateToICS($reunion['fecha'], $reunion['hora']) . "
        DTEND:" . formatDateToICS($reunion['fecha'], $reunion['hora'], true) . "
        END:VEVENT
        END:VCALENDAR";

        echo $icsContent;
    }
    exit();
}

function formatDateToICS($date, $time, $isEnd = false) {
    $datetime = new DateTime("$date $time");
    if ($isEnd) {
        $datetime->modify('+1 hour');
    }
    return $datetime->format('Ymd\THis\Z');
}
?>
