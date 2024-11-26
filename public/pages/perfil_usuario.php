<?php
session_start();
$Nombre = $_SESSION['NombreUser'];

if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';


if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}

$con = conecta();

//<<----------------------------------------------- Verifica si el ID pertenece a un estudiante
$sql_estudiante = "SELECT * FROM estudiante WHERE id_usuario = $1";
$result_estudiante = pg_prepare($con, "query_select_estudiante", $sql_estudiante);
$res_estudiante = pg_execute($con, "query_select_estudiante", array($id_usuario));

if ($res_estudiante && pg_num_rows($res_estudiante) > 0) {
    $row = pg_fetch_assoc($res_estudiante);
    // <<----- Se obtienen los datos de la tabla estudiante
    $id_estudiante = $row["id_estudiante"];
    $nombre        = $row["nombres"];
    $apellido_pat  = $row["apellido_pat"];
    $apellido_mat  = $row["apellido_mat"];
    $apellidos     = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
    $carrera       = $row["carrera"];
    $telefono      = $row["num_tel"];
    $correo        = $row["correo"];
    $codigo        = $row["codigo_escolar"];
    $foto          = $row["foto"];
    $habilidades   = $row["habilidades"];
    $tipo_usuario  = 'estudiante';
} else {
    //<<----------------------------------------------- Verifica si el ID pertenece a un asesor
    $sql_asesor = "SELECT * FROM asesor WHERE id_usuario = $1";
    $result_asesor = pg_prepare($con, "query_select_asesor", $sql_asesor);
    $res_asesor = pg_execute($con, "query_select_asesor", array($id_usuario));

    if ($res_asesor && pg_num_rows($res_asesor) > 0) {
        $row = pg_fetch_assoc($res_asesor);
        // <<----- Se obtienen los datos de la tabla asesor
        $id_asesor    = $row["id_asesor"];
        $nombre       = $row["nombres"];
        $apellido_pat = $row["apellido_pat"];
        $apellido_mat = $row["apellido_mat"];
        $apellidos    = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
        $departamento = $row["departamento"];
        $telefono     = $row["num_tel"];
        $correo       = $row["correo"];
        $codigo       = $row["codigo_escolar"];
        $foto         = $row["foto"];
        $tipo_usuario = 'asesor';
    } else {
        echo "No se encontró ningún estudiante o asesor con el ID: $id_usuario";
        exit();
    }
}

if (!empty($foto)) {
    // Decodificamos el bytea
    $unes_img = pg_unescape_bytea($foto);
    // Nombre del archivo donde se guardará la imagen (en la misma carpeta)
    $file_name = "profile.jpg";
    // Guardamos la imagen en un archivo
    $img = fopen($file_name, 'wb');// or die("No se pudo abrir la imagen");
    fwrite($img, $unes_img);// or die("No se pudo escribir la imagen");
    fclose($img);
} else {
    echo("No se encontró información de la imagen.\n");
}

// <<<------------------------------------------------------------------- Consulta para obtener proyectos asociados al usuario (estudiante o asesor)
if ($tipo_usuario === 'estudiante') {
    $sql_proyectos = "
    SELECT p.*
    FROM proyecto p
    JOIN integrante i ON p.id = i.id_proyecto
    WHERE i.id_estudiante = $1
";
} elseif ($tipo_usuario === 'asesor') {
    $sql_proyectos = "
    SELECT p.*
    FROM proyecto p
    JOIN proyecto_asesor pa ON p.id = pa.id_proyecto
    WHERE pa.id_asesor = $1
  ";
}


$result_proyectos = pg_prepare($con, "query_select_proyectos", $sql_proyectos);
if ($tipo_usuario === 'estudiante') {
    $res_proyectos = pg_execute($con, "query_select_proyectos", array($id_estudiante));
} elseif ($tipo_usuario === 'asesor') {
    $res_proyectos = pg_execute($con, "query_select_proyectos", array($id_asesor));
}

if ($res_proyectos && pg_num_rows($res_proyectos) > 0) {
    while ($row = pg_fetch_assoc($res_proyectos)) {
        // <<----- Se obtienen los datos de la tabla proyecto
        $id_proyecto          = $row["id"];
        $nombre_proyecto      = $row["nombre"];
        $descripcion_proyecto = $row["descripcion"];
        $area_proyecto        = $row["area"];
        $status               = $row["activo"];
        $conoc_req            = $row["conocimientos_requeridos"];
        $niv_innova           = $row["nivel_de_innovacion"];
        $logo                 = $row["logo"];
    }
    $mood_pr = 2;
    $sql_integrantes = "
    SELECT i.*, e.nombres, e.apellido_pat, e.apellido_mat
    FROM integrante i
    JOIN estudiante e ON i.id_estudiante = e.id_usuario
    WHERE i.id_proyecto = $1
    ";
    $result_integrantes = pg_prepare($con, "query_select_integrantes", $sql_integrantes);

} else {
    $mood_pr = 1;
}

// <<------------------------------ Consulta para obtener integrantes del proyecto

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mi perfil de Link-Proyect</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
    <link rel="stylesheet" href="../assets/styles/perfil_usuario.css" />
  </head>
  <body>
    <!-- ------------------------------------ Encabezado de pagina Inicial -->
    <header>
      <h1>Link-Project</h1>
    </header>
    <!-- ################################################################ panel de navegacion ############################################### -->
    <div id="sidebar" class="sidebar">
      <h2>Opciones</h2>
      <ul>
        <li>
          <a href="perfil_usuario.php?id=<?php echo $_SESSION['IDUser']; ?>"
            >Perfil usuario</a
          >
        </li>
        <li><a href="../src/server/cerrar_sesion.php">Cerrar sesion</a></li>
        <li><a href="#">Opción 3</a></li>
      </ul>
    </div>
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>
    <div class="button-container">
      <a href="crear_proyecto.php" class="btn">Crear Proyecto</a>
    </div>

    <div class="navigation-bar">
      <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css"
      />
      <i
        class="ti ti-baseline-density-small"
        id="menu"
        onclick="toggleSidebar()"
      ></i>
    </div>
    <!-- ------------------------------------------------------------------------- Contenido de la pagina -->
    <div class="Contenido">
      <div class="contenedor">
        <div class="Header">
          <form
            action="../src/server/subir_foto.php"
            method="POST"
            enctype="multipart/form-data"
          >
            <div class="avatar">
              <?php if ($file_name && file_exists($file_name)): ?>
              <!-- Mostramos la imagen guardada -->
              <img
                src="<?php echo htmlspecialchars($file_name); ?>"
                class="foto-usuario"
                alt="Foto del asesor"
              />
              <?php endif; ?>
              <input
                type="file"
                name="foto"
                id="foto"
                accept="image/*"
                onchange="this.form.submit();"
              />
              <link
                rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css"
              />
              <label
                for="foto"
                class="ti ti-pencil"
                style="cursor: pointer"
              ></label>
              <input
                type="hidden"
                id="id-usuario-input"
                name="id-usuario"
                value="<?php echo htmlspecialchars($id_usuario); ?>"
              />
            </div>
          </form>
          <h1><?php echo $nombre . ' ' . $apellidos; ?></h1>
        </div>

        <div class="contact-info">
          <form
            method="post"
            action="../src/server/usuario_update.php"
            enctype="multipart/form-data"
          >

            <input
              type="hidden"
              id="id-usuario-input"
              name="id-usuario"
              value="<?php echo $id_usuario ?>"
            />
            <input
              type="hidden"
              id="tipo-de-usuario-input"
              name="tipo-de-usuario"
              value="<?php echo $tipo_usuario ?>"
            />
            <div class="campos-2">
              <div class="campo">
                <label for="nombre-input">Nombre(s)</label>
                <input
                  type="text"
                  id="nombre-input"
                  name="nombre"
                  value="<?php echo $nombre ?>"
                />
              </div>

              <div class="campo">
                <label for="apellido-paterno-input">Apellido Paterno</label>
                <input
                  type="text"
                  id="apellido-paterno-input"
                  name="apellido-paterno"
                  value="<?php echo $apellido_pat ?>"
                />
              </div>

              <div class="campo">
                <label for="apellido-materno-input">Apellido Materno</label>
                <input
                  type="text"
                  id="apellido-materno-input"
                  name="apellido-materno"
                  value="<?php echo $apellido_mat ?>"
                />
              </div>

              <div class="campo">
                <label for="contacto-input">Télefono</label>
                <input
                  type="tel"
                  id="contacto-input"
                  name="contacto"
                  value="<?php echo $telefono ?>"
                  pattern="(\d{2}([\- ]?\d{4}){2}|(\d{3}[\- ]){2}\d{4})"
                  title='El número telefónico debe ser de 10 dígitos,
                    preferentemente separados con guiones "-" o espacios " ", tal
                    como se muestra en el ejemplo'
                />
              </div>
            </div>

            <h2>Datos de Escolares</h2>

            <?php if ($tipo_usuario === 'estudiante') : ?>

            <div class="campos-2" id="datos-alumno-div">
              <div class="campo">
                <label for="carrera-select">Carrera</label>
                <select name="carrera" id="carrera-select">
                  <option value="<?php echo $carrera ?>">
                    <?php echo $carrera ?>
                  </option>

                  <hr />

                  <optgroup label="División de Ciencias Básicas">
                    <option value="Licenciatura en Física">
                      Licenciatura en Física
                    </option>
                    <option value="Licenciatura en Matemáticas">
                      Licenciatura en Matemáticas
                    </option>
                    <option value="Licenciatura en Química">
                      Licenciatura en Química
                    </option>
                    <option value="Químico Farmacéutico Biólogo">
                      Químico Farmacéutico Biólogo
                    </option>
                    <option value="Licenciatura en Ciencia de Materiales">
                      Licenciatura en Ciencia de Materiales
                    </option>
                  </optgroup>

                  <hr />

                  <optgroup label="División de Ingenierías">
                    <option value="Ingeniería Civil">Ingeniería Civil</option>
                    <option value="Ingeniería en Alimentos y Biotecnología">
                      Ingeniería en Alimentos y Biotecnología
                    </option>
                    <option value="Ingeniería en Topografía Geomática">
                      Ingeniería en Topografía Geomática
                    </option>
                    <option value="Ingeniería Industrial">
                      Ingeniería Industrial
                    </option>
                    <option value="Ingeniería Mecánica Eléctrica">
                      Ingeniería Mecánica Eléctrica
                    </option>
                    <option value="Ingeniería Química">
                      Ingeniería Química
                    </option>
                    <option value="12">
                      Ingeniería en Logística y Transporte
                    </option>
                  </optgroup>

                  <hr />

                  <optgroup
                    label="División de Tecnologías para la Integración Ciber-Humana"
                  >
                    <option value="Ingeniería Informática">
                      Ingeniería Informática
                    </option>
                    <option value="Ingeniería Biomédica">
                      Ingeniería Biomédica
                    </option>
                    <option value="Ingeniería en Computación">
                      Ingeniería en Computación
                    </option>
                    <option value="Ingeniería en Comunicaciones y Electrónica">
                      Ingeniería en Comunicaciones y Electrónica
                    </option>
                    <option value="Ingeniería Fotónica">
                      Ingeniería Fotónica
                    </option>
                    <option value="Ingeniería Robótica">
                      Ingeniería Robótica
                    </option>
                  </optgroup>
                </select>
              </div>
              <div class="campo">
                <label for="codigo-estudiante-input"
                  >Código de Estudiante</label
                >
                <input
                  type="text"
                  id="codigo-estudiante-input"
                  name="codigo-estudiante"
                  value="<?php echo $codigo; ?>"
                  pattern="\d{9}"
                  title="El código debe contener 9 dígitos"
                />
              </div>
            </div>

            <div class="campo">
              <label for="habilidades-textarea">Habilidades</label>
              <textarea
                name="habilidades"
                id="habilidades-textarea"
                rows="5"
              ><?php echo htmlspecialchars($habilidades); ?></textarea
              >
            </div>

            <?php else: ?>

            <div class="campos-2" id="datos-asesor-div">
              <div class="campo">
                <label for="departamento-select">Departamento</label>
                <select name="departamento" id="departamento-select">
                  <option value="<?php echo $departamento ?>">
                    <?php echo $departamento ?>
                  </option>

                  <optgroup label="División de Ciencias Básicas">
                    <option value="Departamento de Farmacobiología">
                      Departamento de Farmacobiología
                    </option>
                    <option value="Departamento de Física">
                      Departamento de Física
                    </option>
                    <option value="Departamento de Matemáticas">
                      Departamento de Matemáticas
                    </option>
                    <option value="Departamento de Química">
                      Departamento de Química
                    </option>
                  </optgroup>

                  <hr />

                  <optgroup label="División de Ingenierías">
                    <option
                      value="Departamento de Ingeniería Civil y Topografía"
                    >
                      Departamento de Ingeniería Civil y Topografía
                    </option>
                    <option value="Departamento de Ingeniería Industrial">
                      Departamento de Ingeniería Industrial
                    </option>
                    <option
                      value="Departamento de Ingeniería Mecánica Eléctrica"
                    >
                      Departamento de Ingeniería Mecánica Eléctrica
                    </option>
                    <option value="Departamento de Ingeniería de Proyectos">
                      Departamento de Ingeniería de Proyectos
                    </option>
                    <option value="Departamento de Ingeniería Química">
                      Departamento de Ingeniería Química
                    </option>
                    <option value="Departamento de Madera, Celulosa y Papel">
                      Departamento de Madera, Celulosa y Papel
                    </option>
                  </optgroup>

                  <hr />

                  <optgroup
                    label="División de Tecnologías para la Integración Ciber-Humana"
                  >
                    <option value="Departamento de Bioingeniería Traslacional">
                      Departamento de Bioingeniería Traslacional
                    </option>
                    <option value="Departamento de Ciencias Computacionales">
                      Departamento de Ciencias Computacionales
                    </option>
                    <option value="Departamento de Ingeniería Electro-Fotónica">
                      Departamento de Ingeniería Electro-Fotónica
                    </option>
                    <option
                      value="Departamento de Innovación Basada en la Información y elConocimiento"
                    >
                      Departamento de Innovación Basada en la Información y
                      elConocimiento
                    </option>
                  </optgroup>
                </select>
              </div>
              <div class="campo">
                <label for="codigo-asesor-input">Código de Asesor</label>
                <input
                  type="text"
                  id="codigo-asesor-input"
                  name="codigo-asesor"
                  value="<?php echo $codigo ?>"
                  minlength="9"
                  maxlength="9"
                  pattern="\d{5,9}"
                  title="El código debe contener entre 5 y 9 dígitos"
                />
              </div>
            </div>

            <?php endif; ?>

            <h2>Datos de Inicio de Sesión</h2>

            <div class="campos-2">
              <div class="campo">
                <label for="email-input">Correo Electrónico</label>
                <input
                  type="email"
                  id="email-input"
                  name="email"
                  value="<?php echo $correo ?>"
                  pattern="\w[\w\.]{0,30}@(alumnos|academicos)\.udg\.mx"
                  title="El correo debe ser institucional, perteneciente a la UDG"
                  autocomplete="on"
                  disabled
                />
              </div>

              <div class="campo">
                <label for="password-input">Contraseña</label>
                <input
                  type="password"
                  id="password-input"
                  name="password"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
                  title='La contraseña debe ser de una longitud de 8-40 caracteres
                    y contener al menos un dígito, una mayúscula, una minúscula y un
                    carácter especial "/*+&..."'
                  disabled
                />
              </div>

              <div class="campo">
                <label for="password-input-2">Confirmar Contraseña</label>
                <input
                  type="password"
                  id="password-input-2"
                  name="password-2"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
                  title='La contraseña debe ser de una longitud de 8-40 caracteres
                    y contener al menos un dígito, una mayúscula, una minúscula y un
                    carácter especial "/*+&..."'
                  disabled
                />
              </div>
            </div>
            <button type="submit">Guardar Cambios</button>
          </form>

          <!-- <<--------------------------------------------- condicionamos para el apartado de habilidades -->
          <?php if ($tipo_usuario === 'estudiante'): ?>
          <p><?php echo htmlspecialchars($departamento); ?></p>
          <?php endif; ?>

          <div class="section-title">Proyecto</div>
          <div class="pr-item">
            <?php if (!empty($nombre_proyecto)): ?>
            <p class="section-title">Nombre del proyecto:</p>
            <p><?php echo $nombre_proyecto; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Descripción:</p>
            <p><?php echo $descripcion_proyecto; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Área del proyecto:</p>
            <p><?php echo $area_proyecto; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Estado del proyecto:</p>
            <p><?php echo $status; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Conocimientos requeridos:</p>
            <p><?php echo $conoc_req; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Nivel de innovación:</p>
            <p><?php echo $niv_innova; ?></p>
            <p>--------------------------------------------</p>
            <p class="section-title">Integrantes:</p>
            <?php

                // Ejecuta la consulta para obtener los integrantes
                $res_integrantes = pg_execute($con, "query_select_integrantes", array($id_proyecto));

                if ($res_integrantes && pg_num_rows($res_integrantes) > 0) {
                    while ($row = pg_fetch_assoc($res_integrantes)) {
                        // Obtén los datos del integrante
                        $nombre_integrante = $row['nombres'];
                        $apellidos_integrante = $row['apellido_pat'] . ' ' . $row['apellido_mat'];

                        // Muestra la información del integrante
                        echo "<p>$nombre_integrante $apellidos_integrante</p>";
                    }
                } else {
                    echo "<p>No se encontraron integrantes para el proyecto.</p>";
                }
?>
            <?php else: ?>
                <p>No hay proyecto asociado.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      function openSidebar() {
        document.getElementById("sidebar").style.right = "0" // Abre la barra lateral
        document.getElementById("overlay").style.display = "block" // Muestra el panel opaco
      }

      function closeSidebar() {
        document.getElementById("sidebar").style.right = "-250px" // Cierra la barra lateral
        document.getElementById("overlay").style.display = "none" // Oculta el panel opaco
      }

      function toggleSidebar() {
        const sidebar = document.getElementById("sidebar")
        const overlay = document.getElementById("overlay")

        if (sidebar.style.right === "0px") {
          closeSidebar() // Si está abierta, cierra
        } else {
          openSidebar() // Si está cerrada, abre
        }
      }
    </script>
  </body>
</html>
