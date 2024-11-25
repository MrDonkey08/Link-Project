<?php

session_start();
require 'conecta.php';
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../pages/imgs/'; 
        $fileName = basename($file['name']);
        $uploadFile = $uploadDir . $fileName;

        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo "Tipo de archivo no permitido.";
            exit;
        }

        // Mueve el archivo subido
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $dir_BD = 'imgs/' . $fileName; 
            // Actualiza la base de datos con la nueva ruta de la foto
            $id_usuario = $_SESSION['IDUser'];
            $query = "UPDATE usuario SET foto = $1 WHERE id_usuario = $2";
            pg_prepare($con, "update_foto", $query);
            pg_execute($con, "update_foto", array($dir_BD, $id_usuario));
            header("Location: ../../pages/perfil_usuario.php?id=$id_usuario");
        } else {
            echo "Error al mover el archivo subido.";
        }
    } else {
        echo "Error en la subida del archivo: " . $file['error'];
    }
}
/*
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
}*/

?>