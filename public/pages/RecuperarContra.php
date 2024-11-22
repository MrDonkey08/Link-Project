<?php
require '../src/server/conecta.php';
$con = conecta();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/small_form.css" />

  </head>
  <body>
    <div class="container">
      <h1>Recuperar Contraseña</h1>
      <form id="recover-form">
        <div id="email-section">
          <input
            type="email"
            id="email"
            placeholder="Introduce tu correo"
            required
          />
          <button type="button" onclick="sendCode()">Enviar Código</button>
        </div>
        <div id="code-section" class="hidden">
          <input
            type="text"
            id="code"
            placeholder="Introduce el código"
            maxlength="4"
            required
          />
          <button type="button" onclick="verifyCode()">Verificar Código</button>
        </div>
        <div id="password-section" class="hidden">
          <input
            type="password"
            id="new-password"
            placeholder="Nueva Contraseña"
            disabled
            required
          />
          <input
            type="password"
            id="confirm-password"
            placeholder="Confirmar Contraseña"
            disabled
            required
          />
          <button
            type="button"
            onclick="updatePassword()"
            disabled
            id="update-btn"
          >
            Actualizar Contraseña
          </button>
        </div>
      </form>
    </div>

    <script>
      let verificationCode = ""

      function sendCode() {
        const email = document.getElementById("email").value
        if (!email) {
          alert("Por favor, introduce un correo electrónico válido.")
          return
        }

        verificationCode = Math.floor(1000 + Math.random() * 9000).toString()
        alert(`Código enviado a ${email}: ${verificationCode}`) // Simulación del envío del correo
        document.getElementById("email-section").classList.add("hidden")
        document.getElementById("code-section").classList.remove("hidden")
      }

      function verifyCode() {
        const userCode = document.getElementById("code").value
        const newPasswordField = document.getElementById("new-password")
        const confirmPasswordField = document.getElementById("confirm-password")
        const updateButton = document.getElementById("update-btn")

        if (userCode === verificationCode) {
          alert("Código verificado correctamente.")
          document.getElementById("password-section").classList.remove("hidden")
          newPasswordField.disabled = false
          confirmPasswordField.disabled = false
          updateButton.disabled = false
        } else {
          alert("El código es incorrecto.")
          newPasswordField.disabled = true
          confirmPasswordField.disabled = true
          updateButton.disabled = true
        }
      }

      function updatePassword() {
        const newPassword = document.getElementById("new-password").value
        const confirmPassword =
          document.getElementById("confirm-password").value

        if (!newPassword || !confirmPassword) {
          alert("Por favor, rellena todos los campos.")
          return
        }

        if (newPassword !== confirmPassword) {
          alert("Las contraseñas no coinciden.")
          return
        }

        alert("Contraseña actualizada con éxito.")
        // Aquí puedes enviar la contraseña actualizada al servidor.
      }
    </script>
  </body>
</html>

