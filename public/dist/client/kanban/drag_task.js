"use strict"
;(() => {
	const draggables = document.querySelectorAll(".task")
	const droppables = document.querySelectorAll(".tasks")
	// Replacing forEach with for...of for draggables
	for (const task of draggables) {
		task.addEventListener("dragstart", () => {
			task.classList.add("is-dragging")
		})
		task.addEventListener("dragend", () => {
			task.classList.remove("is-dragging")
		})
	}
	// Replacing forEach with for...of for droppables
	for (const zone of droppables) {
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
	}
	// Replacing forEach with for...of inside insertAboveTask
	const insertAboveTask = (zone, mouseY) => {
		const els = zone.querySelectorAll(".task:not(.is-dragging)")
		let closest_task = null
		let closest_offset = Number.NEGATIVE_INFINITY
		for (const task of els) {
			const { top } = task.getBoundingClientRect()
			const offset = mouseY - top
			if (offset < 0 && offset > closest_offset) {
				closest_offset = offset
				closest_task = task
			}
		}
		return closest_task
	}
})()
