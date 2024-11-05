<?php
session_start();
require "conecta.php";
$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];
$pass   = $_REQUEST['Pass'];

// Ejecuta la consulta con pg_query
$sql = "SELECT * FROM Usuarios WHERE Correo = '$correo' AND Pass = '$pass' AND status = 1 AND eliminado = 0";
$res = pg_query($con, $sql);

if ($res) {
    $num = pg_num_rows($res);

    if ($num == 1) {
        $row = pg_fetch_array($res);
        $id = $row["id"];
        $nombre = $row["nombre"];
        $apellidos = $row["apellidos"];
        $correo = $row["correo"];
        
        $_SESSION['IDUser'] = $id;
        $_SESSION['NombreUser'] = $nombre;
        $_SESSION['CorreoUser'] = $correo;
    }

    echo $num;
} else {
    echo "Error en la consulta.";
}
