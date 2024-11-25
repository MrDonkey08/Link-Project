<?php
/**
 * Archivo para el registro de cuentas de estudiantes
 *
 * @category Registro
 */

require_once 'conecta.php';
session_start();
$con = conecta();

// Datos del formulario
$file_name  = $_FILES["foto"]["tmp_name"];
$id_usuario = $_POST["id-usuario"];

$es_data = "";

// Formateamos la imagen para que pueda ser almacenada en PostgreSQL (bytea)
if (isset($file_name)) {
    $img = fopen($file_name, 'r') or die("No se puede leer la imagen");
    $data = fread($img, filesize($file_name));

    $es_data = pg_escape_bytea($data);
    fclose($img);
}

$result = null;

$query = "UPDATE usuario
        SET foto = $1
WHERE id_usuario = $2";

$result = pg_query_params($con, $query, [$es_data, $id_usuario]);

// cierren la conexion con la BD porque se sigue ejecutando codigo
pg_close($con);
// cierren el codigo, porque no manda respuestas
