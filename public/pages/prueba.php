<?php
$to = "choliquito223@gmail.com"; // Cambia esto por tu correo electrónico
$subject = "Prueba de la función mail()";
$message = "¡La función mail() está funcionando correctamente!";
$headers = "From: no-reply@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Correo enviado con éxito.";
} else {
    echo "Error al enviar el correo.";
}
?>
