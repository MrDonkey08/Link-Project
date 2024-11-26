;(() => {
    const lists = document.querySelectorAll<HTMLElement>(".list");

    for (const list of lists) {
        const form = list.querySelector(".add-task-form");
        const taskContainer = list.querySelector(".tasks");
        const listId = list.id; // Obtiene el ID del estado actual (todo, in-progress, done)

        if (form) {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const input = form.querySelector<HTMLInputElement>(".new-task-input");

                if (input instanceof HTMLInputElement && input.value.trim() !== "") {
                    const taskDescription = input.value;

                    // Enviar tarea al backend
                    const response = await fetch("../src/server/kanban_BACK.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            action: "add",
                            description: taskDescription,
                            phase: getPhaseFromListId(listId),
                        }),
                    });

                    const result = await response.json();
                    if (result.success) {
                        const taskId = result.taskId;

                        // Crear la tarea en el DOM
                        const taskBox = createTaskBox(taskDescription, taskId);

                        // Agregar la nueva tarea al contenedor
                        taskContainer?.appendChild(taskBox);

                        // Limpiar el campo de entrada
                        input.value = "";
                    } else {
                        console.error("Error al agregar la tarea:", result.message);
                    }
                }
            });
        }
    }

    const createTaskBox = (description: string, id: number): HTMLElement => {
        const taskBox = document.createElement("div");
        taskBox.classList.add("task-box");
        taskBox.dataset.id = id.toString(); // ID de la tarea en la base de datos

        const taskElement = document.createElement("p");
        taskElement.classList.add("task");
        taskElement.setAttribute("draggable", "true");
        taskElement.innerText = description;

        taskBox.addEventListener("dragstart", () => {
            taskBox.classList.add("is-dragging");
        });

        taskBox.addEventListener("dragend", () => {
            taskBox.classList.remove("is-dragging");
        });

        const deleteButton = document.createElement("button");
        deleteButton.innerText = "Eliminar";

        deleteButton.addEventListener("click", async () => {
            const taskId = taskBox.dataset.id;

            // Enviar solicitud para eliminar la tarea
            const response = await fetch("../src/server/kanban_BACK.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "delete", id: taskId }),
            });

            const result = await response.json();
            if (result.success) {
                taskBox.remove();
            } else {
                console.error("Error al eliminar la tarea:", result.message);
            }
        });

        taskBox.appendChild(taskElement);
        taskBox.appendChild(deleteButton);

        return taskBox;
    };

    const getPhaseFromListId = (listId: string): number => {
        switch (listId) {
            case "todo-list":
                return 1;
            case "in-progress-list":
                return 2;
            case "done-list":
                return 3;
            default:
                return 1;
        }
    };
})();
