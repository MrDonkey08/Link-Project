<?php
require '../src/server/conecta.php';
$con = conecta();

$query = "SELECT * FROM estudiante";
$result = pg_query($con, $query);

if (!$result) {
    echo "Error en la consulta: " . pg_last_error($con);
    exit;
}

echo "<h1>Lista de Estudiantes</h1>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido Pat</th>
            <th>Apellido Mat</th>
            <th>Correo Institucional</th>
            <th>Número de Teléfono</th>
            <th>Código de Estudiante</th>
            <th>Carrera</th>
            <th>Estado</th>
        </tr>";

while ($row = pg_fetch_assoc($result)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ID']) . "</td>
            <td>" . htmlspecialchars($row['Nombre']) . "</td>
            <td>" . htmlspecialchars($row['Apellido_pat']) . "</td>
            <td>" . htmlspecialchars($row['Apellido_mat']) . "</td>
            <td>" . htmlspecialchars($row['correo_institucional']) . "</td>
            <td>" . htmlspecialchars($row['num_tel']) . "</td>
            <td>" . htmlspecialchars($row['codigo_estudiante']) . "</td>
            <td>" . htmlspecialchars($row['carrera']) . "</td>
            <td>" . htmlspecialchars($row['estado']) . "</td>
          </tr>";
}

echo "</table>";

pg_close($con);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
</head>
<body>
    <h1>Registro de Estudiante</h1>
</body>
</html>