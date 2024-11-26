document.addEventListener("DOMContentLoaded", async () => {
    // Llamar a fetchTasks para cargar las tareas al cargar la página
    await fetchTasks();
});

// Función para obtener las tareas desde el servidor
async function fetchTasks() {
    const response = await fetch("../../../src/server/kanban_back.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "fetch" }),
    });

    const result = await response.json();

    if (result.success) {
        const tasks = result;

        // Limpiar las listas de tareas antes de agregar nuevas
        document.getElementById("todo-tasks").innerHTML = "";
        document.getElementById("in-progress-tasks").innerHTML = "";
        document.getElementById("done-tasks").innerHTML = "";

        // Agregar las tareas a la interfaz
        tasks.forEach((task) => {
            const { id, descripcion, fase } = task;
            const listId = getListIdFromPhase(fase);

            const taskBox = document.createElement("div");
            taskBox.classList.add("task-box");
            taskBox.dataset.id = id;

            const taskElement = document.createElement("p");
            taskElement.classList.add("task");
            taskElement.setAttribute("draggable", "true");
            taskElement.innerText = descripcion;

            taskBox.appendChild(taskElement);

            // Crear el botón para eliminar la tarea
            const deleteButton = document.createElement("button");
            deleteButton.innerText = "Eliminar";
            deleteButton.addEventListener("click", () => deleteTask(id, taskBox));

            taskBox.appendChild(deleteButton);

            // Agregar la tarea al contenedor correspondiente
            const taskContainer = document.getElementById(listId);
            taskContainer?.appendChild(taskBox);
        });
    } else {
        console.error("Error al cargar las tareas:", result.error);
    }
}

// Función para obtener el ID de la lista según la fase numérica (1, 2, 3)
function getListIdFromPhase(fase) {
    switch (fase) {
        case 1:
            return "todo-tasks";         // Fase 1: Por hacer
        case 2:
            return "in-progress-tasks";  // Fase 2: En proceso
        case 3:
            return "done-tasks";         // Fase 3: Hechos
        default:
            return "todo-tasks";         // Por defecto, por hacer
    }
}

// Función para agregar una nueva tarea
document.querySelector('.add-task-form').addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar que el formulario recargue la página

    const taskDescription = document.querySelector('.new-task-input').value;
    const taskPhase = 1;  // La fase predeterminada (1 = por hacer)
    const projectId = 1;  // Ajusta esto al ID de tu proyecto real

    const response = await fetch("../../../src/server/kanban_back.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "add",
            descripcion: taskDescription,
            fase: taskPhase,
            id_proyecto: projectId,
        }),
    });

    const result = await response.json();

    if (result.success) {
        console.log('Tarea agregada con éxito:', result);
        // Llamar a fetchTasks para cargar las tareas nuevamente
        await fetchTasks();
    } else {
        console.error("Error al agregar tarea:", result.error);
    }

    // Limpiar el campo de entrada
    document.querySelector('.new-task-input').value = '';
});

// Función para eliminar una tarea
async function deleteTask(id, taskBox) {
    const response = await fetch("../../../src/server/kanban_back.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "delete", id }),
    });

    const result = await response.json();
    if (result.success) {
        taskBox.remove();  // Eliminar la tarea de la interfaz
    } else {
        console.error("Error al eliminar la tarea:", result.error);
    }
}
