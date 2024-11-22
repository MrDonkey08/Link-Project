<?php
require '../src/server/conecta.php';
$con = conecta();
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Registro de Usuario</title>

    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />

    <script async src="../dist/client/registro.js"></script>
  </head>

  <body class="center">
    <section class="container">
      <h1>Registro de Usuario</h1>
      <form method="post" action="../src/server/registro_usuario.php">
        <fieldset>
          <h2>Datos Personales</h2>

          <div class="campos-3">
            <div class="campo">
              <label for="nombre-input">Nombre(s)</label>
              <input
                type="text"
                id="nombre-input"
                name="nombre"
                placeholder="Nombre(s)"
                required
              />
            </div>

            <div class="campo">
              <label for="apellido-paterno-input">Apellido Paterno</label>
              <input
                type="text"
                id="apellido-paterno-input"
                name="apellido-paterno"
                placeholder="Primer Apellido"
                required
              />
            </div>

            <div class="campo">
              <label for="apellido-materno-input">Apellido Materno</label>
              <input
                type="text"
                id="apellido-materno-input"
                name="apellido-materno"
                placeholder="Segundo Apellido"
                required
              />
            </div>

            <div class="campo">
              <label for="contacto-input">Télefono</label>
              <input
                type="tel"
                id="contacto-input"
                name="contacto"
                placeholder="12-3456-7890"
                pattern="(\d{2}([\- ]?\d{4}){2}|(\d{3}[\- ]){2}\d{4})"
                title='El número telefónico debe ser de 10 dígitos,
                preferentemente separados con guiones "-" o espacios " ", tal
                como se muestra en el ejemplo'
                required
              />
            </div>
          </div>

          <h2>Datos Escolares</h2>

          <div class="campo">
            <label for="tipo-de-usuario-select">Tipo de Usuario</label>
            <select name="tipo-de-usuario" id="tipo-de-usuario-select" required>
              <option value="">
                --Por favor, selecciona un tipo de usuario
              </option>
              <option value="1">Estudiante</option>
              <option value="2">Profesor</option>
            </select>
          </div>

          <div class="campos-2" id="datos-alumno-div">
            <div class="campo">
              <label for="carrera-select">Carrera</label>
              <select name="carrera" id="carrera-select">
                <option value="">--Por favor, selecciona una carrera</option>

                <hr />

                <optgroup label="División de Ciencias Básicas">
                  <option value="1">Licenciatura en Física</option>
                  <option value="2">Licenciatura en Matemáticas</option>
                  <option value="3">Licenciatura en Química</option>
                  <option value="4">Químico Farmacéutico Biólogo</option>
                  <option value="5">
                    Licenciatura en Ciencia de Materiales
                  </option>
                </optgroup>

                <hr />

                <optgroup label="División de Ingenierías">
                  <option value="6">Ingeniería Civil</option>
                  <option value="7">
                    Ingeniería en Alimentos y Biotecnología
                  </option>
                  <option value="8">Ingeniería en Topografía Geomática</option>
                  <option value="9">Ingeniería Industrial</option>
                  <option value="10">Ingeniería Mecánica Eléctrica</option>
                  <option value="11">Ingeniería Química</option>
                  <option value="12">
                    Ingeniería en Logística y Transporte
                  </option>
                </optgroup>

                <hr />

                <optgroup
                  label="División de Tecnologías para la Integración Ciber-Humana"
                >
                  <option value="13">Ingeniería Informática</option>
                  <option value="14">Ingeniería Biomédica</option>
                  <option value="15">Ingeniería en Computación</option>
                  <option value="16">
                    Ingeniería en Comunicaciones y Electrónica
                  </option>
                  <option value="17">Ingeniería Fotónica</option>
                  <option value="18">Ingeniería Robótica</option>
                </optgroup>
              </select>
            </div>
            <div class="campo">
              <label for="codigo-estudiante-input">Código de Estudiante</label>
              <input
                type="text"
                id="codigo-estudiante-input"
                name="codigo-estudiante"
                placeholder="123456789"
                pattern="\d{9}"
                title="El código debe contener 9 dígitos"
              />
            </div>
          </div>

          <div class="campos-2" id="datos-asesor-div">
            <div class="campo">
              <label for="departamento-select">Departamento</label>
              <select name="departamento" id="departamento-select">
                <option value="">
                  --Por favor, selecciona un departamento
                </option>

                <optgroup label="División de Ciencias Básicas">
                  <option value="1">Departamento de Farmacobiología</option>
                  <option value="2">Departamento de Física</option>
                  <option value="3">Departamento de Matemáticas</option>
                  <option value="4">Departamento de Química</option>
                </optgroup>

                <hr />

                <optgroup label="División de Ingenierías">
                  <option value="5">
                    Departamento de Ingeniería Civil y Topografía
                  </option>
                  <option value="6">
                    Departamento de Ingeniería Industrial
                  </option>
                  <option value="7">
                    Departamento de Ingeniería Mecánica Eléctrica
                  </option>
                  <option value="8">
                    Departamento de Ingeniería de Proyectos
                  </option>
                  <option value="9">Departamento de Ingeniería Química</option>
                  <option value="10">
                    Departamento de Madera, Celulosa y Papel
                  </option>
                </optgroup>

                <hr />

                <optgroup
                  label="División de Tecnologías para la Integración Ciber-Humana"
                >
                  <option value="11">
                    Departamento de Bioingeniería Traslacional
                  </option>
                  <option value="12">
                    Departamento de Ciencias Computacionales
                  </option>
                  <option value="13">
                    Departamento de Ingeniería Electro-Fotónica
                  </option>
                  <option value="14">
                    Departamento de Innovación Basada en la Información y el
                    Conocimiento
                  </option>
                </optgroup>
              </select>
            </div>

            <div class="campo">
              <label for="codigo-asesor-input">Código de Asesor</label>
              <input
                type="text"
                id="codigo-asesor-input"
                name="codigo-asesor"
                placeholder="123456789"
                minlength="9"
                maxlength="9"
                pattern="\d{5,9}"
                title="El código debe contener entre 5 y 9 dígitos"
              />
            </div>
          </div>

          <h2>Datos de Inicio de Sesión</h2>

          <div class="campos-3">
            <div class="campo">
              <label for="email-input">Correo Electrónico</label>
              <input
                type="email"
                id="email-input"
                name="email"
                placeholder="correo@alumnos.udg.mx"
                pattern="\w[\w\.]{0,30}@(alumnos|academicos)\.udg\.mx"
                title="El correo debe ser institucional, perteneciente a la UDG"
                autocomplete="on"
                required
              />
            </div>

            <div class="campo">
              <label for="password-input">Contraseña</label>
              <input
                type="password"
                id="password-input"
                name="password"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
                title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
                required
              />
            </div>

            <div class="campo">
              <label for="password-input-2">Confirmar Contraseña</label>
              <input
                type="password"
                id="password-input-2"
                name="password-2"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
                title='La contraseña debe ser de una longitud de 8-40 caracteres
                y contener al menos un dígito, una mayúscula, una minúscula y un
                carácter especial "/*+&..."'
                required
              />
            </div>
          </div>
          <button type="submit">Enviar</button>
        </fieldset>
      </form>
    </section>
  </body>
</html>
