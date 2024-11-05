<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/styles/login.css" />
    <script src="../src/server/jquery-3.3.1.min.js"></script>
    <script>
      // Funcion para validar y enviar datos
      function ValidarDatos() {
        var Correo = $('[name="Correo"]').val().trim()
        var Pass = $('[name="Pass"]').val().trim()

        if (Correo === "" || Pass === "") {
          //alert("¡Felicidadades! Todos los campos estan llenos");
          $("#mensaje").html("Faltan campos por llenar")
          setTimeout("$('#mensaje').html('')", 5000)
        } else {
          // Realizar la solicitud AJAX
          $.ajax({
            type: "POST",
            url: "../src/server/login.php",
            dataType: "text",
            data: { Correo: Correo, Pass: Pass },
            success: function (res) {
              console.log("Correo: ", Correo)
              if (res === "1") {
                window.location.replace("perfil_usuario.php")
              } else {
                $("#mensaje").html("El usuario o la contraseña son incorrectos")
                console.log("Respuesta:", res)
                setTimeout(function () {
                  $("#mensaje").html("")
                }, 5000)
              }
            },
            error: function () {
              $("#mensaje").html("Error en la solicitud AJAX.")
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
      <!-- ------------------------------------ Encabezado de pagina Inicial -->
      <header>
        <div class="Logo">
          <a href="???"> Logotipo</a>
        </div>
        <div class="Central"></div>
        <div class="TablaNav">
          <div class="OpNav">
            <a href="???">
              <img
                class="icono"
                src="../assets/pictures/chat_icon-icons.com_67748.png"
              />
            </a>
          </div>
          <div class="OpNav">
            <a href="???">
              <img
                class="icono"
                src="../assets/pictures/notifications_icon_124898.png"
              />
            </a>
          </div>
          <div class="OpNav">
            <a href="???">
              <img
                class="icono"
                src="../assets/pictures/profile_icon_183860.png"
              />
            </a>
          </div>
          <div class="OpNav">
            <a href="???"><img class="icono" src="Por si las dudas" /></a>
          </div>
        </div>
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
                ¿No tienes cuenta? <a href="eleccionusuario.php">Regístrate</a>
              </p>
            </div>
            <button
              type="submit"
              value="Salvar"
              onclick=" ValidarDatos(); return false;"
            >
              Ingresar
            </button>
          </form>
        </div>
      </div>
      <footer>
        Todos los derechos reservados 2024 | terminos y condiciones | <br />
        | Política de privacidad | Redes sociales | <br />
        <a href="#"
          ><img class="iconos" src="Diseños/imagenes-Diseño/Correo.png"
        /></a>
        <a href="#"
          ><img class="iconos" src="Diseños/imagenes-Diseño/Facebook.png"
        /></a>
        <a href="#"
          ><img class="iconos" src="Diseños/imagenes-Diseño/Insta.png"
        /></a>
        <a href="#"
          ><img class="iconos" src="Diseños/imagenes-Diseño/X.png"
        /></a>
      </footer>
    </div>
  </body>
</html>
