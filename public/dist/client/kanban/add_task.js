"use strict"
;(() => {
	const lists = document.querySelectorAll(".list")
	for (const list of lists) {
		const form = list.querySelector(".add-task-form")
		const task_container = list.querySelector(".tasks")
		if (form) {
			form.addEventListener("submit", (e) => {
				e.preventDefault()
				const input = form.querySelector(".new-task-input")
				if (input instanceof HTMLInputElement) {
					const task_box = document.createElement("div")
					task_box.classList.add("task-box")
					const new_task = document.createElement("p")
					new_task.classList.add("task")
					new_task.setAttribute("draggable", "true")
					new_task.innerText = input.value
					task_box.addEventListener("dragstart", () => {
						task_box.classList.add("is-dragging")
					})
					task_box.addEventListener("dragend", () => {
						task_box.classList.remove("is-dragging")
					})
					const delete_button = document.createElement("button")
					delete_button.innerText = "Eliminar"
					delete_button.addEventListener("click", () => {
						task_box.remove()
					})
					// Append elements to the task-box
					task_box.appendChild(new_task)
					task_box.appendChild(delete_button)
					// Append the new task-box to the task container
					task_container === null || task_container === void 0
						? void 0
						: task_container.appendChild(task_box)
					// Clear input field
					input.value = ""
				}
			})
		}
	}
})()
