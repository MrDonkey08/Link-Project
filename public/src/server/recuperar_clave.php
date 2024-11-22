<?php
/**
 * Archivo para el registro de cuentas de estudiantes
 *
 * @category Recuperacion
 * @author   MrDonkey08
 */

require_once 'conecta.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/Exception.php'; 
require '../../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$con = conecta();

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

function enviarCorreo($correo, $token)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración para el envio del correo
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Se cambia en el video del kike
        $mail->SMTPAuth = true;
        $mail->Username = 'juanendiaz07@gmail.com'; // Cambiar por el correo que pusieron
        $mail->Password = 'ppvjltfkchksxpvn';       // Contraseña de la aplicacion para que charche
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('juanendiaz07@gmail.com', 'Link-project'); // Remitente
        $mail->addAddress($correo); // Destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Token de recuperación';
        $mail->Body = "
            <h1>Link-project</h1>
            <p>Hola, este es tu token para restablecer tu password:</p>
            <h2>$token</h2>
            <p>Por favor, usa este token para completar el proceso en la página.</p>
        ";

        $mail->send();
        echo "Correo enviado exitosamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}

function generarToken($con, $correo)
{
    $usuario_registrado = verificarCorreo($con, $correo);

    if (!$usuario_registrado) {
        echo "Error: Usuario no encontrado";
        return false;
    }

    $id_usuario = $usuario_registrado->id_usuario;
    $token = bin2hex(random_bytes(3)); // Genera un token de 6 caracteres

    $query = "UPDATE usuario" .
        " SET token = $1" .
        " WHERE id_usuario = $2 AND activo = True";

    if (pg_query_params($con, $query, [$token, $id_usuario])) {
        enviarCorreo($correo, $token); // Llama a la función para enviar el correo
    } else {
        echo "Error al generar el token.";
    }
}

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

    if (pg_query_params($con, $query, [$pass_1, $token])) {
        echo "Contraseña reestablecida con éxito";
    }
}

desconecta($con);
?>
