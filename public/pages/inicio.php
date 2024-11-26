<?php
session_start();

$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
} 
$id_usuario = $_SESSION['IDUser'];
if (!isset($_SESSION['IDUser']) || !isset($_SESSION['NombreUser'])) {
    header('Location: ../index.php');
    exit();
}
$nombre_usuario = $_SESSION['NombreUser'];

require '../src/server/conecta.php';
$con = conecta();

$query_proyectos = "SELECT id, nombre, cupos, descripcion FROM proyecto WHERE activo = TRUE";
$result_proyectos = pg_query($con, $query_proyectos);

$proyectos = [];
if ($result_proyectos) {
    while ($row = pg_fetch_assoc($result_proyectos)) {
        $proyectos[] = $row;
    }
} else {
    echo "Error al obtener los proyectos.";
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Link-Project</title>
  
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
  </head>
  <body>
    
    <header>
      <h1>Link-Project</h1>
      <p>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>!</p>
    </header>
    <!-- ################################################################ panel de navegacion ############################################### -->
    <div id="sidebar" class="sidebar">
        <h2>Opciones</h2>
        <ul>
            <li><a href="perfil_usuario.php?id=<?php echo $_SESSION['IDUser']; ?>">Perfil usuario</a></li>
            <li><a href="kanban.php">Kanban</a></li>
            <li><a href="../src/server/cerrar_sesion.php">Cerrar sesion</a></li>
            <li><a href="agenda_reuniones.php?id=<?php echo $_SESSION['IDUser']; ?>">Reuniones</a></li>
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

    <!-- Barra de búsqueda -->
    <div class="search-container">
      <input type="text" id="search" placeholder="Buscar proyectos..." />
      <button id="search-btn">Buscar</button>
    </div>


    <!-- Mostrar los proyectos -->
    <div class="projects-list">
      <h2>Proyectos Disponibles</h2>
        <?php if (!empty($proyectos)): ?>
        <?php foreach ($proyectos as $proyecto): ?>
      <div class="project-card">
        <a href="detalles_proyecto.php?id=<?php echo $proyecto['id']; ?>">
            <h3><?php echo htmlspecialchars($proyecto['nombre']); ?></h3>
            <p>
              Descripción: 
              <?php 
                $descripcion_larga = isset($proyecto['descripcion']) ? $proyecto['descripcion'] : '';
                $descripcion_recortada = substr($descripcion_larga, 0, 40);
                if (strlen($descripcion_larga) > 40) {
                  $descripcion_recortada .= '...';
                }
                echo htmlspecialchars($descripcion_recortada);
              ?>
            </p>
            
            <p>Cupos disponibles: <?php echo htmlspecialchars($proyecto['cupos']); ?></p>
          </a>
          <!-- Contenedor para el botón -->
          <div class="send-request-btn-container" style="display: flex; justify-content: flex-end;">
          <button class="send-request-btn">Enviar Solicitud</button>
          </div>
      </div>
      <?php endforeach; ?> <?php else: ?>
      <p>No hay proyectos disponibles.</p>
      <?php endif; ?>
    </div>
    <script src="../dist/client/inicio.js"></script>
  </body>
</html>
