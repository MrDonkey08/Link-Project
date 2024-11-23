<?php
require '../src/server/conecta.php';
$con = conecta();

// Consulta los proyectos con sus descripciones
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
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
  </head>
  <body>
    <header>
      <h1>Link-Project</h1>
    </header>

    <div class="button-container">
      <a href="crear_proyecto.php" class="btn">Crear Proyecto</a>
    </div>

    <!-- Barra de búsqueda -->
    <div class="search-container">
      <input type="text" id="search" placeholder="Buscar proyectos...">
      <button id="search-btn">Buscar</button>
    </div>

    <!-- Mostrar los proyectos -->
    <div class="projects-list">
      <h2>Proyectos Disponibles</h2>
      <?php if (!empty($proyectos)): ?>
      <div class = campos1> 
      <div class="projects-grid">
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
        </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <p>No hay proyectos disponibles.</p>
      <?php endif; ?>
    </div>

    <script src="../dist/client/inicio.js"></script>
  </body>
</html>
