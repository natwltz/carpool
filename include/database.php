<?php
define("DB_HOST","localhost");
define("DB_NAME","carpool");
define("DB_USER","root");
define("DB_PWD","");

try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",DB_USER,DB_PWD);
} catch (Exception $e) {
    die($e -> getMessage());
}
?>