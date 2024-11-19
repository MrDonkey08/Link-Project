<?php
session_start();
require "conecta.php";
$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];
$pass   = $_REQUEST['Pass'];

// Ejecuta la consulta con pg_query
$sql = "SELECT * FROM usuario WHERE correo = $1 AND clave = $2 AND activo = TRUE";
$res = pg_query_params($con, $sql, array($correo, $pass));

if ($res) {
    $num = pg_num_rows($res);

    if ($num == 1) {
        $row = pg_fetch_array($res);
        $id = $row["id_usuario"];
        $nombre = $row["nombres"];
        $apellidos = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
        $correo = $row["correo"];

        $_SESSION['IDUser'] = $id;
        $_SESSION['NombreUser'] = $nombre;
        $_SESSION['CorreoUser'] = $correo;
    }

    echo $num;
} else {
    echo "Error en la consulta.";
}
