<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/small_form.css" />
    <script src="../src/server/jquery-3.3.1.min.js"></script> <!-- Agrega jQuery -->
</head>
<body>
<section class="container small-container">
    <h1>Recuperar Contraseña</h1>
    <form id="email-form">
        <div class="input-box">
            <input
                type="email"
                id="email-input"
                name="email"
                pattern="\w[\w\.]{0,30}@(alumnos|academicos)\.udg\.mx"
                title="El correo debe ser institucional, perteneciente a la UDG"
                autocomplete="on"
                required
            />
            <label for="email-input">Correo Electrónico</label>
            <div id="mensaje"></div>
        </div>
        <button type="submit">
            Enviar Código
        </button>
    </form>

    <form method="POST" action="../src/server/valida_token_contraseña.php">
        <div class="input-box">
            <input
                type="text"
                id="token-input"
                name="token"
                maxlength="6"
                required
            />
            <label for="token-input">Código de validación</label>
        </div>
        <div class="input-box" id="passCont" style="display: none;">
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
            <label for="password-input">Nueva Contraseña</label>
        </div>
        <div class="input-box" id="passCont2" style="display: none;">
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
            <label for="password-input-2">Confirmar Contraseña</label>
        </div>
        <button type="submit" name="submit" value="restablecerClave" id="bottonPass" style="display: none;">
            Actualizar Contraseña
        </button>
    </form>
</section>
<!-- Script para la validacion del correo (existencia y enviar token) sin actualizar pagina -->
<script>
    // Manejo de AJAX para enviar el correo
    $(document).ready(function () {
        $('#email-form').on('submit', function (event) {
            event.preventDefault(); // Prevenir el envío normal del formulario

            const email = $('#email-input').val();

            $.ajax({
                url: '../src/server/valida_token_contraseña.php', 
                type: 'POST',
                data: { email: email, submit: 'generarToken' }, 
                success: function (response) {
                    console.log(response);
                    $("#mensaje").html('El codigo de recuperación fue enviado a tu correo'); 
                },
                error: function () {
                    alert('Hubo un error al intentar enviar el correo. Inténtalo de nuevo.');
                }
            });
        });
    });
</script>
<!-- Script para la validacion del token -->
<script>
document.getElementById('token-input').addEventListener('input', function () {
    const token = this.value.trim(); // Obtiene el token ingresado
    const tokenInput = document.getElementById('token-input'); // Referencia al campo de entrada

    if (token.length === 6) { // Solo verifica cuando el token tenga 6 caracteres
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../src/server/valida_token_contraseña.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            const response = xhr.responseText.trim();

            if (response === "válido") {
                tokenInput.style.borderColor = "green"; // Borde verde si es válido
                tokenInput.style.backgroundColor = "#d4f9d4"; // Fondo verde claro
                document.getElementById('passCont').style.display = 'block';
                document.getElementById('passCont2').style.display = 'block';
                document.getElementById('bottonPass').style.display = 'block';
                console.log(response); // Log para verificar el token válido
            } else {
                tokenInput.style.borderColor = "red"; // Borde rojo si es inválido
                tokenInput.style.backgroundColor = "#f9d4d4"; // Fondo rojo claro
                console.log(response); // Log para verificar el token inválido
            }
        };

        xhr.send("token=" + encodeURIComponent(token));
    } else {
        // Restaura los estilos originales si no hay 6 caracteres
        tokenInput.style.borderColor = "";
        tokenInput.style.backgroundColor = "";
    }
});

</script>

</script>
</body>
</html>