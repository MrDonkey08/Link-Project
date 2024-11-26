<?php
require 'conecta.php';
session_start();

// Asegurémonos de que las variables estén correctamente definidas y no estén vacías
$id_solicitud = isset($_POST['id_solicitud']) ? $_POST['id_solicitud'] : null;
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$id_lider = isset($_SESSION['IDUser']) ? $_SESSION['IDUser'] : null;

// Verificamos que todas las variables necesarias estén definidas
if ($id_solicitud && $accion && $id_lider) {
    // Conectar a la base de datos
    $con = conecta();

    // Obtener la solicitud del líder
    $query_solicitud = "SELECT * FROM solicitudes WHERE id = $1 AND id_lider = $2";
    $result_solicitud = pg_query_params($con, $query_solicitud, [$id_solicitud, $id_lider]);
    
    if (pg_num_rows($result_solicitud) > 0) {
        $solicitud = pg_fetch_assoc($result_solicitud); // Cargamos la solicitud

        if ($accion === 'aceptar') {
            // Si la acción es aceptar, agregamos al estudiante a la tabla de 'integrantes'
            $id_proyecto = $solicitud['id_proyecto'];
            $id_estudiante = $solicitud['id_solicitante'];

            // Insertamos al estudiante en la tabla de integrantes
            $query_integrante = "INSERT INTO integrantes (id_proyecto, id_estudiante, lider) VALUES ($1, $2, FALSE)";
            $result_integrante = pg_query_params($con, $query_integrante, [$id_proyecto, $id_estudiante]);

            if ($result_integrante) {
                // Actualizamos el estado de la solicitud a 'aceptada'
                $query_actualizar = "UPDATE solicitudes SET estado = 'aceptada' WHERE id = $1";
                $result_actualizar = pg_query_params($con, $query_actualizar, [$id_solicitud]);

                if ($result_actualizar) {
                    // Mensaje de éxito con estilo
                    echo "<div class='mensaje-exito'>¡Éxito! El estudiante ha sido añadido al proyecto.</div>";
                } else {
                    echo "<div class='mensaje-error'>Hubo un problema al actualizar el estado de la solicitud.</div>";
                }
            } else {
                echo "<div class='mensaje-error'>No se pudo agregar al estudiante a la tabla de integrantes.</div>";
            }
        } elseif ($accion === 'rechazar') {
            // Si la acción es rechazar, eliminamos la solicitud de la base de datos
            $query_eliminar = "DELETE FROM solicitudes WHERE id = $1";
            $result_eliminar = pg_query_params($con, $query_eliminar, [$id_solicitud]);

            if ($result_eliminar) {
                // Mensaje indicando que la solicitud fue rechazada
                echo "<div class='mensaje-info'>La solicitud ha sido rechazada y eliminada exitosamente.</div>";
            } else {
                echo "<div class='mensaje-error'>Hubo un problema al eliminar la solicitud.</div>";
            }
        } else {
            echo "<div class='mensaje-error'>Acción no válida. Solo se puede aceptar o rechazar.</div>";
        }
    } else {
        echo "<div class='mensaje-error'>No se encontró la solicitud o no pertenece a este líder.</div>";
    }
} else {
    // Si faltan datos
    echo "<div class='mensaje-error'>Faltan datos necesarios para procesar la solicitud. Verifica la información enviada.</div>";
}
?>
