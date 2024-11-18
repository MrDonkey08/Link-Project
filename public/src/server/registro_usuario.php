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
$email             = $_POST["email"];
$password          = $_POST["password"];
$password_2        = $_POST["password-2"];
$tipo_de_usuario   = $_POST["tipo-de-usuario"];

if ($password != $password_2) {
    echo "Las contraseñas no coinciden. Inténtalo de nuevo";
    return;
}

$result = null;

if ($tipo_de_usuario === "1") {
    $codigo  = $_POST["codigo-estudiante"];
    $carrera = $_POST["carrera"];

    $query = "INSERT INTO estudiante  (
        nombres,
        apellido_pat,
        apellido_mat,
        num_tel,
        correo,
        clave,
        carrera,
        codigo_escolar
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8
    )";

    // Ejecuta la consulta con los valores de las variables del formulario
    $result = pg_query_params(
        $con,
        $query,
        [
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $contacto,
            $email,
            $password,
            $codigo,
            $carrera
        ]
    );
} else {
    $codigo       = $_POST["codigo-asesor"];
    $departamento = $_POST["departamento"];

    $query = "INSERT INTO asesor  (
        nombres,
        apellido_pat,
        apellido_mat,
        num_tel,
        correo,
        clave,
        codigo_escolar,
        departamento
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8
    )";

    // Ejecuta la consulta con los valores de las variables del formulario
    $result = pg_query_params(
        $con,
        $query,
        [
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $contacto,
            $email,
            $password,
            $codigo,
            $departamento,
        ]
    );
}

if ($result) {
    echo "Registro exitoso";
} else {
    echo "Error en el registro: " . pg_last_error($con);
}
