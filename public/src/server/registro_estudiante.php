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
$nombre            = $_POST["nombre"];
$apellido_paterno  = $_POST["apellido-paterno"];
$apellido_materno  = $_POST["apellido-materno"];
$contacto          = $_POST["contacto"];
$codigo_estudiante = $_POST["codigo-estudiante"];
$carrera           = $_POST["carrera"];
$departamento      = $_POST["departamento"];
$email             = $_POST["email"];
$password          = $_POST["password"];

$query = "INSERT INTO estudiante (
    Nombre, Apellido_pat, Apellido_mat, correo_institucional, num_tel,
    codigo_estudiante, carrera, contraseña, estado, foto, habilidades
) VALUES (
    $1, $2, $3, $4, $5, $6, $7, $8, 'activo', NULL, NULL
)";

// Ejecuta la consulta con los valores de las variables del formulario
$result = pg_query_params(
    $con,
    $query,
    [
        $nombre,
        $apellido_paterno,
        $apellido_materno,
        $email,
        $contacto,
        $codigo_estudiante,
        $carrera,
        $password
    ]
);

if ($result) {
    echo "Registro exitoso";
} else {
    echo "Error en el registro: " . pg_last_error($con);
}
