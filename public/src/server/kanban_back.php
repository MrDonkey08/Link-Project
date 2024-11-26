<?php
require 'conecta.php';
$con = conecta();

// Obtener la entrada JSON del cliente
$data = json_decode(file_get_contents("php://input"), true);

// Si no hay datos JSON, devuelve un error
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No se recibieron datos válidos']);
    exit();
}

// Obtener la acción del cliente
$action = $data['action'];

switch ($action) {
    case 'add':
        $descripcion = $data['descripcion'];
        $fase = $data['fase'];
        $id_proyecto = $data['id_proyecto'];

        // Validar que la fase esté en el rango permitido (1, 2, 3)
        if (!in_array($fase, [1, 2, 3])) {
            echo json_encode(['success' => false, 'error' => 'Fase inválida']);
            exit();
        }

        // SQL para agregar tarea
        $sql = "INSERT INTO tarea (descripcion, fase, id_proyecto) VALUES ($1, $2, $3) RETURNING id";
        $res = pg_query_params($con, $sql, array($descripcion, $fase, $id_proyecto));

        if ($res) {
            $row = pg_fetch_assoc($res);
            echo json_encode(['success' => true, 'id' => $row['id']]);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($con)]);
        }
        break;

    case 'update':
        $id = $data['id'];
        $fase = $data['fase'];

        // Validar que la fase esté en el rango permitido (1, 2, 3)
        if (!in_array($fase, [1, 2, 3])) {
            echo json_encode(['success' => false, 'error' => 'Fase inválida']);
            exit();
        }

        // SQL para actualizar la fase de la tarea
        $sql = "UPDATE tarea SET fase = $1 WHERE id = $2";
        $res = pg_query_params($con, $sql, array($fase, $id));

        echo json_encode(['success' => $res ? true : false]);
        break;

    case 'delete':
        $id = $data['id'];

        // SQL para eliminar la tarea
        $sql = "DELETE FROM tarea WHERE id = $1";
        $res = pg_query_params($con, $sql, array($id));

        echo json_encode(['success' => $res ? true : false]);
        break;

    case 'fetch':
        $id_proyecto = $data['id_proyecto'];

        // SQL para obtener las tareas del proyecto
        $sql = "SELECT id, descripcion, fase FROM tarea WHERE id_proyecto = $1";
        $res = pg_query_params($con, $sql, array($id_proyecto));

        $tasks = [];
        while ($row = pg_fetch_assoc($res)) {
            $tasks[] = $row;
        }

        echo json_encode($tasks);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción no reconocida']);
}
?>
