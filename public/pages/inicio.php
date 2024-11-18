<?php
require '../src/server/conecta.php';
$con = conecta();

$query = "SELECT id, nombre, cupos FROM proyecto WHERE activo = TRUE";
$result = pg_query($con, $query);

$proyectos = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
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
      <input type="text" id="search" placeholder="Buscar proyecto..." />
    </div>

    <!-- Mostrar los proyectos -->
    <div class="projects-list">
      <h2>Proyectos Disponibles</h2>
      <?php if (!empty($proyectos)): ?>
      <div class="projects-grid">
        <?php foreach ($proyectos as $proyecto): ?>
        <div class="project-card">
          <a href="detalles_proyecto.php?id=<?php echo $proyecto['id']; ?>">
            <h3><?php echo $proyecto['nombre']; ?></h3>
            <p>Cupos disponibles: <?php echo $proyecto['cupos']; ?></p>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <p>No hay proyectos disponibles.</p>
      <?php endif; ?>
    </div>

    <script src="../dist/inicio.js"></script>
  </body>
</html>
