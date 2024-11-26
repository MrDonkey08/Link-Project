"use strict";
(() => {
  const lists = document.querySelectorAll(".list");

  for (const list of lists) {
    const form = list.querySelector(".add-task-form");
    const task_container = list.querySelector(".tasks");

    if (form) {
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const input = form.querySelector(".new-task-input");

        if (input instanceof HTMLInputElement) {
          const taskDescription = input.value;

          // Enviar tarea al backend para guardarla
          const response = await fetch("../../../src/server/kanban_back.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              action: "add", // Acción para agregar una nueva tarea
              description: taskDescription,
              phase: 1 // Asumimos que la tarea comienza en 'Por Hacer'
            })
          });

          const result = await response.json();

          if (result.success) {
            // Crear el elemento de tarea solo si la adición fue exitosa
            const task_box = document.createElement("div");
            task_box.classList.add("task-box");
            const new_task = document.createElement("p");
            new_task.classList.add("task");
            new_task.setAttribute("draggable", "true");
            new_task.innerText = taskDescription;

            task_box.addEventListener("dragstart", () => {
              task_box.classList.add("is-dragging");
            });

            task_box.addEventListener("dragend", () => {
              task_box.classList.remove("is-dragging");
            });

            const delete_button = document.createElement("button");
            delete_button.innerText = "Eliminar";
            delete_button.addEventListener("click", async () => {
              const response = await fetch("../../../src/server/kanban_back.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "delete", id: result.taskId })
              });

              const resultDelete = await response.json();
              if (resultDelete.success) {
                task_box.remove();
              }
            });

            task_box.appendChild(new_task);
            task_box.appendChild(delete_button);
            task_container?.appendChild(task_box);

            input.value = ""; // Limpiar el campo de entrada
          }
        }
      });
    }
  }
})();
