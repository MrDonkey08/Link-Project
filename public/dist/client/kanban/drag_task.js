"use strict";
(() => {
  const draggables = document.querySelectorAll(".task-box");
  const droppables = document.querySelectorAll(".tasks");

  for (const task_box of draggables) {
    task_box.addEventListener("dragstart", () => {
      task_box.classList.add("is-dragging");
    });

    task_box.addEventListener("dragend", () => {
      task_box.classList.remove("is-dragging");
    });
  }

  for (const zone of droppables) {
    zone.addEventListener("dragover", (e) => {
      e.preventDefault();

      const bottom_task = insertAboveTask(zone, e.clientY);
      const current_task = document.querySelector(".is-dragging");

      if (current_task) {
        if (!bottom_task) {
          zone.appendChild(current_task);
        } else {
          zone.insertBefore(current_task, bottom_task);
        }
      }
    });
  }

  const insertAboveTask = (zone, mouseY) => {
    const els = zone.querySelectorAll(".task-box:not(.is-dragging)");
    let closest_task = null;
    let closest_offset = Number.NEGATIVE_INFINITY;

    for (const task_box of els) {
      const { top } = task_box.getBoundingClientRect();
      const offset = mouseY - top;

      if (offset < 0 && offset > closest_offset) {
        closest_offset = offset;
        closest_task = task_box;
      }
    }

    return closest_task;
  };

  // Después de soltar la tarea, actualiza la fase en la base de datos
  droppables.forEach((zone) => {
    zone.addEventListener("drop", async (e) => {
      const current_task = document.querySelector(".is-dragging");

      if (current_task) {
        const taskId = current_task.dataset.id;
        const newPhase = getPhaseFromZone(zone);

        const response = await fetch("../../../src/server/kanban_back.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "update", // Acción para actualizar la fase de la tarea
            id: taskId,
            phase: newPhase
          })
        });

        const result = await response.json();
        if (result.success) {
          console.log("Tarea actualizada con éxito.");
        } else {
          console.log("Error al actualizar la tarea.");
        }
      }
    });
  });

  // Función para obtener la fase basada en la zona (lista) donde se suelta la tarea
  const getPhaseFromZone = (zone) => {
    if (zone.id === "todo-tasks") return 1;
    if (zone.id === "in-progress-tasks") return 2;
    if (zone.id === "done-tasks") return 3;
    return 1; // Por defecto
  };
})();
