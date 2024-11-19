<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "ID no válido";
  exit;
}
$idUsuario = $_GET['id'];
$con = conecta();
// <<-------------- Prepara la consulta para evitar inyección SQL ------------------->> no creo que nos quieran inyectar SQL pero aja
$sql = "SELECT * FROM usuario WHERE id_usuario = $1";

// <<-------------- Prepara la consulta usando pg_prepare
$result = pg_prepare($con, "query_select_user", $sql);

if ($result) {
    // Ejecuta la consulta 
    $res = pg_execute($con, "query_select_user", array($idUsuario));

    if ($res) {
        // Verificar si se obtuvieron resultados
        if (pg_num_rows($res) > 0) {
            $row = pg_fetch_assoc($res);  

            // Recibir las variables
            $nombre       = $row["nombres"];
            $apellidos    = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
            $correo       = $row["correo"];
            $telefono     = $row["num_tel"];
            $codigo       = $row["codigo_escolar"]; 
            $foto         = $row["foto"];  

            /* << !!--------------------Consulta para leer los datos
            echo "Nombre: " . $nombre . "<br />";
            echo "Apellidos: " . $apellidos . "<br />";
            echo "Correo: " . $correo . "<br />";
            echo "Telefono: " . $telefono . "<br />";
            echo "foto: " . $foto . "<br />";
            */

        } else {
            echo "No se encontró ningún usuario con el ID: $id";
        }
    } else {
        echo "Error al ejecutar la consulta: " . pg_last_error($con);
    }

} else {
    echo "Error al preparar la consulta: " . pg_last_error($con);
}
// Cerrar la conexión con la BD
pg_close($con); 
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
      <!-- ------------------------------------------------------------------------- Contenido de la pagina -->
      <div class="Contenido">
            <div class="contenedor">
                <div class="Header">
                    <div class="avatar"><?php echo $foto; ?></div>
                    <h1><?php echo $nombre . ' ' . $apellidos; ?></h1>
                </div>
                
                <div class="contact-info">
                    
                    <p>📞 <?php echo $telefono; ?> </p>
                    <!-- <p> <?php echo $carrera; ?></p>  Aqui va la carrera-->
                </div>
                
                <div class="section-title">Proyecto</div>
                
                <div class="pr-item">
                  <!------------------------------------------- Logica para saber si esta en proyecto o no ---------------------->
                    <img src="'icono_pr.png'" alt="Pr Icon">
                    <div>
                        <!--<strong><?php echo $nombrePr; ?></strong><br> Aqui necesitamos el nombre del proyecto en el que esta activo -->
                        <!--<span></span> Informacion acerca del proyecto --->
                    </div>
                </div>

                <div class="section-title">Habilidades</div>
                

            </div>
        </div>

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
