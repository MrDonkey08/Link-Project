<?php
session_start();
require "conecta.php";
$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];
$pass   = $_REQUEST['Pass'];

// Ejecuta la consulta para obtener al usuario
$sql = "SELECT * FROM usuario WHERE correo = $1 AND activo = TRUE";
$res = pg_query_params($con, $sql, array($correo));
$num = pg_num_rows($res);

if ($num == 1) {
    $row = pg_fetch_array($res);
    $id = $row["id_usuario"];
    $nombre = $row["nombres"];
    $apellidos = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
    $correo = $row["correo"];
    $hashed_pass = $row["clave"]; // Contraseña encriptada almacenada

    // Compara la contraseña con la almacenada (encriptada)
    if (password_verify($pass, $hashed_pass)) {
        $_SESSION['IDUser'] = $id;
        $_SESSION['NombreUser'] = $nombre;
        $_SESSION['CorreoUser'] = $correo;
        echo $num; 
    } else {
        echo 0; // Contraseña incorrecta 
    }
} else {
    echo "Usuario no encontrado"; 
}


