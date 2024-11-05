<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Registro de Asesor</title>

    <link rel="stylesheet" href="../assets/styles/style.css" />

    <script async src="../dist/client/registro.js"></script>
  </head>

  <body>
    <h1>Registro de Asesor</h1>
    <form class="formulario" method="post" action="">
      <fieldset>
        <div class="contenedor-campos">
          <h2>Datos Personales</h2>
          <div class="campo">
            <label for="nombre-input">Nombre(s)</label>
            <input class="input-text"
              type="text"
              id="nombre-input"
              name="nombre"
              placeholder="Nombre(s)"
              required
            />
        </div>

        <div class="campo">
          <label for="apellido-paterno-input">Apellido Paterno</label>
          <input class="input-text"
            type="text"
            id="apellido-paterno-input"
            name="apellido-paterno"
            placeholder="Primer Apellido"
            required
          />
        </div>

        <div class="campo">
          <label for="apellido-materno-input">Apellido Materno</label>
          <input class="input-text"
            type="text"
            id="apellido-materno-input"
            name="apellido-materno"
            placeholder="Segundo Apellido"
            required
          />
        </div>

        <div class="campo">
          <label for="contacto-input">Télefono</label>
          <input class="input-text"
            type="tel"
            id="contacto-input"
            name="contacto"
            placeholder="12-3456-7890"
            pattern="\d{2}(-\d{4}){2}"
            required
          />
        </div>

          <h2>Datos Escolares</h2>
    
          </select>

          <div class="campo" id="datos-alumno-div">
            <label for="codigo-asesor-input">Código de Asesor</label>
            <input class="input text"
              type="text"
              id="codigo-asesor-input"
              name="codigo-asesor"
              placeholder="123456789"
              pattern="\d{9}"
              required
            />

          </div>

          <div class="campo" id="datos-asesor-div">

            <label for="departamento">Departamento</label>
            <select name="departamento" id="departamento-select">
              <option value="">--Por favor, selecciona un departamento</option>
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
                <option value="6">Departamento de Ingeniería Industrial</option>
                <option value="7">
                  Departamento de Ingeniería Mecánica Eléctrica
                </option>
                <option value="8">Departamento de Ingeniería de Proyectos</option>
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

          <h2>Datos de Inicio de Sesión</h2>

          <div class="campo">
            <label for="email-input">Correo Electrónico</label>
            <input class="input-text"
              type="email"
              id="email-input"
              name="email"
              placeholder="correo@dominio.com"
              pattern="\w[\w\.]{0,30}@[\w\.]+\.[a-z]{2,5}"
              required
            />
          </div>

          <div class="campo">
            <label for="password-input">Contraseña</label>
            <input class="input-text"
              type="password"
              id="password-input"
              name="password"
              pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,40}"
              title='La contraseña debe ser de una longitud de 8-40 caracteres y contener al menos un dígito, una mayúscula, una minúscula y un carácter especial "/*+&..."'
              required
            />
          </div>
        </fieldset>
      </div>
      <div class="alinear-derecha flex"></div>
        <button class="boton" type="submit">Enviar</button>
      </div>
    </form>
  </body>
</html>
