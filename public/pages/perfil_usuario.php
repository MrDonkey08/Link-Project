<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';
// Obtiene el ID que se envia desde el icono de "user"
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
    $id_estudiante  = $row["id_estudiante"];
    $nombre         = $row["nombres"];
    $apellidos      = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
    $carrera        = $row["carrera"];
    $telefono       = $row["num_tel"];
    $correo         = $row["correo"];
    $codigo         = $row["codigo_escolar"];
    $foto           = $row["foto"];
    $habilidades    = $row["habilidades"];
    $tipo_usuario = 'estudiante';
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
// <<<------------------------------------------------------------------- Consulta para obtener proyectos asociados al usuario (estudiante o asesor)
if($tipo_usuario === 'estudiante') {
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
        $area_proyecto       = $row["area"];
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
            <li><a href="perfil_usuario.php?id=<?php echo $_SESSION['IDUser']; ?>">Perfil usuario</a></li>
            <li><a href="../src/server/cerrar_sesion.php">Cerrar sesion</a></li>
            <li><a href="#">Opción 3</a></li>
        </ul>
    </div>
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>
    <div class="button-container">
      <a href="crear_proyecto.php" class="btn">Crear Proyecto</a>
    </div>

    <div class="navigation-bar">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
      <i class="ti ti-baseline-density-small" id="menu" onclick="toggleSidebar()"></i>
    </div>
    <!-- ------------------------------------------------------------------------- Contenido de la pagina -->
    <div class="Contenido">
      <div class="contenedor">
        <div class="Header">
          <form action="../src/server/subir_foto.php" method="POST" enctype="multipart/form-data">
            <div class="avatar">
              <?php if ($foto && file_exists($foto)): ?>
                  <!-- Mostramos la imagen guardada -->
                  <img src="<?php echo htmlspecialchars($foto); ?>" class="foto-usuario" alt="Foto del asesor">
                  <input type="file" name="foto" id="foto" accept="image/*" onchange="this.form.submit();" />
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
                  <label for="foto" class="ti ti-pencil" style="cursor: pointer"></label>
              <?php else: ?>
                  <input type="file" name="foto" id="foto" accept="image/*" onchange="this.form.submit();" />
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
                  <label for="foto" class="ti ti-pencil" style="cursor: pointer"></label>
                  </label>
              <?php endif; ?>
            </div>
          </form>
          <h1><?php echo $nombre . ' ' . $apellidos; ?></h1>
        </div>

        <div class="contact-info">
          <p><?php echo $foto; ?></p>
          <p><?php echo $telefono; ?></p>
          <p><?php echo $correo; ?></p>
          <p><?php echo $codigo; ?></p>
          <!-- <<--------------------------------------------- condicionamos para el apartado de departamento -->
          <?php
              if ($tipo_usuario === 'asesor') {
                  echo "<p>Departamento: {$departamento}</p>"; 
              } else {
                  echo "<p>Carrera: {$carrera}</p>"; 
              }
          ?>
        <!-- <<--------------------------------------------- condicionamos para el apartado de habilidades -->
        <?php if ($tipo_usuario === 'estudiante'): ?>
          <div class="section-title">Habilidades</div>
          <div class="pr-item">
              <form action="../src/server/habilidades_salva.php" method="POST">
                  <textarea
                      name="habilidades"
                      id="habilidades"
                      rows="30"
                      cols="50"
                      required
                  >
                      <?php echo htmlspecialchars($habilidades); ?>
                  </textarea>
                  <input
                      type="hidden"
                      name="id_estudiante"
                      value="<?php echo $id_estudiante; ?>"
                  />
                  <button type="submit">Guardar Habilidades</button>
              </form>
          </div>
      <?php else: ?>
          <div class="section-title">Departamento</div>
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
    <script>
        function openSidebar() {
            document.getElementById("sidebar").style.right = "0"; // Abre la barra lateral
            document.getElementById("overlay").style.display = "block"; // Muestra el panel opaco
        }

        function closeSidebar() {
            document.getElementById("sidebar").style.right = "-250px"; // Cierra la barra lateral
            document.getElementById("overlay").style.display = "none"; // Oculta el panel opaco
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            
            if (sidebar.style.right === "0px") {
                closeSidebar(); // Si está abierta, cierra
            } else {
                openSidebar(); // Si está cerrada, abre
            }
        }
    </script>
  </body>
</html>
