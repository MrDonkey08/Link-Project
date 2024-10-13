const datos_alumno = document.getElementById("datos-alumno-div") as HTMLElement
const datos_asesor = document.getElementById("datos-asesor-div") as HTMLElement
const tipo_de_usuario = document.getElementById(
  "tipo-de-usuario-select"
) as HTMLSelectElement

toogle_display()

// Event Listeners

tipo_de_usuario.addEventListener("change", toogle_display)

// Funciones

function toogle_display() {
  if (tipo_de_usuario.value === "") {
    datos_alumno.style.display = "none"
    datos_asesor.style.display = "none"
  } else if (tipo_de_usuario.value === "1") {
    datos_asesor.style.display = "none"
    datos_alumno.style.display = "block"
  } else {
    datos_asesor.style.display = "block"
    datos_alumno.style.display = "none"
  }
}
