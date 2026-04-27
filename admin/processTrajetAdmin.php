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

// récupération et nettoyage des données soumises par le formulaire
$id = isset($_POST["id"]) && !empty($_POST["id"]) ? $_POST["id"] : null;
$ville = isset($_POST["ville"]) ? trim($_POST["ville"]) : '';
$date = isset($_POST["date"]) ? trim($_POST["date"]) : '';
$heure = isset($_POST["heure"]) ? trim($_POST["heure"]) : '';
$passager_max = isset($_POST["passager_max"]) ? (int)$_POST["passager_max"] : 0;

if ($id) {
    // vérifier que tous les champs obligatoires sont bien remplis
    if ($ville && $date && $heure && $passager_max) {
        $sql = "UPDATE `trajet` 
                SET `trajet_ville` = :ville, 
                    `trajet_date` = :date, 
                    `trajet_heure` = :heure, 
                    `trajet_nbpassager_max` = :passager_max 
                WHERE `trajet_id` = :id";
                
        $stmt = $db->prepare($sql);
        $stmt->execute(['ville' => $ville, 'date' => $date, 'heure' => $heure, 'passager_max' => $passager_max, 'id' => $id]);
    }
}

header("Location: gestionTrajets.php");
exit;
?>