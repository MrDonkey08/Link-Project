function filtrarProyectos() {
    const input = document.getElementById("search");
    const filter = input.value.toLowerCase();
    const projects = document.querySelectorAll(".project-card");
  
    projects.forEach((project) => {
      const name = project.querySelector("h3").textContent.toLowerCase();
      if (name.includes(filter)) {
        project.style.display = "block"; // Mostrar si coincide
      } else {
        project.style.display = "none"; // Ocultar si no coincide
      }
    });
  }
  
  // Asigna el evento al botón
  document.getElementById("search-btn").addEventListener("click", filtrarProyectos);
  
  document.getElementById("search").addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
      filtrarProyectos();
    }
  });
  
  // Mostrar alerta al hacer clic en "Crear Proyecto"
  /*const crearProyectoBtn = document.querySelector(".btn");
  if (crearProyectoBtn) {
    crearProyectoBtn.addEventListener("click", () => {
      alert("Redirigiendo a la página para crear un proyecto.");
    });
  }*/
  
  // Efecto de resaltar proyecto al pasar el mouse
  document.querySelectorAll(".project-card").forEach((card) => {
    card.addEventListener("mouseenter", () => {
      card.style.boxShadow = "0px 4px 15px rgba(0, 0, 0, 0.2)";
    });
    card.addEventListener("mouseleave", () => {
      card.style.boxShadow = "none";
    });
  });
  