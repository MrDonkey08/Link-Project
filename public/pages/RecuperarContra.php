<?php
session_start();

// Inicializar variables de sesión
if (!isset($_SESSION['verification_code'])) $_SESSION['verification_code'] = "";
if (!isset($_SESSION['email'])) $_SESSION['email'] = "";
if (!isset($_SESSION['verified'])) $_SESSION['verified'] = false;

// Enviar código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_code'])) {
    $email = $_POST['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['verification_code'] = rand(1000, 9999); // Generar código aleatorio de 4 dígitos
        $_SESSION['email'] = $email;

        // Simula el envío del correo
        echo "<script>alert('Código enviado a $email: {$_SESSION['verification_code']}');</script>";
    } else {
        echo "<script>alert('Correo electrónico inválido.');</script>";
    }
}

// Verificar código
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $userCode = $_POST['code'];

    if ($userCode == $_SESSION['verification_code']) {
        $_SESSION['verified'] = true;
        echo "<script>alert('Código verificado correctamente.');</script>";
    } else {
        echo "<script>alert('El código es incorrecto.');</script>";
    }
}

// Actualizar contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword && $confirmPassword && $newPassword === $confirmPassword) {
        // Aquí puedes agregar la lógica para actualizar la contraseña en la base de datos
        echo "<script>alert('Contraseña actualizada con éxito.');</script>";
        session_destroy(); // Limpia la sesión para reiniciar el flujo
        echo "<script>window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Las contraseñas no coinciden o están vacías.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Recuperar Contraseña</h1>
    <form method="POST" action="">
        <!-- Sección de email -->
        <?php if (!$_SESSION['verification_code'] && !$_SESSION['verified']): ?>
            <input type="email" name="email" placeholder="Introduce tu correo" required>
            <button type="submit" name="send_code">Enviar Código</button>
        <?php endif; ?>

        <!-- Sección de código -->
        <?php if ($_SESSION['verification_code'] && !$_SESSION['verified']): ?>
            <input type="text" name="code" placeholder="Introduce el código" maxlength="4" required>
            <button type="submit" name="verify_code">Verificar Código</button>
        <?php endif; ?>

        <!-- Sección de actualización de contraseña -->
        <?php if ($_SESSION['verified']): ?>
            <input type="password" name="new_password" placeholder="Nueva Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            <button type="submit" name="update_password">Actualizar Contraseña</button>
        <?php endif; ?>
    </form>
</body>
</html>
