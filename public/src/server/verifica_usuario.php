<?php
session_start();
require "conecta.php";
require "../../phpmailer/src/PHPMailer.php";
require "../../phpmailer/src/SMTP.php";

$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];
$pass = $_REQUEST['Pass'];

// Verifica credenciales
$sql = "SELECT * FROM usuario WHERE correo = $1 AND clave = $2 AND activo = TRUE";
$res = pg_query_params($con, $sql, array($correo, $pass));

if ($res && pg_num_rows($res) == 1) {
    $row = pg_fetch_array($res);

    // Genera token y lo guarda en sesión
    $token = rand(100000, 999999);
    $_SESSION['token'] = $token;
    $_SESSION['CorreoUser'] = $correo;

    // Envía el token por correo
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juanendiaz07@gmail.com';
        $mail->Password = 'ppvjltfkchksxpvn';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('juanendiaz07@gmail.com', 'Sistema');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Código de Verificacion';
        $mail->Body = "Tu código de verificacion es: <b>$token</b>";

        $mail->send();
        echo "2"; // Indica éxito en el envío del token
    } catch (Exception $e) {
        echo "Error al enviar el token: {$mail->ErrorInfo}";
    }
} else {
    echo "1"; // Usuario o contraseña incorrectos
}
?>
