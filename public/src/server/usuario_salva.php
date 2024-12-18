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
$file_name         = $_FILES["image"]["tmp_name"];
$tipo_de_usuario   = $_POST["tipo-de-usuario"];

// Validación de contraseñas
if ($password !== $password_2) {
    echo "Las contraseñas no coinciden. Inténtalo de nuevo.";
    return;
}

// Validar correo
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Correo inválido. Inténtalo de nuevo.";
    return;
}

// Se encriptan las contraseñas
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$es_data = "";

// Formateamos la imagen para que pueda ser almacenada en PostgreSQL (bytea)
if (isset($file_name)) {
    $img = fopen($file_name, 'r') or die("No se puede leer la imagen");
    $data = fread($img, filesize($file_name));

    $es_data = pg_escape_bytea($data);
    fclose($img);
}

$result = null;

if ($tipo_de_usuario === "1") {
    // Registro de estudiante
    $codigo  = $_POST["codigo-estudiante"];
    $carrera = $_POST["carrera"];

    $query = "INSERT INTO estudiante (
        nombres,
        apellido_pat,
        apellido_mat,
        num_tel,
        correo,
        clave,
        codigo_escolar,
        carrera,
        foto
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9
    )";

    $result = pg_query_params(
        $con,
        $query,
        [
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $contacto,
            $email,
            $hashed_password,
            $codigo,
            $carrera,
            $es_data
        ]
    );
} else {
    // Registro de asesor
    $codigo       = $_POST["codigo-asesor"];
    $departamento = $_POST["departamento"];

    $query = "INSERT INTO asesor (
        nombres,
        apellido_pat,
        apellido_mat,
        num_tel,
        correo,
        clave,
        codigo_escolar,
        departamento,
        foto
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9
    )";

    $result = pg_query_params(
        $con,
        $query,
        [
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $contacto,
            $email,
            $hashed_password,
            $codigo,
            $departamento,
            $es_data
        ]
    );
}

if ($result) {
    // <<------    Redirigimos a inicio
    header("Location: ../../pages/inicio.php");
    // cierren la conexion con la BD porque se sigue ejecutando codigo
    exit;
} else {
    error_log("Error en el registro: " . pg_last_error($con));
    echo "Ocurrió un error durante el registro. Por favor, intenta de nuevo.";
}
// cierren la conexion con la BD porque se sigue ejecutando codigo
pg_close($con);
// cierren el codigo, porque no manda respuestas
