<?php
require 'conecta.php';
session_start();

$con = conecta();

// Verificamos si el método de la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperamos los datos enviados
    $id_proyecto = $_POST['id_proyecto'] ?? null;
    $id_lider = $_POST['id_lider'] ?? null;
    $id_usuario = $_SESSION['IDUser'] ?? null;

    // Validamos que las variables necesarias no estén vacías
    if ($id_proyecto && $id_lider && $id_usuario) {
        // Insertar en la tabla de solicitudes
        $query_solicitud = "INSERT INTO solicitudes (id_proyecto, id_solicitante, id_lider, estado) VALUES ($1, $2, $3, 'pendiente')";
        $result_solicitud = pg_query_params($con, $query_solicitud, [$id_proyecto, $id_usuario, $id_lider]);

        if ($result_solicitud) {
            // Si la solicitud fue exitosa, notificar al líder
            $mensaje = "Tienes una nueva solicitud de proyecto de un estudiante.";
            $query_notificacion = "INSERT INTO notificaciones (id_usuario, mensaje, estado, fecha) VALUES ($1, $2, 'pendiente', CURRENT_TIMESTAMP)";
            $result_notificacion = pg_query_params($con, $query_notificacion, [$id_lider, $mensaje]);

            if ($result_notificacion) {
                echo "Solicitud enviada con éxito. El líder ha sido notificado.";
            } else {
                echo "Error al enviar la notificación al líder.";
            }
        } else {
            echo "Error al enviar la solicitud.";
        }
    } else {
        echo "Datos incompletos. Asegúrate de que el proyecto, el líder y el usuario estén definidos.";
    }
} else {
    echo "Método no permitido. Solo se permite POST.";
}
?>
