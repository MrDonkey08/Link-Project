"use strict"
;(() => {
	const lists = document.querySelectorAll(".list")
	lists.forEach((list) => {
		const form = list.querySelector(".add-task-form")
		const task = list.querySelector(".tasks")
		if (form) {
			form.addEventListener("submit", (e) => {
				e.preventDefault()
				const input = form.querySelector(".new-task-input")
				if (input instanceof HTMLInputElement) {
					const new_task = document.createElement("p")
					new_task.classList.add("task")
					new_task.setAttribute("draggable", "true")
					new_task.innerText = input.value
					new_task.addEventListener("dragstart", () => {
						new_task.classList.add("is-dragging")
					})
					new_task.addEventListener("dragend", () => {
						new_task.classList.remove("is-dragging")
					})
					task === null || task === void 0 ? void 0 : task.appendChild(new_task)
				}
			})
		}
	})
})()
