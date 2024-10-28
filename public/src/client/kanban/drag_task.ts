;(() => {
	const draggables = document.querySelectorAll<HTMLElement>(".task-box")
	const droppables = document.querySelectorAll<HTMLElement>(".tasks")

	for (const task_box of draggables) {
		task_box.addEventListener("dragstart", () => {
			task_box.classList.add("is-dragging")
		})
		task_box.addEventListener("dragend", () => {
			task_box.classList.remove("is-dragging")
		})
	}

	for (const zone of droppables) {
		zone.addEventListener("dragover", (e: DragEvent) => {
			e.preventDefault()

			const bottom_task = insertAboveTask(zone, e.clientY)
			const current_task = document.querySelector<HTMLElement>(".is-dragging")

			if (current_task) {
				if (!bottom_task) {
					zone.appendChild(current_task)
				} else {
					zone.insertBefore(current_task, bottom_task)
				}
			}
		})
	}

	const insertAboveTask = (
		zone: HTMLElement,
		mouseY: number
	): HTMLElement | null => {
		const els = zone.querySelectorAll<HTMLElement>(
			".task-box:not(.is-dragging)"
		)

		let closest_task: HTMLElement | null = null
		let closest_offset = Number.NEGATIVE_INFINITY

		for (const task_box of els) {
			const { top } = task_box.getBoundingClientRect()
			const offset = mouseY - top

			if (offset < 0 && offset > closest_offset) {
				closest_offset = offset
				closest_task = task_box
			}
		}

		return closest_task
	}
})()
