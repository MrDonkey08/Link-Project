<?php
/**
 * Archivo para el registro de cuentas de estudiantes
 *
 * @category Recuperacion
 * @author   MrDonkey08 <alan.juarez5178@alumnos.udg.mx>
 *
 * TODO: Sustituir `echo`s por `alert`s u otra alternativa mejor
 */

require_once 'conecta.php';
session_start();
$con = conecta();

// Check which form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'generarToken':
            generarToken($con, $_POST["email"]);
            break;
        case 'restablecerClave':
            restablecerClave(
                $con,
                $_POST["token"],
                $_POST["password"],
                $_POST["password-2"]
            );
            break;
        default:
            echo "Acción Inválida";
    }
}

/**
 * Verifica que el correo le pertenece a algun usuario
 *
 * @param object $con    Conexión a la BD
 * @param string $correo Correo ingresado por el usuario
 *
 * @return object|null Objeto del usuario si existe, null si no
 */
function verificarCorreo($con, $correo)
{
    $query = "SELECT id_usuario, correo, token" .
        " FROM usuario" .
        " WHERE correo = $1 AND activo = True" .
        " LIMIT 1";

    $result = pg_query_params($con, $query, [$correo]);

    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_object($result);
    }

    return null;
}

/**
 * Genera un token y se le envia al correo ingresado
 *
 * @param object $con    Conexión a la BD
 * @param string $correo Correo ingresado por el usuario
 *
 * @return object|null Objeto del usuario si existe, null si no
 *
 * TODO: Enviar el correo al usuario
 */
function generarToken($con, $correo)
{
    $usuario_registrado = verificarCorreo($con, $correo);

    if (!$usuario_registrado) {
        echo "Error: Usuario no encontrado";
        return false;
    }

    $id_usuario = $usuario_registrado->id_usuario;

    $token = bin2hex(random_bytes(3));

    $query = "UPDATE usuario" .
        " SET token = $1" .
        " WHERE id_usuario = $2 AND activo = True";

    pg_query_params($con, $query, [$token, $id_usuario]);

    echo $token;

}

/**
 * Vefirifica que el token ingresado pertenezca a un usuario
 *
 * @param object $con   Conexión a la BD
 * @param string $token ingresado por el usuario
 *
 * @return void
 */
function verificarToken($con, $token)
{
    $query = "SELECT token" .
            " FROM usuario" .
            " WHERE token = $1 AND activo = True" .
            " LIMIT 1";

    $result = pg_query_params($con, $query, [$token]);

    if ($result && pg_num_rows($result) > 0) {
        $usuario = pg_fetch_object($result);
    }

    return ($token === $usuario->token);
}

/**
 * Valida que ambas contraseñas ingresadas sean iguales y si lo son, actualiza
 * la contraseña del usuario
 *
 * @param object $con    Conexión a la BD
 * @param string $token  ingresado por el usuario
 * @param string $pass_1 ingresado por el usuario
 * @param string $pass_2 ingresado por el usuario
 *
 * @return void
 */
function restablecerClave($con, $token, $pass_1, $pass_2)
{
    if (!verificarToken($con, $token)) {
        echo "Token inválido. Inténtalo de nuevo";
        return;
    }

    if ($pass_1 != $pass_2) {
        echo "Las contraseñas no coinciden. Inténtalo de nuevo";
        return;
    }

    $query = "UPDATE usuario" .
        " SET clave = $1" .
        " WHERE token = $2 AND activo = True";

    pg_query_params($con, $query, [$pass_1, $token]);

    echo "Contraseña reestablecida con éxito";
}

desconecta($con);
// TODO: Regresar a la página sin recargar, sin borrar los datos del formulario
//header("Location: ../../pages/RecuperarContra.html");
exit();
