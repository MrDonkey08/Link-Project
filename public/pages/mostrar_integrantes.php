<?php
require '../src/server/conecta.php';
$con = conecta();

$query = "SELECT 
            i.id_integrante, 
            e.nombres AS nombre_estudiante, 
            p.nombre AS nombre_proyecto, 
            i.lider
          FROM 
            integrante i
          JOIN 
            estudiante e ON i.id_estudiante = e.id_estudiante
          JOIN 
            proyecto p ON i.id_proyecto = p.id
          ORDER BY 
            i.id_integrante";

$result = pg_query($con, $query);


if (!$result) {
    echo "Ocurrió un error al obtener los datos.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Integrantes</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/integrantes.css" />
</head>
<body>
    <h1>Integrantes del Proyecto</h1>
    <table>
        <thead>
            <tr>
                <th>ID Integrante</th>
                <th>Nombre Estudiante</th>
                <th>Nombre Proyecto</th>
                <th>Líder</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = pg_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id_integrante']; ?></td>
                    <td><?php echo $row['nombre_estudiante']; ?></td>
                    <td><?php echo $row['nombre_proyecto']; ?></td>
                    <td><?php echo $row['lider'] ? 'Sí' : 'No'; ?></td>
                </tr>
                <div class="button-containe">
                 <a href="inicio.php" class="btn">Regresar</a>
                 </div>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Cerrar la conexión
pg_close($con);
?>
