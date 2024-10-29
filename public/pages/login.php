<?php
include '../dist/back-end/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/styles/login.css" />
  </head>
  <body>
    <div class="login-container">
      <h2>Iniciar Sesión</h2>
      <form>
        <div class="input-box">
          <input type="email" id="email-input" name="email" required />
          <label for="email-input">Correo Electrónico</label>
        </div>
        <div class="input-box">
          <label for="password-input">Contraseña</label>
          <input type="password" id="password-input" name="password" required />
        </div>
        <button type="submit">Ingresar</button>
      </form>
    </div>
  </body>
</html>
