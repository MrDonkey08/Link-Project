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

    session_start(); 
    $id_estudiante = $_SESSION['IDUser']; 

    $check_estudiante_query = "SELECT 1 FROM estudiante WHERE id_estudiante = $1";
    $check_result = pg_query_params($con, $check_estudiante_query, array($id_estudiante));

    if (pg_num_rows($check_result) == 0) {
        // Si el estudiante no existe, mostrar un mensaje de error
        $mensaje = "El estudiante con id_estudiante = $id_estudiante no existe en la base de datos.";
        $clase = "error";
    } else {
        // El id_estudiante existe, proceder con la creación del proyecto
        $logo = null;

        // Ingreso del nuevo proyecto
        $query = "INSERT INTO proyecto (nombre, descripcion, area, cupos, activo, conocimientos_requeridos, nivel_de_innovacion)
                  VALUES ($1, $2, $3, $4, TRUE, $5, $6) RETURNING id";
        
        $result = pg_query_params($con, $query, array($nombre, $descripcion, $area, $cupos, $conocimientos_requeridos, $nivel_de_innovacion));

        if ($result) {
            // Obtener el id del nuevo proyecto insertado
            $row = pg_fetch_assoc($result);
            $id_proyecto = $row['id'];

            // Insertar en la tabla integrante con id_estudiante
            $insert_integrante = "INSERT INTO integrante (id_estudiante, id_proyecto, lider) 
                                  VALUES ($1, $2, TRUE)"; // Suponiendo que el estudiante es el líder por defecto
            $insert_result = pg_query_params($con, $insert_integrante, array($id_estudiante, $id_proyecto));

            if ($insert_result) {
                $mensaje = "Proyecto creado con éxito y asignado al estudiante.";
                $clase = "success";
            } else {
                $mensaje = "Proyecto creado, pero hubo un error al asignarlo al estudiante.";
                $clase = "error";
            }
        } else {
            $mensaje = "Error al crear el proyecto.";
            $clase = "error";
        }
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
  <body class="center">
    <section class="container">
      <h1>Crear Proyecto</h1>
      <?php if (isset($mensaje)): ?>
        <div class="<?= $clase; ?>"><?= $mensaje; ?></div>
      <?php endif; ?>

      <form method="post" action="" enctype="multipart/form-data">
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
                placeholder="Número de cupos (máximo 2)"
                min="1"
                max="2"
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
              <input type="checkbox" id="activo-input" name="activo" checked />
              <label for="activo-input">Activo</label>
            </div>
          </div>
          <button type="submit">Crear Proyecto</button>
        </fieldset>
      </form>

      <div class=".button-container">
        <a href="inicio.php" class="btn">Regresar</a>
      </div>
    </section>
  </body>
</html>
