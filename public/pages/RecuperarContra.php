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
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/small_form.css" />
  </head>
  <body>
    <section class="container small-container">
      <h1>Recuperar Contraseña</h1>
      <form method="POST" action="../src/server/recuperar_clave.php">
        <div class="input-box">
          <input
            type="email"
            id="email-input"
            name="email"
            title="El correo debe ser institucional, perteneciente a la UDG"
            autocomplete="on"
            required
          />
          <label for="email-input">Correo Electrónico</label>
        </div>

        <button type="submit" name="submit" value="generarToken">
          Enviar Código
        </button>
      </form>
      <form method="POST" action="../src/server/recuperar_clave.php">
        <div class="input-box">
          <input
            type="text"
            id="token-input"
            name="token"
            maxlength="6"
            required
          /><label for="token-input">Código</label>
        </div>

        <div class="input-box">
          <input
            type="password"
            id="password-input"
            name="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
            title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
            required
          /><label for="password-input">Nueva Contraseña</label>
        </div>

        <div class="input-box">
          <input
            type="password"
            id="password-input-2"
            name="password-2"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
            title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
            required
          /><label for="password-input-2">Confirmar Contraseña</label>
        </div>

        <button type="submit" name="submit" value="restablecerClave">
          Actualizar Contraseña
        </button>
      </form>
    </section>
  </body>
</html>


