<?php
include '../dist/back-end/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Tablero de Kanban</title>

    <link href="../assets/styles/kanban.css" rel="stylesheet" />
    <script async src="../dist/client/kanban/drag_task.js"></script>
  </head>
  <body>
    <div id="board">
      <div id="lists">
        <div class="list" id="todo-list">
          <h2>Por Hacer</h2>

          <div class="tasks" id="todo-tasks">
            <p class="task" draggable="true">Task 1</p>
            <p class="task" draggable="true">Task 2</p>
            <p class="task" draggable="true">Task 3</p>
          </div>

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

          <div class="tasks" id="in-progress-tasks">
            <p class="task" draggable="true">Task 4</p>
            <p class="task" draggable="true">Task 5</p>
            <p class="task" draggable="true">Task 6</p>
          </div>

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

          <div class="tasks" id="done-tasks">
            <p class="task" draggable="true">Task 7</p>
            <p class="task" draggable="true">Task 8</p>
            <p class="task" draggable="true">Task 9</p>
          </div>

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
  </body>
</html>
