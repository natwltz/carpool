<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";


    if(!empty($_POST)) {
        $sql = "INSERT INTO trajet (trajet_ville, trajet_date, trajet_heure,
                    trajet_users_id, trajet_nbpassager_max, trajet_date_publication)
                VALUES (:ville, :date, :heure, :users_id, :nbpassager_max, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'ville' => hsc($_POST["ville"]),
            'date' => hsc($_POST["date"]),
            'heure' => hsc($_POST["heure"]),
            'users_id' => $_SESSION["users_id"],
            'nbpassager_max' => hsc($_POST["passager_max"]),
        ]);
    }
    header("Location:home.php");
    exit; 
    echo ($_POST["ville"]);
    echo ($_POST["date"]);
    echo ($_POST["heure"]);
    echo ($_POST["passager_max"]);
?>
