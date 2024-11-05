<?php
/**
 * Archivo para Inicio de Sesión de usuarios
 *
 * @category Autenticación
 * @author   MrDonkey08 <alan.juarez5178@alumnos.udg.mx>
 */

require_once 'conecta.php';
session_start();

/**
 * Verifica que las credenciales sean correctas, si lo son, inicia sesión en
 * dicha cuenta.
 *
 * @param string $correo          Correo ingresado
 * @param string $clave           Clave ingresada
 * @param string $tipo_de_usuario Tipo de usuario para iniciar sesión
 *
 * @return bool True si las credenciales son correctas, False en caso contrario
 */
function login($correo, $clave, $tipo_de_usuario)
{
    $usuario_registrado = obtener_usuario_por_correo($correo, $tipo_de_usuario);

    if (!$usuario_registrado) {
        // Usuario no encontrado
        return false;
    }

    if (!verificar_clave($clave, $usuario_registrado->contraseña)) {
        // Clave incorrecta
        return false;
    }

    // Inicia la sesión asignando los datos necesarios
    $_SESSION["correo"] = $usuario_registrado->correo;
    $_SESSION["tipo_de_usuario"] = $tipo_de_usuario;

    return true;
}

/**
 * Obtiene el usuario por correo de la tabla correspondiente al tipo de usuario.
 *
 * @param string $correo Correo del usuario
 * @param string $tabla  Tabla correspondiente al tipo de usuario
 *
 * @return object|null Objeto del usuario si existe, null si no
 */
function obtener_usuario_por_correo($correo, $tabla)
{
    $con = conecta();
    $query = "SELECT correo, contraseña" .
        " FROM " . pg_escape_string($tabla) .
        " WHERE correo = $1" .
        " LIMIT 1;";

    $result = pg_query_params($con, $query, [$correo]);

    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_object($result);
    }

    return null;
}

/**
 * Verifica que la clave ingresada coincida con el hash almacenado en la BD.
 *
 * @param string $clave      Clave ingresada por el usuario
 * @param string $hash_clave Clave hasheada almacenada en la BD
 *
 * @return bool True si la clave es correcta, False en caso contrario
 */
function verificar_clave($clave, $hash_clave)
{
    return password_verify($clave, $hash_clave);
}
