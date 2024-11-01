<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html>
  <head>
    <title>Registro Proyectos</title>
    <link rel="stylesheet" href="../assets/styles/registro_proyectos.css" />
  </head>
  <body>
    <!----------------------------------------- Cuadro superior de la pagina -->
    <div class="Cuadro-Tiulo">
      <div class="IconMenu" id="MenuIcon">&#9776;</div>
    </div>
    <!-------------------------------------------- Cuadro form para registro -->
    <div class="container">
      <h1>Registro de Proyecto</h1>
      <!-- ----------------------------------------- Requisitos del registro -->
      <form id="registroProyect" method="post" enctype="multipart/form-data">
        <input
          type="text"
          id="nameProyect"
          name="nombreProyecto"
          placeholder="Nombre del proyecto"
          required
        />
        <input
          type="text"
          id="areaProyect"
          name="areaProyecto"
          placeholder="Area del proyecto"
          required
        />
        <input
          type="text"
          id="description"
          name="descripción"
          placeholder="Descripción del proyecto"
          required
        />

        <div class="Selectores">
          <label for="numInt">Número de integrantes:</label>
          <select class="numInt" id="teanNumber" name="numIntegrantes">
            <option value="">Seleccionar</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
        <div class="Selectores">
          <label for="EstadoProyect">Estado el proyecto:</label>
          <select class="EstadoProyect" id="status" name="estado">
            <option value="">Seleccionar</option>
            <option value="1">Privado</option>
            <option value="2">Publico</option>
          </select>
        </div>
        <input
          type="text"
          id="advisor"
          name="asesor"
          placeholder="Asesor del proyecto"
          required
        />
        <input
          type="text"
          id="skills"
          name="hablilidades"
          placeholder="Conocimientos requeridos"
          required
        />
        <input
          type="email"
          id="teamEmail"
          name="correoEquipo"
          placeholder="Correo de integrantes"
          onblur="validarCorreo();"
        />

        <input
          type="submit"
          value="Listo"
          name="submit"
          onclick="return validarFormulario();"
        />
      </form>
    </div>

    <!-- ------------------------------ Validación (función) mediante Jquery -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
      function validarFormulario() {
        const nombreProyecto = document.getElementById("nameProyect").value
        const areaProyecto = document.getElementById("areaProyect").value
        const descripcion = document.getElementById("description").value
        const numIntegrantes = document.getElementById("teanNumber").value
        const estado = document.getElementById("status").value
        const habilidades = document.getElementById("skills").value
        const correoEquipo = document.getElementById("teamEmail").value

        // Validar que todos los campos estén completos
        if (
          nombreProyecto === "" ||
          areaProyecto === "" ||
          descripcion === "" ||
          numIntegrantes === "" ||
          estado === "" ||
          habilidades === "" ||
          correoEquipo === ""
        ) {
          alert(
            "Faltan campos por llenar. Por favor, completa todos los campos."
          )
          return false // Evita que se envíe el formulario si faltan campos.
        } else {
          return true
        }
      }
    </script>
  </body>
</html>
