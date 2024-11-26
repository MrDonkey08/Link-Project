<?php
session_start();
require 'src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/style.css" />
    <link rel="stylesheet" href="assets/styles/login.css" />
    <script src="src/server/jquery-3.3.1.min.js"></script>
    <script>
      // Función para validar y enviar datos
      function ValidarDatos() {
        var Correo = $('[name="correo"]').val().trim() // Corregido: debe ser 'correo'
        var Pass = $('[name="pass"]').val().trim() // Corregido: debe ser 'pass'

        if (Correo === "" || Pass === "") {
          //$("#mensaje").html("Faltan campos por llenar") se acompaña de un div, no es necesario aqui
          setTimeout(function () {
            //$("#mensaje").html("")
          }, 5000)
        } else {
          // Realizar la solicitud AJAX
          $.ajax({
            type: "POST",
            url: "src/server/verifica_usuario.php",
            dataType: "text",
            data: { Correo: Correo, Pass: Pass },
            success: function (res) {
              console.log("Correo: ", Correo)
              if (res === "1") {
                window.location.replace("pages/inicio.php")
              } else {
                //$("#mensaje").html("El usuario o la contraseña son incorrectos")
                console.log("Respuesta:", res)
                setTimeout(function () {
                //  $("#mensaje").html("")
                }, 5000)
              }
            },
            error: function () {
              //$("#mensaje").html("Error en la solicitud AJAX.") esto es con un div, pero no tenemos eso
              setTimeout(function () {
                $("#mensaje").html("")
              }, 5000)
            },
          })
        }
      }
    </script>
  </head>
  <body>
    <div class="wrapper">
      <!-- Encabezado de página Inicial -->
      <header>
      <h1>Link-Project</h1>
      </header>
      <div class="Contenido">
        <div class="login-container">
          <h2>Iniciar Sesión</h2>
          <form>
            <div class="input-box">
              <input type="text" id="email-input" name="correo" required />
              <label for="email-input">Correo Electrónico</label>
            </div>
            <div class="input-box">
              <input type="password" id="password-input" name="pass" required />
              <label for="password-input">Contraseña</label>
            </div>
            <div>
              <p>
                ¿No tienes cuenta?
                <a href="pages/registro_usuario.php">Regístrate</a>
              </p>
            </div>
            <div>
              <p>
                ¿Has olvidado tu contraseña?
                <a href="pages/recuperar_clave.php">Recuperar</a>
              </p>
            </div>
            <button
              type="submit"
              value="Salvar"
              onclick="ValidarDatos(); return false;"
            >
              Ingresar
            </button>
          </form>
          <div id="mensaje"></div>
          <!-- Agregamos un div para mostrar mensajes -->
        </div>
      </div>
    </div>
  </body>
</html>
