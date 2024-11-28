<?php
/**
 * Archivo para la actualización de la información del usuario
 *
 * @category Registro
 */
require_once 'conecta.php';
session_start();
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}
$con = conecta();

// Datos del formulario
$nombre           = $_POST["nombre"];
$apellido_paterno = $_POST["apellido-paterno"];
$apellido_materno = $_POST["apellido-materno"];
$contacto         = $_POST["contacto"];
$id_usuario       = $_POST["id-usuario"];
$tipo_de_usuario  = $_POST["tipo-de-usuario"];

echo $nombre, $apellido_paterno, $apellido_materno, $contacto, $id_usuario, $tipo_de_usuario;

// Validación básica
if (empty($id_usuario)) {
    echo "Error: ID de usuario no puede estar vacío.";
    exit;
}

// Actualización de datos del usuario
$query = "UPDATE usuario
    SET nombres = $1, apellido_pat = $2, apellido_mat = $3, num_tel = $4
    WHERE id_usuario = $5";

$result = pg_query_params(
    $con,
    $query,
    [
        $nombre,
        $apellido_paterno,
        $apellido_materno,
        $contacto,
        $id_usuario,
    ]
);

if ($result) {
    echo "Información de usuario actualizada con éxito.\n";
} else {
    echo "Error al actualizar información del usuario.\n";
}

// Actualización de contraseña
$password   = $_POST["password"];
$password_2 = $_POST["password-2"];

if (!empty($password)) {
    if ($password === $password_2) {
        // Obtener la contraseña actual del usuario
        $query = "SELECT clave FROM usuario WHERE id_usuario = $1";
        $result = pg_query_params($con, $query, [$id_usuario]);
        $row = pg_fetch_assoc($result);
        $current_password = $row['clave'];

        // Comparar la contraseña actual con la nueva
        if ($current_password !== $password) {
            $query = "UPDATE usuario
                SET clave = $1
                WHERE id_usuario = $2";

            $result = pg_query_params($con, $query, [$password, $id_usuario]);

            if ($result) {
                echo "Contraseña actualizada con éxito.\n";
            } else {
                echo "Error al actualizar la contraseña.\n";
            }
        } else {
            echo "La nueva contraseña no puede ser igual a la actual.\n";
        }
    } else {
        echo "Las contraseñas no coinciden. Inténtalo de nuevo.\n";
    }
}

// Actualización de datos específicos según tipo de usuario
if ($tipo_de_usuario === "estudiante") {
    $codigo      = $_POST["codigo-estudiante"];
    $carrera     = $_POST["carrera"];
    $habilidades = $_POST["habilidades"];

    $query = "UPDATE estudiante
        SET codigo_escolar = $1, carrera = $2, habilidades = $3
        WHERE id_usuario = $4";

    $result = pg_query_params($con, $query, [$codigo, $carrera, $habilidades, $id_usuario]);

    if ($result) {
        header("Location: ../../pages/perfil_usuario.php?id=" . $_SESSION['IDUser']);
        exit();
    } else {
        echo "Error al actualizar estudiante.\n";
    }

} elseif ($tipo_de_usuario === "asesor") {
    $codigo       = $_POST["codigo-asesor"];
    $departamento = $_POST["departamento"];

    $query = "UPDATE asesor
        SET codigo = $1, departamento = $2
        WHERE id_usuario = $3";

    $result = pg_query_params($con, $query, [$codigo, $departamento, $id_usuario]);

    if ($result) {
        header("Location: ../../pages/perfil_usuario.php?id=" . $_SESSION['IDUser']);
        exit();
    } else {
        echo "Error al actualizar asesor.\n";
    }
}

// Cerrar conexión
pg_close($con);
?>