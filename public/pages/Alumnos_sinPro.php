<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/Alumnos_sinPro.css" />
</head>
<body>
    <header class="header">
        <h1>Proyectos Disponibles</h1>
    </header>
    <main class="main-content">
        <div class="project-card">
            <h2>EcoInnovadores</h2>
            <p>Un proyecto colaborativo para desarrollar soluciones tecnológicas sostenibles que reduzcan el impacto ambiental. Desde apps para reciclaje inteligente hasta sistemas de gestión energética.</p>
            <button onclick="unirseProyecto('EcoInnovadores')">Solictar Unirse</button>
        </div>
        <div class="project-card">
            <h2>Cultura Digital</h2>
            <p>Un portal interactivo para preservar y difundir la cultura local mediante historias, fotos, y mapas colaborativos. Diseñado para conectar comunidades a través de la tecnología.</p>
            <button onclick="unirseProyecto('Cultura Digital')">Solictar Unirse</button>
        </div>
        <div class="project-card">
            <h2>HealthConnect</h2>
            <p>Plataforma para facilitar la comunicación entre pacientes y médicos, ofreciendo recordatorios de citas, consultas en línea y herramientas para gestionar la salud desde casa.</p>
            <button onclick="unirseProyecto('HealthConnect')">Solictar Unirse</button>
        </div>
        <div class="project-card">
            <h2>Code4Good</h2>
            <p>Comunidad abierta para enseñar programación y habilidades digitales a personas de escasos recursos. Nuestro objetivo es cerrar la brecha digital y fomentar oportunidades laborales.</p>
            <button onclick="unirseProyecto('Code4Good')">Solictar Unirse</button>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Proyectos Colectivos</p>
    </footer>

    <script>
        function unirseProyecto(proyecto) {
            alert(`Te has unido a ${proyecto}. El líder del proyecto será notificado.`);
            // Aquí se podría agregar lógica para enviar datos a un servidor
            console.log(`Datos enviados para unirse a ${proyecto}`);
        }
    </script>
</body>
</html>

