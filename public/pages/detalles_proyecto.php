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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
</head>
<body>

    <header>
        <h1>Detalles del Proyecto: <?php echo $project['nombre']; ?></h1>
    </header>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />

    <div class="project-details">
        <h2>Descripción:</h2>
        <p><?php echo $project['descripcion']; ?></p>
        
        <h3>Área:</h3>
        <p><?php echo $project['area']; ?></p>
        
        <h3>Cupos Disponibles:</h3>
        <p><?php echo $project['cupos']; ?></p>
        
        <h3>Conocimientos Requeridos:</h3>
        <p><?php echo $project['conocimientos_requeridos']; ?></p>
        
        <h3>Nivel de Innovación:</h3>
        <p><?php echo $project['nivel_de_innovacion']; ?></p>
        
        <?php if ($project['logo']): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($project['logo']); ?>" alt="Logo del Proyecto">
        <?php endif; ?>
    </div>

</body>
</html>
