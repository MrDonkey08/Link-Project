<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../../index.php");
    exit();
}
require 'conecta.php';
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $integrantes = $_POST['integrantes']; 
    $asesorId = isset($_POST['asesor']) ? $_POST['asesor'] : null; // ID del asesor

    $con = conecta(); // Conexión a la base de datos

    // Insertar en la tabla de reuniones
    $query = "INSERT INTO reunion (titulo, fecha, hora) VALUES ($1, $2, $3) RETURNING id";
    $result = pg_query_params($con, $query, array($title, $date, $time));

    if (!$result) {
        die("Error en la inserción de la reunión: " . pg_last_error($con));
    }

    $reunionId = pg_fetch_result($result, 0, 0); // Obtener el ID de la reunión recién creada

    // Insertar en la tabla de participantes de la reunión
    foreach ($integrantes as $integranteId) {
        $query = "INSERT INTO reunion_participante (id_reunion, id_integrante) VALUES ($1, $2)";
        $result = pg_query_params($con, $query, array($reunionId, $integranteId));

        if (!$result) {
            die("Error en la inserción del integrante: " . pg_last_error($con));
        }
    }

    // Si se seleccionó un asesor, insertarlo en la tabla correspondiente
    if ($asesorId) {
        $query = "INSERT INTO reunion_participante (id_reunion, id_asesor) VALUES ($1, $2)";
        $result = pg_query_params($con, $query, array($reunionId, $asesorId));

        if (!$result) {
            die("Error en la inserción del asesor: " . pg_last_error($con));
        }
    }

    // Redirigir después de la inserción
    header('Location: ../../pages/agenda_reuniones.php');
    exit();
}
if (isset($_GET['download']) && $_GET['download'] == 1 && isset($_GET['id'])) {
    $reunionId = $_GET['id'];

    // Aquí deberías obtener los detalles de la reunión usando el ID
    $query = "SELECT * FROM reunion WHERE id = $1";
    $result = pg_query_params($con, $query, array($reunionId));

    if ($result && pg_num_rows($result) > 0) {
        $reunion = pg_fetch_assoc($result);

        // Generar el contenido del archivo .ics
        header('Content-Type: text/calendar');
        header('Content-Disposition: attachment; filename="reunion.ics"');

        $icsContent = "BEGIN:VCALENDAR\n";
        $icsContent .= "VERSION:2.0\n";
        $icsContent .= "BEGIN:VEVENT\n";
        $icsContent .= "SUMMARY:" . htmlspecialchars($reunion['titulo']) . "\n";
        $icsContent .= "DTSTART:" . formatDateToICS($reunion['fecha'], $reunion['hora']) . "\n";
        $icsContent .= "DTEND:" . formatDateToICS($reunion['fecha'], $reunion['hora'], true) . "\n";
        $icsContent .= "END:VEVENT\n";
        $icsContent .= "END:VCALENDAR";

        echo $icsContent;
        exit();
    } else {
        echo "Reunión no encontrada.";
    }
}
?>
