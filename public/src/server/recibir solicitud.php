<?php
require 'conecta.php';
session_start();

$con = conecta();


$query_solicitud = "INSERT INTO solicitudes (id_proyecto, id_solicitante, id_lider, estado) VALUES ($1, $2, $3, 'pendiente')";
$result_solicitud = pg_query_params($con, $query_solicitud, [$id_proyecto, $id_usuario, $id_lider]);

// Verificar si la solicitud se insertó correctamente
if ($result_solicitud) {
    // Notificar al líder
    // Puedes insertar una notificación en una tabla de notificaciones
    $query_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado, fecha) VALUES ($1, $2, 'pendiente', CURRENT_TIMESTAMP)";
    $mensaje = "Tienes una nueva solicitud de proyecto de un estudiante.";
    $result_notificacion = pg_query_params($con, $query_notificacion, [$id_lider, $mensaje]);

    if ($result_notificacion) {
        echo "Solicitud enviada con éxito. El líder ha sido notificado.";
    } else {
        echo "Error al enviar la notificación al líder.";
    }
} else {
    echo "Error al enviar la solicitud.";
}
?>