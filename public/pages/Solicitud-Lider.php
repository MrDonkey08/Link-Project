<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Líder de Proyecto - Solicitudes</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
   
</head>
<body>
    <header>
        <h1>Gestión de Solicitudes</h1>
    </header>
    <main>
        <!-- Vista de la lista de solicitudes -->
        <section class="solicitudes" id="vistaSolicitudes">
            <h2>Solicitudes Recibidas</h2>
            <ul id="listaSolicitudes">
                <li>
                    <span>Juan Pérez - ID: 123</span>
                    <button class="verSolicitud" data-id="123">Ver Detalles</button>
                </li>
                <li>
                    <span>Maria López - ID: 124</span>
                    <button class="verSolicitud" data-id="124">Ver Detalles</button>
                </li>
            </ul>
        </section>

        <!-- Vista de detalles de una solicitud -->
        <section class="detalle" id="vistaDetalle">
            <h2>Detalles de la Solicitud</h2>
            <p><strong>Nombre:</strong> <span id="nombreAlumno">-</span></p>
            <p><strong>ID:</strong> <span id="idAlumno">-</span></p>
            <p><strong>Proyecto solicitado:</strong> <span id="proyectoAlumno">-</span></p>
            <section class="acciones">
                <button class="aceptar" id="btnAceptar">Aceptar</button>
                <button class="rechazar" id="btnRechazar">Rechazar</button>
                <button id="btnVolver">Volver</button>
            </section>
        </section>
    </main>

    <script>
        // Simulación de datos
        const solicitudes = {
            123: { nombre: "Juan Pérez", proyecto: "Desarrollo de Sistema Web" },
            124: { nombre: "Maria López", proyecto: "Aplicación Móvil de Gestión" }
        };

        // Elementos
        const vistaSolicitudes = document.getElementById("vistaSolicitudes");
        const vistaDetalle = document.getElementById("vistaDetalle");
        const nombreAlumno = document.getElementById("nombreAlumno");
        const idAlumno = document.getElementById("idAlumno");
        const proyectoAlumno = document.getElementById("proyectoAlumno");
        const btnAceptar = document.getElementById("btnAceptar");
        const btnRechazar = document.getElementById("btnRechazar");
        const btnVolver = document.getElementById("btnVolver");

        // Mostrar detalles de una solicitud
        document.querySelectorAll(".verSolicitud").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.dataset.id;
                const solicitud = solicitudes[id];
                if (solicitud) {
                    nombreAlumno.textContent = solicitud.nombre;
                    idAlumno.textContent = id;
                    proyectoAlumno.textContent = solicitud.proyecto;

                    vistaSolicitudes.style.display = "none";
                    vistaDetalle.style.display = "block";
                }
            });
        });

        // Botones aceptar/rechazar
        btnAceptar.addEventListener("click", () => {
            alert("Correo enviado: Solicitud aceptada.");
            volverALista();
        });

        btnRechazar.addEventListener("click", () => {
            alert("Correo enviado: Solicitud rechazada.");
            volverALista();
        });

        // Volver a la lista
        btnVolver.addEventListener("click", volverALista);

        function volverALista() {
            vistaDetalle.style.display = "none";
            vistaSolicitudes.style.display = "block";
        }
    </script>
</body>
</html>
