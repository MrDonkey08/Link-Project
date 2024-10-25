;(() => {
	const draggables = document.querySelectorAll<HTMLElement>(".task")
	const droppables = document.querySelectorAll<HTMLElement>(".tasks")

	draggables.forEach((task) => {
		task.addEventListener("dragstart", () => {
			task.classList.add("is-dragging")
		})
		task.addEventListener("dragend", () => {
			task.classList.remove("is-dragging")
		})
	})

	droppables.forEach((zone) => {
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
	})

	const insertAboveTask = (
		zone: HTMLElement,
		mouseY: number
	): HTMLElement | null => {
		const els = zone.querySelectorAll<HTMLElement>(".task:not(.is-dragging)")

		let closest_task: HTMLElement | null = null
		let closest_offset = Number.NEGATIVE_INFINITY

		els.forEach((task: HTMLElement) => {
			const { top } = task.getBoundingClientRect()
			const offset = mouseY - top

			if (offset < 0 && offset > closest_offset) {
				closest_offset = offset
				closest_task = task
			}
		})

		return closest_task
	}
})()
