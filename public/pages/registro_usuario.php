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
      <form
        method="post"
        action="../src/server/usuario_salva.php"
        enctype="multipart/form-data"
      >
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
            <div class="campo">
              <label for="image-input">Foto de Perfil</label>
              <input
                type="file"
                id="image-input"
                name="image"
                accept="image/*"
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

          <div id="datos-alumno-div">
          <div class="campos-2" id="datos-alumno-div">
            <div class="campo">
              <label for="carrera-select">Carrera</label>
              <select name="carrera" id="carrera-select">
                <option value="">--Por favor, selecciona una carrera</option>

                <hr />

                <optgroup label="División de Ciencias Básicas">
                  <option value="Licenciatura en Física">
                    Licenciatura en Física
                  </option>
                  <option value="Licenciatura en Matemáticas">
                    Licenciatura en Matemáticas
                  </option>
                  <option value="Licenciatura en Química">
                    Licenciatura en Química
                  </option>
                  <option value="Químico Farmacéutico Biólogo">
                    Químico Farmacéutico Biólogo
                  </option>
                  <option value="Licenciatura en Ciencia de Materiales">
                    Licenciatura en Ciencia de Materiales
                  </option>
                </optgroup>

                <hr />

                <optgroup label="División de Ingenierías">
                  <option value="Ingeniería Civil">Ingeniería Civil</option>
                  <option value="Ingeniería en Alimentos y Biotecnología">
                    Ingeniería en Alimentos y Biotecnología
                  </option>
                  <option value="Ingeniería en Topografía Geomática">
                    Ingeniería en Topografía Geomática
                  </option>
                  <option value="Ingeniería Industrial">
                    Ingeniería Industrial
                  </option>
                  <option value="Ingeniería Mecánica Eléctrica">
                    Ingeniería Mecánica Eléctrica
                  </option>
                  <option value="Ingeniería Química">Ingeniería Química</option>
                  <option value="12">
                    Ingeniería en Logística y Transporte
                  </option>
                </optgroup>

                <hr />

                <optgroup
                  label="División de Tecnologías para la Integración Ciber-Humana"
                >
                  <option value="Ingeniería Informática">
                    Ingeniería Informática
                  </option>
                  <option value="Ingeniería Biomédica">
                    Ingeniería Biomédica
                  </option>
                  <option value="Ingeniería en Computación">
                    Ingeniería en Computación
                  </option>
                  <option value="Ingeniería en Comunicaciones y Electrónica">
                    Ingeniería en Comunicaciones y Electrónica
                  </option>
                  <option value="Ingeniería Fotónica">
                    Ingeniería Fotónica
                  </option>
                  <option value="Ingeniería Robótica">
                    Ingeniería Robótica
                  </option>
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

            <div class="campo">
              <label for="habilidades-textarea">Habilidades</label>
                <textarea
                  name="habilidades"
                  id="habilidades-textarea"
                  rows="5"
                ></textarea>
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
                  <option value="Departamento de Farmacobiología">
                    Departamento de Farmacobiología
                  </option>
                  <option value="Departamento de Física">
                    Departamento de Física
                  </option>
                  <option value="Departamento de Matemáticas">
                    Departamento de Matemáticas
                  </option>
                  <option value="Departamento de Química">
                    Departamento de Química
                  </option>
                </optgroup>

                <hr />

                <optgroup label="División de Ingenierías">
                  <option value="Departamento de Ingeniería Civil y Topografía">
                    Departamento de Ingeniería Civil y Topografía
                  </option>
                  <option value="Departamento de Ingeniería Industrial">
                    Departamento de Ingeniería Industrial
                  </option>
                  <option value="Departamento de Ingeniería Mecánica Eléctrica">
                    Departamento de Ingeniería Mecánica Eléctrica
                  </option>
                  <option value="Departamento de Ingeniería de Proyectos">
                    Departamento de Ingeniería de Proyectos
                  </option>
                  <option value="Departamento de Ingeniería Química">
                    Departamento de Ingeniería Química
                  </option>
                  <option value="Departamento de Madera, Celulosa y Papel">
                    Departamento de Madera, Celulosa y Papel
                  </option>
                </optgroup>

                <hr />

                <optgroup
                  label="División de Tecnologías para la Integración Ciber-Humana"
                >
                  <option value="Departamento de Bioingeniería Traslacional">
                    Departamento de Bioingeniería Traslacional
                  </option>
                  <option value="Departamento de Ciencias Computacionales">
                    Departamento de Ciencias Computacionales
                  </option>
                  <option value="Departamento de Ingeniería Electro-Fotónica">
                    Departamento de Ingeniería Electro-Fotónica
                  </option>
                  <option
                    value="Departamento de Innovación Basada en la Información y elConocimiento"
                  >
                    Departamento de Innovación Basada en la Información y
                    elConocimiento
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
