<?php
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PWD);
} catch (Exception $e) {
    die($e->getMessage());
}
?>