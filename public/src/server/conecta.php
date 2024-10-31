<?php

define("HOST", 'localhost');
define("BD", 'link-project');
define("USER_BD", 'root');
define("PASS_BD", getenv('DB_PASSWORD'));

define(
    "CONNECTION_STRING",
    "host=" . HOST .
    " dbname=" . BD .
    " user=" . USERBD .
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
