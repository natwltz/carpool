<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

// récupére tous les trajets sans limite, du plus récent au plus ancien
$sql = "
        SELECT trajet.*, passager_un_users_id, passager_deux_users_id, 
               passager_trois_users_id, passager_quatre_users_id,
               users_firstname, users_lastname
        FROM trajet
        LEFT JOIN passager ON trajet_id = passager_trajet_id
        LEFT JOIN users ON trajet_users_id = users_id
        ORDER BY trajet_date_publication DESC
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
    <title>Tous les trajets - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/toustrajets.css">
    <script src="../script/home.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-page">
        <div class="entete-section entete-tous-trajets">
            <h1 class="titre-principal titre-tous-trajets">Tous les trajets disponibles</h1>
            <a href="home.php">
                <button class="bouton-primaire">Retour à l'accueil</button>
            </a>
        </div>

        <section class="section-trajets">
            <div class="grille-cartes">
                <?php foreach ($recordset as $row) {
                    // Calcul des places disponibles
                    $places_occupees = 0;
                    if (!is_null($row["passager_un_users_id"])) $places_occupees++;
                    if (!is_null($row["passager_deux_users_id"])) $places_occupees++;
                    if (!is_null($row["passager_trois_users_id"])) $places_occupees++;
                    if (!is_null($row["passager_quatre_users_id"])) $places_occupees++;

                    $places_dispo = $row["trajet_nbpassager_max"] - $places_occupees;

                    if ($places_dispo <= 0) {
                        continue; // On ignore les trajets complets
                    }
                ?>
                    <div class="carte-trajet">
                        <h3 class="carte-ville"><?= hsc($row["trajet_ville"]); ?></h3>
                        <p><strong>Date :</strong> <?= hsc($row["trajet_date"]); ?></p>
                        <p><strong>Heure :</strong> <?= hsc($row["trajet_heure"]); ?></p>
                        <p><strong>Places dispo :</strong> <?= $places_dispo ?> / <?= hsc($row["trajet_nbpassager_max"]); ?></p>
                        <button class="bouton-primaire modal-ouverture" data-modal="modal-<?= hsc($row["trajet_id"]); ?>">Réserver</button>
                        
                        <div class="modal" id="modal-<?= hsc($row["trajet_id"]); ?>">
                            <div class="modal-contenu">
                                <span class="fermer-modal-croix fermer-modal">&times;</span>
                                <h3 class="carte-ville"><?= hsc($row["trajet_ville"]); ?></h3>
                                <p><strong>Date :</strong> <?= hsc($row["trajet_date"]); ?></p>
                                <p><strong>Heure :</strong> <?= hsc($row["trajet_heure"]); ?></p>
                                <p><strong>Places dispo :</strong> <?= $places_dispo ?> / <?= hsc($row["trajet_nbpassager_max"]); ?></p>
                                <p><strong>Conducteur :</strong> <?= hsc($row["users_firstname"]) . " " . hsc($row["users_lastname"]); ?></p>
                                <form class="formulaire" action="tousTrajets.php" method="post">
                                    <input type="hidden" value="<?= hsc($row["trajet_id"]); ?>" name="id">
                                    <button type="submit" class="bouton-primaire bouton-modal-confirmer">Confirmer la réservation</button>
                                    <button type="button" class="bouton-secondaire fermer-modal bouton-modal-annuler">Annuler</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>