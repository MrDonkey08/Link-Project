<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Actualizar Información</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/actualizacion_perfil_usuario.css" /> 
    />
  </head>
  <body>
    <div class="update-container">
      <h2>Actualizar Información</h2>
      <form>
        <!-- Campo de nombre -->
        <div class="input-box">
          <input type="text" required />
          <label>Nombre</label>
        </div>

        <div class="input-box">
          <input type="text" required />
          <label>Apellido Paterno</label>
        </div>

        <div class="input-box">
          <input type="text" required />
          <label>Apellido Materno</label>
        </div>

        <div class="input-box">
          <input type="text" required />
          <label>Correo</label>
        </div>

        <div class="input-box">
          <input type="text" required />
          <label>Numero de contacto</label>
        </div>

        <!-- Campo de nueva contraseña -->
        <div class="input-box">
          <input type="password" required />
          <label>Nueva Contraseña</label>
        </div>

        <!-- Botón para actualizar -->
        <button type="submit">Actualizar</button>
      </form>
    </div>
  </body>
</html>
