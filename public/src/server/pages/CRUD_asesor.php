<?php
require '../../server/conecta.php';
$con = conecta();

$query = "SELECT * FROM asesor";
$result = pg_query($con, $query);

if (!$result) {
    echo "Error en la consulta: " . pg_last_error($con);
    exit;
}

echo "<h1>Lista de Asesores</h1>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido Pat</th>
            <th>Apellido Mat</th>
            <th>Código</th>
            <th>Correo Institucional</th>
            <th>Departamento</th>
            <th>Acción</th>
        </tr>";

while ($row = pg_fetch_assoc($result)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['id']) . "</td>
            <td>" . htmlspecialchars($row['nombre']) . "</td>
            <td>" . htmlspecialchars($row['apellido_pat']) . "</td>
            <td>" . htmlspecialchars($row['apellido_mat']) . "</td>
            <td>" . htmlspecialchars($row['codigo']) . "</td>
            <td>" . htmlspecialchars($row['correo_institucional']) . "</td>
            <td>" . htmlspecialchars($row['departamento']) . "</td>
            <td><button>Eliminar</button></td>
          </tr>";
}

echo "</table>";

pg_close($con);
?>
