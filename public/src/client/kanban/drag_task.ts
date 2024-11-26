;(() => {
    const droppables = document.querySelectorAll<HTMLElement>(".tasks");

    for (const zone of droppables) {
        zone.addEventListener("dragover", (e: DragEvent) => {
            e.preventDefault();

            const bottomTask = insertAboveTask(zone, e.clientY);
            const currentTask = document.querySelector<HTMLElement>(".is-dragging");

            if (currentTask) {
                if (!bottomTask) {
                    zone.appendChild(currentTask);
                } else {
                    zone.insertBefore(currentTask, bottomTask);
                }
            }
        });

        zone.addEventListener("drop", async () => {
            const currentTask = document.querySelector<HTMLElement>(".is-dragging");

            if (currentTask) {
                const taskId = currentTask.dataset.id;
                const newPhase = getPhaseFromListId(zone.closest<HTMLElement>(".list")?.id || "");

                // Actualizar la fase en la base de datos
                const response = await fetch("../src/server/kanban_BACK.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "update", id: taskId, phase: newPhase }),
                });

                const result = await response.json();
                if (!result.success) {
                    console.error("Error al actualizar la fase:", result.message);
                }
            }
        });
    }

    const insertAboveTask = (
        zone: HTMLElement,
        mouseY: number
    ): HTMLElement | null => {
        const els = zone.querySelectorAll<HTMLElement>(".task-box:not(.is-dragging)");

        let closestTask: HTMLElement | null = null;
        let closestOffset = Number.NEGATIVE_INFINITY;

        for (const taskBox of els) {
            const { top } = taskBox.getBoundingClientRect();
            const offset = mouseY - top;

            if (offset < 0 && offset > closestOffset) {
                closestOffset = offset;
                closestTask = taskBox;
            }
        }

        return closestTask;
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



