<?php
require '../src/server/conecta.php';
$con = conecta();
$projectId = $_GET['id'];

$query = "SELECT * FROM proyecto WHERE id = $1";

$result = pg_query_params($con, $query, array($projectId));

if ($result && pg_num_rows($result) > 0) {
    $project = pg_fetch_assoc($result);
} else {
    echo "Proyecto no encontrado.";
    exit;
}

// Verifica si el logo tiene datos
if (!empty($project['logo'])) {
    $logo_size = strlen($project['logo']); // Longitud de los datos del logo
} else {
    $logo_size = 0; // No hay logo
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalles del Proyecto</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
  </head>
  <body class="center">

    <section class="container">
      <form method="" action="">
        <fieldset>
      <h1>Proyecto: <?php echo $project['nombre']; ?></h1>
          <div class="campo">
            <label>Descripción:</label>
            <textarea readonly><?php echo $project['descripcion']; ?></textarea>
          </div>
          <div class="campos-2">
            <div class="campo">
              <label>Área:</label>
              <input value="<?php echo $project['area']; ?>" readonly />
            </div>

            <div class="campo">
              <label>Cupos Disponibles:</label>
              <input value="<?php echo $project['cupos']; ?>" readonly />
            </div>

            <div class="campo">
              <label>Conocimientos Requeridos:</label>
              <input
                value="<?php echo $project['conocimientos_requeridos']; ?> "
                readonly
              />
            </div>

            <div class="campo">
              <label>Nivel de Innovación:</label>
              <input
                value="<?php echo $project['nivel_de_innovacion']; ?>"
                readonly
              />
            </div>

            <?php if ($logo_size > 0) : ?>
                <p>Logo tamaño: <?php echo $logo_size; ?> bytes</p>
                <img
                  src="data:image/jpeg;base64,<?php echo base64_encode($project['logo']); ?>"
                  alt="Logo del Proyecto"
                />
            <?php else: ?>
                <p>No hay logo disponible.</p>
            <?php endif; ?>

          </div>

          <!-- Botón de regreso -->
          <div class="button-container">
            <a href="inicio.php" class="btn">Regresar</a>
          </div>

        </fieldset>
      </form>
    </section>
  </body>
</html>
