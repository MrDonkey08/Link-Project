<?php
session_start();

require '../src/server/conecta.php';
$con = conecta();
$idUsuario = $_SESSION['IDUser'];
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mi perfil de Link-Proyect</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/perfil_usuario.css" />
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
            <a href="perfil_usuario.php?id=<?php echo $idUsuario; ?>">
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
      <!-- ------------------------------------------------------------------------- Contenido de la pagina -->

      <!-- -------------------------------------- Encabezado final de pagina -->
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