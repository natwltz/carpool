<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";


    if(!empty($_POST)) {
        $ville = trim($_POST["ville"] ?? '');
        $date = trim($_POST["date"] ?? '');
        $heure = trim($_POST["heure"] ?? '');
        $passager_max = $_POST["passager_max"] ?? 0;
        $id = $_POST['id'] ?? null;

        if ($id && !empty($id)) {
            // UPDATE
            $sql = "UPDATE trajet SET 
                        trajet_ville = :ville, 
                        trajet_date = :date, 
                        trajet_heure = :heure, 
                        trajet_nbpassager_max = :nbpassager_max
                    WHERE trajet_id = :id AND trajet_users_id = :users_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'ville' => $ville,
                'date' => $date,
                'heure' => $heure,
                'nbpassager_max' => $passager_max,
                'id' => $id,
                'users_id' => $_SESSION["users_id"]
            ]);
            header("Location: gestionTrajetsUser.php");
            exit;
        } else {
            // INSERT
            $sql = "INSERT INTO trajet (trajet_ville, trajet_date, trajet_heure,
                        trajet_users_id, trajet_nbpassager_max, trajet_date_publication)
                    VALUES (:ville, :date, :heure, :users_id, :nbpassager_max, NOW())";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'ville' => $ville,
                'date' => $date,
                'heure' => $heure,
                'users_id' => $_SESSION["users_id"],
                'nbpassager_max' => $passager_max,
            ]);
        }
    }
    header("Location:home.php");
    exit; 
?>
