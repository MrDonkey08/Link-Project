<?php
require '../../server/conecta.php';
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
            <th>Eliminar</th> <!-- Columna de Eliminar -->
        </tr>";

while ($row = pg_fetch_assoc($result)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['id']) . "</td>
            <td>" . htmlspecialchars($row['nombre']) . "</td>
            <td>" . htmlspecialchars($row['apellido_pat']) . "</td>
            <td>" . htmlspecialchars($row['apellido_mat']) . "</td>
            <td>" . htmlspecialchars($row['correo_institucional']) . "</td>
            <td>" . htmlspecialchars($row['num_tel']) . "</td>
            <td>" . htmlspecialchars($row['codigo_estudiante']) . "</td>
            <td>" . htmlspecialchars($row['carrera']) . "</td>
            <td>" . htmlspecialchars($row['estado']) . "</td>
            <td><!-- Aquí se podría agregar un botón o enlace para eliminar --></td>
          </tr>";
}

echo "</table>";

pg_close($con);
?>
