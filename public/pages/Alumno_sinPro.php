<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumno</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/Alumno_sinPro.css" />
</head>
<body>
    <div class="container">
        <h1>Registro de Alumno</h1>
        <form action="process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="codigo">Código de estudiante:</label>
                <input type="text" id="codigo" name="codigo" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo institucional:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contacto">Número de contacto:</label>
                <input type="tel" id="contacto" name="contacto" required>
            </div>
            <div class="form-group">
                <label for="carrera">Carrera:</label>
                <input type="text" id="carrera" name="carrera" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto (PNG):</label>
                <input type="file" id="foto" name="foto" accept="image/png" required>
            </div>
            <div class="form-group">
                <label for="habilidades">Habilidades:</label>
                <textarea id="habilidades" name="habilidades" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn">Enviar</button>
        </form>
    </div>
</body>
</html>
