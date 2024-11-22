<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/recuperar_clave.css" />
  </head>
  <body>
    <div class="container">
      <h1>Recuperar Contraseña</h1>
      <form method="POST" action="../src/server/recuperar_clave.php">
        <input
          type="email"
          id="email-input"
          name="email"
          placeholder="Introduce tu correo"
          required
        />
        <button type="submit" name="submit" value="generarToken">
          Enviar Código
        </button>
      </form>
      <form
        class="hidden"
        method="POST"
        action="../src/server/recuperar_clave.php"
      >
        <input
          type="text"
          id="token-text-input"
          name="token"
          placeholder="Introduce el código"
          maxlength="6"
          required
        />
        <input
          type="password"
          id="password-input"
          name="password"
          placeholder="Nueva Contraseña"
          required
        />
        <input
          type="password"
          id="password-2-input"
          name="password-2"
          placeholder="Confirmar Contraseña"
          required
        />
        <button type="submit" name="submit" value="restablecerClave">
          Actualizar Contraseña
        </button>
      </form>
    </div>
  </body>
</html>
