<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !empty($_POST['id'])) {
    $trajet_id = $_POST['id'];
    $user_id = $_SESSION['users_id'];

    // 1. Récupérer les infos du trajet (conducteur et places max)
    $stmt = $db->prepare("SELECT trajet_users_id, trajet_nbpassager_max FROM trajet WHERE trajet_id = :trajet_id");
    $stmt->execute(['trajet_id' => $trajet_id]);
    $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier que le trajet existe et que l'utilisateur n'est pas le conducteur
    if ($trajet && $trajet['trajet_users_id'] != $user_id) {
        
        // 2. Récupérer les passagers actuels
        $stmt = $db->prepare("SELECT * FROM passager WHERE passager_trajet_id = :trajet_id");
        $stmt->execute(['trajet_id' => $trajet_id]);
        $passagers = $stmt->fetch(PDO::FETCH_ASSOC);

        $is_already_passenger = false;
        $empty_slot = null;
        $places_occupees = 0;
        $passenger_columns = ['passager_un_users_id', 'passager_deux_users_id', 'passager_trois_users_id', 'passager_quatre_users_id'];

        if ($passagers) { // Une ligne de passagers existe pour ce trajet
            // Compter les places occupées et vérifier si l'utilisateur est déjà passager
            foreach ($passenger_columns as $col) {
                if (!is_null($passagers[$col])) {
                    $places_occupees++;
                    if ($passagers[$col] == $user_id) {
                        $is_already_passenger = true;
                    }
                }
            }

            // Si pas déjà passager et qu'il reste de la place...
            if (!$is_already_passenger && $places_occupees < $trajet['trajet_nbpassager_max']) {
                // ...trouver un slot libre
                foreach ($passenger_columns as $col) {
                    if (is_null($passagers[$col])) {
                        $empty_slot = $col;
                        break;
                    }
                }
            }

            if (!is_null($empty_slot)) {
                // Mettre à jour la table passager avec le nouvel utilisateur
                $sql_update = "UPDATE passager SET $empty_slot = :user_id WHERE passager_trajet_id = :trajet_id";
                $stmt_update = $db->prepare($sql_update);
                $stmt_update->execute(['user_id' => $user_id, 'trajet_id' => $trajet_id]);
            }
        } elseif ($trajet['trajet_nbpassager_max'] > 0) { // Aucune ligne de passagers n'existe pour ce trajet, on la crée
            $sql_insert = "INSERT INTO passager (passager_trajet_id, passager_un_users_id) VALUES (:trajet_id, :user_id)";
            $stmt_insert = $db->prepare($sql_insert);
            $stmt_insert->execute(['trajet_id' => $trajet_id, 'user_id' => $user_id]);
        }
    }
}

// Rediriger vers la page d'où vient l'utilisateur pour une meilleure expérience
$referer = $_SERVER['HTTP_REFERER'] ?? 'home.php';
header("Location: " . $referer);
exit;
?>