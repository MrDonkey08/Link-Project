<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}
$con = conecta();
// <<------------------------------------------------------------------ Esto es para mostrar las reuniones
$query = "SELECT 
    r.id, 
    r.titulo, 
    r.fecha, 
    r.hora, 
    COALESCE(
        STRING_AGG(DISTINCT CASE 
            WHEN p.id_usuario IS NOT NULL THEN p.nombres || ' ' || p.apellido_pat 
        END, ', '), 
        'Ninguno'
    ) AS participantes,
    COALESCE(
        STRING_AGG(DISTINCT CASE 
            WHEN a.id_usuario IS NOT NULL THEN a.nombres || ' ' || a.apellido_pat 
        END, ', '), 
        'Sin asesor'
    ) AS asesor
FROM reunion r
LEFT JOIN reunion_participante rp ON r.id = rp.id_reunion
LEFT JOIN integrante i ON rp.id_integrante = i.id
LEFT JOIN usuario p ON i.id_estudiante = p.id_usuario
LEFT JOIN usuario a ON rp.id_asesor = a.id_usuario
GROUP BY r.id, r.titulo, r.fecha, r.hora;
";

$result = pg_query($con, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error($con));
}

$reuniones = pg_fetch_all($result);

// <<------------------------------------------------------------------ Esto es para mostrar id estudiante
$sql_estudiante = "SELECT * FROM estudiante WHERE id_usuario = $1";
$result_estudiante = pg_prepare($con, "query_select_estudiante", $sql_estudiante);
$res_estudiante = pg_execute($con, "query_select_estudiante", array($id_usuario));
$row = pg_fetch_assoc($res_estudiante);
    // <<----- Se obtienen los datos de la tabla estudiante
    $id_estudiante = $row["id_estudiante"];
// <<------------------------------------------------------------------ Esto es para mostrar al proyecto
$sql_proyectos = "
    SELECT p.*
    FROM proyecto p
    JOIN integrante i ON p.id = i.id_proyecto
    WHERE i.id_estudiante = $1
";
$result_proyectos = pg_prepare($con, "query_select_proyectos", $sql_proyectos);
$res_proyectos = pg_execute($con, "query_select_proyectos", array($id_estudiante));
while ($row = pg_fetch_assoc($res_proyectos)) {
    // <<----- Se obtienen los datos de la tabla proyecto
    $id_proyecto          = $row["id"];
}
// <<------------------------------------------------------------------ Esto es para mostrar a los integrantes
$sql_integrantes = "
SELECT i.*, e.nombres, e.apellido_pat, e.apellido_mat
FROM integrante i
JOIN estudiante e ON i.id_estudiante = e.id_usuario
WHERE i.id_proyecto = $1
";
$result_integrantes = pg_prepare($con, "query_select_integrantes", $sql_integrantes);
// <<------------------------------------------------------------------ Esto es para mostrar al asesor del proyecto
$sql_asesor = "
    SELECT a.id_asesor, a.nombres, a.apellido_pat, a.apellido_mat
    FROM proyecto_asesor pa
    JOIN asesor a ON pa.id_asesor = a.id_asesor
    WHERE pa.id_proyecto = $1
";

$result_asesor = pg_prepare($con, "query_select_asesor", $sql_asesor);
$res_asesor = pg_execute($con, "query_select_asesor", array($id_proyecto));

// Verifica si la consulta fue exitosa
if ($res_asesor) {
    $asesor = pg_fetch_assoc($res_asesor);

    if ($asesor) {
        // Accede al id_asesor
        $id_asesor = $asesor['id_asesor'];
    } else {
    }
} else {
    echo "Error en la consulta: " . pg_last_error($con);
}
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Reuniones</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
    <link rel="stylesheet" href="../assets/styles/agenda_reuniones.css" />
    
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
    <h1>Agenda de Reuniones</h1>
    <div class="Contenido">
        <div class="contenedor">
            <div class="form-container">
                <h2>Agendar Reunión</h2>
                <form action="../src/server/procesar_reuniones.php" method="post">
                    <label for="title">Título:</label><br>
                    <input type="text" id="title" name="title" required><br>
                    <label for="date">Fecha:</label><br>
                    <input type="date" id="date" name="date" required><br>
                    <label for="time">Hora:</label><br>
                    <input type="time" id="time" name="time" required><br>
                    <p class="section-title">Integrantes:</p>
                    <?php
                        // Ejecuta la consulta para obtener los integrantes
                        $res_integrantes = pg_execute($con, "query_select_integrantes", array($id_proyecto));

                        if ($res_integrantes && pg_num_rows($res_integrantes) > 0) {
                            echo '<form action="procesar_reunion.php" method="post">'; // Formulario para enviar los seleccionados
                                while ($row = pg_fetch_assoc($res_integrantes)) {
                                    // Obtén los datos del integrante
                                        $nombre_integrante = htmlspecialchars($row['nombres']);
                                        $apellidos_integrante = htmlspecialchars($row['apellido_pat'] . ' ' . $row['apellido_mat']);
                                        $id_integrante = htmlspecialchars($row['id_estudiante']); 
                                        
                                        // Muestra la información del integrante con un checkbox
                                        echo "<div class='caja'>
                                                <input type='checkbox' name='integrantes[]' value='$id_integrante' id='integrante_$id_integrante' class='check' >
                                                <label for='integrante_$id_integrante' >$nombre_integrante $apellidos_integrante</label>
                                            </div>";
                                }
                            } else {
                                echo "<p>No se encontraron integrantes para el proyecto.</p>";
                            }
                            echo "<p class='section-title'>Asesor:</p>";
                            // Mostrar el asesor
                            if ($asesor) {
                                $nombre_asesor = htmlspecialchars($asesor['nombres']);
                                $apellidos_asesor = htmlspecialchars($asesor['apellido_pat'] . ' ' . $asesor['apellido_mat']);
                                echo "<div class='caja'>
                                            <input type='checkbox' name='asesor' value='$id_asesor' id='asesor_$id_asesor' class='check'>
                                            <label for='asesor_$id_asesor'>$nombre_asesor $apellidos_asesor</label>
                                            
                                    </div>";
                            } else {
                                echo "<p>No se encontró asesor para este proyecto.</p>";
                            }
                    ?>
                    <button type="submit">Añadir Reunión</button>
                </form>
            </div>

            <div class="meeting-list">
                <h2>Reuniones Programadas</h2>
                <?php if ($reuniones): ?>
                    <?php foreach ($reuniones as $reunion): ?>
                        <div class="meeting-item">
                            <strong><?php echo htmlspecialchars($reunion['titulo']); ?></strong><br>
                            Fecha: <?php echo htmlspecialchars($reunion['fecha']); ?><br>
                            Hora: <?php echo htmlspecialchars($reunion['hora']); ?><br>
                            Participantes: <?php echo htmlspecialchars($reunion['participantes']) . ', ' . htmlspecialchars($reunion['asesor']); ?><br>
                            <a href="../src/server/procesar_reuniones.php?download=1&id=<?php echo $reunion['id']; ?>" class="btn">Añadir al Calendario</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay reuniones programadas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
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
