<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Alumnos</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/Solicitudes-Lider.css" />
    <script>
        function abrirSolicitud(id, nombre, correo, mensaje) {
            const nuevaVentana = window.open('', '_blank', 'width=500,height=400');
            nuevaVentana.document.write(`
                <html>
                <head>
                    <title>Detalle de la Solicitud</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
                        h2 { color: #143c8c; }
                        button { padding: 10px 20px; margin: 10px; cursor: pointer; border: none; }
                        .btn-aceptar { background-color: #1f4077; color: white; }
                        .btn-rechazar { background-color: #6487b1; color: white; }
                    </style>
                </head>
                <body>
                    <h2>Solicitud de ${nombre}</h2>
                    <p><strong>ID:</strong> ${id}</p>
                    <p><strong>Correo:</strong> ${correo}</p>
                    <p><strong>Mensaje:</strong> ${mensaje}</p>
                    <button class="btn-aceptar" onclick="alert('Correo enviado al alumno: Solicitud Aceptada')">Aceptar</button>
                    <button class="btn-rechazar" onclick="alert('Correo enviado al alumno: Solicitud Rechazada')">Rechazar</button>
                </body>
                </html>
            `);
        }
    </script>
</head>
<body>
    <header>
        <h1>Solicitudes de Alumnos</h1>
    </header>
    <main>
        <ul class="solicitudes">
            <li>
                <button onclick="abrirSolicitud(1, 'Juan Pérez', 'juan.perez@example.com', 'Me interesa participar en el proyecto X')">Solicitud de Juan Pérez</button>
            </li>
            <li>
                <button onclick="abrirSolicitud(2, 'María Gómez', 'maria.gomez@example.com', 'Estoy buscando equipo para el proyecto Y')">Solicitud de María Gómez</button>
            </li>
            <li>
                <button onclick="abrirSolicitud(3, 'Carlos López', 'carlos.lopez@example.com', 'Quisiera ser considerado para el proyecto Z')">Solicitud de Carlos López</button>
            </li>
        </ul>
    </main>
</body>
</html>
