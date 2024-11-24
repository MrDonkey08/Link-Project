<?php
session_start();
require 'conecta.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $habilidades = $_POST['habilidades'];
    $id_estudiante = $_POST['id_estudiante']; // Recibe el ID del estudiante desde el formulario
    $id_usuario = $_SESSION['IDUser'];

    // Actualiza las habilidades en la base de datos
    $con = conecta();
    $sql = "UPDATE estudiante SET habilidades = $1 WHERE id_estudiante = $2";
    $result = pg_prepare($con, "query_update_habilidades", $sql);
    $result = pg_execute($con, "query_update_habilidades", array($habilidades, $id_estudiante));

    if ($result) {
        header("Location: ../../pages/perfil_usuario.php?id=" . $_SESSION['IDUser']);
        exit();
    } else {
        echo "Error al actualizar las habilidades: " . pg_last_error($con);
    }

    pg_close($con);
}
?>