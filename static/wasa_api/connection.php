<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
function getPDO()
{

    $db_host = "127.0.0.1";
    $db_user = "root";
    $db_pass = "password";
    $db_select = "WasaTeam";

    $dsn = "mysql:host=" . $db_host . ";dbname=" . $db_select;

    return $pdo = new PDO($dsn, $db_user, $db_pass);
}
