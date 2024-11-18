<?php
require '../src/server/conecta.php';
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $area = $_POST['area'];
    $cupos = $_POST['cupos'];
    $conocimientos_requeridos = $_POST['conocimientos_requeridos'];
    $nivel_de_innovacion = $_POST['nivel_de_innovacion'];


    $logo = null;
    if (isset($_FILES['logo']['tmp_name'])) {
        $logo = file_get_contents($_FILES['logo']['tmp_name']);
    }

    $query = "INSERT INTO proyecto (nombre, descripcion, area, cupos, activo, conocimientos_requeridos, nivel_de_innovacion, logo)
              VALUES ('$nombre', '$descripcion', '$area', $cupos, TRUE, '$conocimientos_requeridos', '$nivel_de_innovacion', $1)";


    $result = pg_query_params($con, $query, array($logo));


    if ($result) {
        echo "Proyecto creado con éxito.";
    } else {
        echo "Error al crear el proyecto.";
    }
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear Proyecto</title>

    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />

    <script async src="../dist/client/crear_proyecto.js"></script>
  </head>
  <body>
    <h1>Crear Proyecto</h1>
    <form method="post" action="">
      <fieldset>
        <h2>Datos del Proyecto</h2>

        <div class="campos-3">
          <div class="campo">
            <label for="nombre-input">Nombre del Proyecto</label>
            <input
              type="text"
              id="nombre-input"
              name="nombre"
              placeholder="Nombre del Proyecto"
              required
            />
          </div>

          <div class="campo">
            <label for="area-input">Área del Proyecto</label>
            <input
              type="text"
              id="area-input"
              name="area"
              placeholder="Área del Proyecto"
              required
            />
          </div>

          <div class="campo">
            <label for="cupos-input">Cupos Disponibles</label>
            <input
              type="number"
              id="cupos-input"
              name="cupos"
              placeholder="Número de cupos (máximo 3)"
              min="1"
              max="3"
              required
            />
          </div>
        </div>

        <div class="campos-2">
          <div class="campo">
            <label for="descripcion-input">Descripción</label>
            <textarea
              id="descripcion-input"
              name="descripcion"
              placeholder="Descripción del proyecto"
              required
            ></textarea>
          </div>

          <div class="campo">
            <label for="conocimientos-input">Conocimientos Requeridos</label>
            <textarea
              id="conocimientos-input"
              name="conocimientos_requeridos"
              placeholder="Conocimientos necesarios para el proyecto"
            ></textarea>
          </div>
        </div>

        <div class="campos-3">
          <div class="campo">
            <label for="innovacion-input">Nivel de Innovación</label>
            <select name="nivel_de_innovacion" id="innovacion-input" required>
              <option value="">--Selecciona el nivel de innovación</option>
              <option value="Bajo">Bajo</option>
              <option value="Medio">Medio</option>
              <option value="Alto">Alto</option>
            </select>
          </div>

          <div class="campo">
            <label for="logo-input">Logo del Proyecto</label>
            <input type="file" id="logo-input" name="logo" accept="image/*" />
          </div>

          <div class="campo">
            <input type="checkbox" id="activo-input" name="activo" checked />
            <label for="activo-input">Activo</label>
          </div>
        </div>
        <button type="submit">Crear Proyecto</button>
      </fieldset>
    </form>
  </body>
</html>
