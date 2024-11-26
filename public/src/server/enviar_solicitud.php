<?php
require 'conecta.php';
session_start();

$con = conecta();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proyecto = $_POST['id_proyecto'] ?? null;
    $id_lider = $_POST['id_lider'] ?? null;
    $id_usuario = $_SESSION['IDUser'] ?? null;

    if ($id_proyecto && $id_lider && $id_usuario) {
        // Insertar en la tabla de solicitudes
        $query_solicitud = "INSERT INTO solicitudes (id_proyecto, id_solicitante, id_lider, estado) VALUES ($1, $2, $3, 'pendiente')";
        $result_solicitud = pg_query_params($con, $query_solicitud, [$id_proyecto, $id_usuario, $id_lider]);

        if ($result_solicitud) {
            echo "Solicitud enviada con éxito. El líder ha sido notificado.";
        } else {
            echo "Error al enviar la solicitud.";
        }
    } else {
        echo "Datos incompletos.";
    }
} else {
    echo "Método no permitido.";
}
