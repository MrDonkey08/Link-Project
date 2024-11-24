<?php
session_start();
require 'conecta.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto']['tmp_name'];
    $foto_data = file_get_contents($foto); // Lee el contenido del archivo

    // Asegúrate de que $foto_data sea un string binario
    if ($foto_data === false) {
        echo "Error al leer el archivo de imagen.";
        exit();
    }

    // Guardar la foto en la base de datos
    $con = conecta();
    $id_usuario = $_SESSION['IDUser']; // Asegúrate de tener el ID del usuario

    $sql = "UPDATE usuario SET foto = $1 WHERE id_usuario = $2";
    $result = pg_prepare($con, "query_update_foto", $sql);
    $result = pg_execute($con, "query_update_foto", array($foto_data, $id_usuario));

    if ($result) {
        echo "Foto subida exitosamente.";
    } else {
        echo "Error al subir la foto: " . pg_last_error($con);
    }

    pg_close($con);
}
?>