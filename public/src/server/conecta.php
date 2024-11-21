<?php
/**
 * Archivo para la conexión de la BD
 *
 * @category Conexión
 * @author   MrDonkey08 <alan.juarez5178@alumnos.udg.mx>
 */

define("HOST", 'localhost'); // Dirección del servidor de base de datos
define("BD", 'link-project'); // Nombre de la base de datos
define("USER_BD", 'postgres'); // Usuario de la base de datos
define("PASS_BD", ''); // Contraseña del usuario

// Definimos la cadena de conexión utilizando las constantes anteriores
define(
    "CONNECTION_STRING",
    "host=" . HOST .
    " dbname=" . BD .
    " user=" . USER_BD .
    " password=" . PASS_BD
);

/**
 * Función para conectar a la base de datos PostgreSQL
 *
 * @return resource|false Devuelve la conexión si es exitosa, o termina el
 *                        script en caso de error.
 */
function conecta()
{
    // Intenta conectar a la base de datos
    $connection = pg_connect(CONNECTION_STRING);

    // Verifica si la conexión falló
    if (!$connection) {
        // Termina el script con un mensaje de error
        die("Error: No se pudo conectar a la base de datos.");
    }

    return $connection; // Devuelve la conexión establecida
}

/**
 * Función para desconectar de la base de datos PostgreSQL
 *
 * @param resource|null $connection La conexión que se va a cerrar.
 *
 * @return void
 */
function desconecta($connection)
{
    if ($connection) { // Verifica si hay una conexión activa
        pg_close($connection); // Cierra la conexión
        echo "Conexión cerrada correctamente."; // Mensaje de confirmación
    } else {
        // Mensaje en caso de que no haya conexión
        echo "No hay una conexión activa para cerrar.";
    }
}
