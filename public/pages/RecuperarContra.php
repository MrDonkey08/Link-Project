<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
  <link rel="stylesheet" href="../assets/styles/normalize.css" />
  <link rel="stylesheet" href="../assets/styles/RecuperarContra.css" />
</head>
<body>
  <div class="container">
    <h1>Recuperar Contraseña</h1>
    <div id="email-section">
      <input type="email" id="email" placeholder="Introduce tu correo" required>
      <button onclick="sendToken()">Enviar Token</button>
    </div>
    <div id="code-section" class="hidden">
      <input type="text" id="token" placeholder="Introduce el token" maxlength="4" required>
      <button onclick="verifyToken()">Verificar Token</button>
    </div>
    <div id="password-section" class="hidden">
      <input type="password" id="new-password" placeholder="Nueva Contraseña" disabled required>
      <input type="password" id="confirm-password" placeholder="Confirmar Contraseña" disabled required>
      <button onclick="updatePassword()" disabled id="update-btn">Actualizar Contraseña</button>
    </div>
  </div>

  <script>
    async function sendToken() {
      const email = document.getElementById('email').value;

      const response = await fetch('enviar_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo: email })
      });

      const result = await response.json();
      alert(result.message);

      if (result.status === 'success') {
        document.getElementById('email-section').classList.add('hidden');
        document.getElementById('code-section').classList.remove('hidden');
      }
    }

    async function verifyToken() {
      const email = document.getElementById('email').value;
      const token = document.getElementById('token').value;

      const response = await fetch('verificar_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ correo: email, token: token })
      });

      const result = await response.json();
      alert(result.message);

      if (result.status === 'success') {
        document.getElementById('password-section').classList.remove('hidden');
        document.getElementById('new-password').disabled = false;
        document.getElementById('confirm-password').disabled = false;
        document.getElementById('update-btn').disabled = false;
      } else {
        document.getElementById('new-password').disabled = true;
        document.getElementById('confirm-password').disabled = true;
        document.getElementById('update-btn').disabled = true;
      }
    }

    function updatePassword() {
      alert("Implementa la actualización de contraseña en otro archivo PHP.");
    }
  </script>
</body>
</html>

