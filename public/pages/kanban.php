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
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Tablero de Kanban</title>

    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
    <link rel="stylesheet" href="../assets/styles/kanban.css" />

    <script async src="../dist/client/kanban/drag_task.js"></script>
    <script async src="../dist/client/kanban/add_task.js"></script>
    <script async src="../dist/client/kanban/kanban.js"></script>
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
    <div id="board">
      <div id="lists">
        <div class="list" id="todo-list">
          <h2>Por Hacer</h2>

          <div class="tasks" id="todo-tasks"></div>

          <form class="add-task-form">
            <input
              type="text"
              class="new-task-input"
              name="new-task"
              placeholder="Nueva tarea"
              required
            />
            <button type="submit">Add</button>
          </form>
        </div>

        <div class="list" id="in-progress-list">
          <h2>En Proceso</h2>

          <div class="tasks" id="in-progress-tasks"></div>

          <form class="add-task-form">
            <input
              type="text"
              class="new-task-input"
              name="new-task"
              placeholder="Nueva tarea"
              required
            />
            <button type="submit">Add</button>
          </form>
        </div>

        <div class="list" id="done-list">
          <h2>Hechos</h2>

          <div class="tasks" id="done-tasks"></div>

          <form class="add-task-form">
            <input
              type="text"
              class="new-task-input"
              name="new-task"
              placeholder="Nueva tarea"
              required
            />
            <button type="submit">Add</button>
          </form>
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
