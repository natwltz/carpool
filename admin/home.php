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

$sql = "
        SELECT trajet.*, passager_un_users_id, passager_deux_users_id, 
               passager_trois_users_id, passager_quatre_users_id,
               users_firstname, users_lastname
        FROM trajet
        LEFT JOIN passager ON trajet_id = passager_trajet_id
        LEFT JOIN users ON trajet_users_id = users_id
        ORDER BY trajet_date_publication DESC LIMIT 8
";

$stmt = $db->prepare($sql);
$stmt->execute();
$recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-page">
        <h1 class="titre-principal">Espace Administration :<br>Supervision globale</h1>

        <div class="barre-actions-superieure" style="justify-content: flex-start; gap: 20px;">
            <button class="bouton-primaire" onclick="window.location.href = 'gestionTrajets.php'">Gérer les trajets</button>
            <button class="bouton-primaire" onclick="window.location.href = 'gestionUsers.php'">Gérer les utilisateurs</button>
        </div>

        <section class="section-trajets">
            <h2 class="sous-titre">Derniers trajets publiés sur la plateforme :</h2>

            <div class="grille-cartes">
                <?php foreach ($recordset as $row) { ?>
                    <div class="carte-trajet">
                        <h3 class="carte-ville"><?= hsc($row["trajet_ville"]); ?></h3>
                        <p><strong>Date :</strong> <?= hsc($row["trajet_date"]); ?></p>
                        <p><strong>Heure :</strong> <?= hsc($row["trajet_heure"]); ?></p>
                        <p><strong>Places totales :</strong> <?= hsc($row["trajet_nbpassager_max"]); ?></p>
                        <p><strong>Conducteur :</strong> <?= hsc($row["users_firstname"]) . " " . hsc($row["users_lastname"]); ?></p>
                        
                        <div class="carte-date-pub">
                            Publié le : <?= hsc(date("d/m/Y H:i", strtotime($row["trajet_date_publication"]))); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>