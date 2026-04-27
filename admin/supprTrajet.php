<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

// vérification admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    header("Location: ../users/home.php");
    exit;
}

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    
    $id = $_POST["id"];
    
    $stmt = $db->prepare("DELETE FROM `trajet` WHERE `trajet_id` = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: gestionTrajets.php");
exit;
?>