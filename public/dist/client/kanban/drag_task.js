"use strict"
;(() => {
	const draggables = document.querySelectorAll(".task")
	const droppables = document.querySelectorAll(".tasks")
	draggables.forEach((task) => {
		task.addEventListener("dragstart", () => {
			task.classList.add("is-dragging")
		})
		task.addEventListener("dragend", () => {
			task.classList.remove("is-dragging")
		})
	})
	droppables.forEach((zone) => {
		zone.addEventListener("dragover", (e) => {
			e.preventDefault()
			const bottom_task = insertAboveTask(zone, e.clientY)
			const current_task = document.querySelector(".is-dragging")
			if (current_task) {
				if (!bottom_task) {
					zone.appendChild(current_task)
				} else {
					zone.insertBefore(current_task, bottom_task)
				}
			}
		})
	})
	const insertAboveTask = (zone, mouseY) => {
		const els = zone.querySelectorAll(".task:not(.is-dragging)")
		let closest_task = null
		let closest_offset = Number.NEGATIVE_INFINITY
		els.forEach((task) => {
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
