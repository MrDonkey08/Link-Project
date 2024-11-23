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
    <section class="container">
      <h1>Recuperar Contraseña</h1>
      <form method="POST" action="../src/server/recuperar_clave.php">
        <input
          type="email"
          id="email-input"
          name="email"
          placeholder="Introduce tu correo"
          pattern="\w[\w\.]{0,30}@(alumnos|academicos)\.udg\.mx"
          title="El correo debe ser institucional, perteneciente a la UDG"
          autocomplete="on"
          required
        />

        <button type="submit" name="submit" value="generarToken">
          Enviar Código
        </button>
      </form>
      <form method="POST" action="../src/server/recuperar_clave.php">
        <input
          type="text"
          id="token-input"
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
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
          title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
          required
        />

        <input
          type="password"
          id="password-input-2"
          name="password-2"
          placeholder="Confirmar Contraseña"
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
          title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
          required
        />

        <button type="submit" name="submit" value="restablecerClave">
          Actualizar Contraseña
        </button>
      </form>
    </section>
  </body>
</html>


