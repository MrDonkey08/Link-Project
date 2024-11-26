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

$query = "  SELECT 
                i.id AS id_integrante, 
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
                i.lider DESC, i.id";

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
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
    <link rel="stylesheet" href="../assets/styles/integrantes.css" />
</head>
<body>
    <header>
    <h1>Link-Project</h1>
    </header>
    <!-- ################################################################ panel de navegacion ############################################### -->
    <div id="sidebar" class="sidebar">
        <h2>Opciones</h2>
        <ul>
            <li><a href="perfil_usuario.php?id=<?php echo $_SESSION['IDUser']; ?>">Perfil usuario</a></li>
            <li><a href="inicio.php?id=<?php echo $_SESSION['IDUser']; ?>">Inicio</a></li>
            <li><a href="agenda_reuniones.php?id=<?php echo $_SESSION['IDUser']; ?>">Reuniones</a></li>
            <li><a href="mostrar_integrantes.php?id=<?php echo $_SESSION['IDUser']; ?>">Integrantes</a></li>
            <li><a href="kanban.php">Kanban</a></li>
            <li><a href="../src/server/cerrar_sesion.php">Cerrar sesion</a></li>
        </ul>
    </div>
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

    <div class="navigation-bar">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
        <i class="ti ti-baseline-density-small" id="menu" onclick="toggleSidebar()"></i>
    </div>
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
                    <td><?php echo htmlspecialchars($row['nombre_estudiante']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_proyecto']); ?></td>
                    <td><?php echo $row['lider'] === 't' ? 'Sí' : 'No'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    

    <script>
        function openSidebar() {
            document.getElementById("sidebar").style.right = "0" // Abre la barra lateral
            document.getElementById("overlay").style.display = "block" // Muestra el panel opaco
        }

        function closeSidebar() {
            document.getElementById("sidebar").style.right = "-250px" // Cierra la barra lateral
            document.getElementById("overlay").style.display = "none" // Oculta el panel opaco
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar")
            const overlay = document.getElementById("overlay")

            if (sidebar.style.right === "0px") {
            closeSidebar() // Si está abierta, cierra
            } else {
            openSidebar() // Si está cerrada, abre
            }
        }
    </script>
</body>
</html>
<?php
// Cerrar la conexión
pg_close($con);
?>