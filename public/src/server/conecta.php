<?php

define("HOST", 'localhost');
define("BD", 'link-project');
define("USER_BD", 'postgres');
define("PASS_BD", 'root');

define(
    "CONNECTION_STRING",
    "host=" . HOST .
    " dbname=" . BD .
    " user=" . USER_BD .
    " password=" . PASS_BD
);

function conecta()
{
    $connection = pg_connect(CONNECTION_STRING);

    if (!$connection) {
        die("Error: Unable to connect to the database.");
    }

    return $connection;
}
