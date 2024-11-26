<?php
require 'conecta.php';
session_start();

// Asegurémonos de que las variables estén correctamente definidas
$id_proyecto = isset($_POST['id_proyecto']) ? $_POST['id_proyecto'] : null; // Valor recibido del formulario
$id_usuario = isset($_SESSION['IDUser']) ? $_SESSION['IDUser'] : null; // Valor de la sesión
$id_lider = isset($_POST['id_lider']) ? $_POST['id_lider'] : null; // Valor recibido del formulario

// Verificamos que todas las variables necesarias estén definidas
if ($id_proyecto && $id_usuario && $id_lider) {
    // Conectamos a la base de datos
    $con = conecta();

    // Inserción en la tabla solicitudes
    $query_solicitud = "INSERT INTO solicitudes (id_proyecto, id_solicitante, id_lider, estado) VALUES ($1, $2, $3, 'pendiente')";
    $result_solicitud = pg_query_params($con, $query_solicitud, [$id_proyecto, $id_usuario, $id_lider]);

    if ($result_solicitud) {
        // Inserción en la tabla de notificaciones
        $query_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado, fecha) VALUES ($1, $2, 'pendiente', CURRENT_TIMESTAMP)";
        $mensaje = "Tienes una nueva solicitud de proyecto de un estudiante.";
        $result_notificacion = pg_query_params($con, $query_notificacion, [$id_lider, $mensaje]);

        if ($result_notificacion) {
            $mensaje_exito = "Solicitud enviada con éxito. El líder ha sido notificado.";
        } else {
            $mensaje_error = "Error al enviar la notificación al líder.";
        }
    } else {
        $mensaje_error = "Error al enviar la solicitud.";
    }
} else {
    $mensaje_error = "Faltan datos necesarios para enviar la solicitud.";
}

// Mostrar la interfaz, con los mensajes adecuados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="../assets/styles/notificaciones.css">
</head>
<body>
    <header>
        <h1>Notificaciones</h1>
        <p>Solicitudes de proyectos</p>
    </header>

    <div class="notifications-container">
        <?php if (isset($mensaje_exito)): ?>
            <div class="success-message">
                <?php echo $mensaje_exito; ?>
            </div>
        <?php elseif (isset($mensaje_error)): ?>
            <div class="error-message">
                <?php echo $mensaje_error; ?>
            </div>
        <?php endif; ?>

        <!-- Aquí puedes continuar con la interfaz de notificaciones -->
        <!-- Ejemplo de una notificación, dependiendo de tu implementación -->
        <div class="notification-card">
            <h3>Solicitud de proyecto pendiente</h3>
            <p>Haz clic en aceptar o rechazar para procesar la solicitud.</p>
            <div class="actions">
                <button class="accept-btn">Aceptar</button>
                <button class="reject-btn">Rechazar</button>
            </div>
        </div>

    </div>
</body>
</html>
