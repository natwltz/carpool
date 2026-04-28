<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

$sql = "
        SELECT trajet.*, passager_un_users_id, passager_deux_users_id, 
               passager_trois_users_id, passager_quatre_users_id,
               users_firstname, users_lastname
        FROM trajet
        LEFT JOIN passager ON trajet_id = passager_trajet_id
        LEFT JOIN users ON trajet_users_id = users_id
";

$params = [];
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $sql .= " WHERE LOWER(trajet_ville) LIKE LOWER(:search)";
    $params['search'] = '%' . trim($_GET['search']) . '%';
}

$sql .= " ORDER BY trajet_date_publication DESC LIMIT 8";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool - Covoiturage entre collègues</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/home.css">
    <script src="../script/home.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-page">
        <h1 class="titre-principal">Covoiturage entre collègues :<br>simplifiez vos trajets</h1>

        <div class="barre-actions-superieure">
            <form action="home.php" method="GET" class="groupe-recherche">
                <input type="text" name="search" class="champ-recherche" placeholder="départ" value="<?= isset($_GET['search']) ? hsc($_GET['search']) : '' ?>">
                <button type="submit" class="bouton-recherche">rechercher</button>
            </form>

            <a href="ajoutTrajets.php">
                <button class="bouton-primaire" title="Ajouter un trajet" href="ajoutTrajets.php">
                    + publier un trajet
                </button>
            </a>
        </div>

        <section class="section-trajets">
            <h2 class="sous-titre">Dernier trajet publié disponible :</h2>

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
                        continue; // Ne pas afficher les trajets complets
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
                                <form class="formulaire" action="processReservation.php" method="post">
                                    <input type="hidden" value="<?= hsc($row["trajet_id"]); ?>" name="id">
                                    <button type="submit" class="bouton-primaire bouton-modal-confirmer">Confirmer la réservation</button>
                                    <button type="button" class="bouton-secondaire fermer-modal bouton-modal-annuler">Annuler</button>
                                </form>
                            </div>
                        </div>
                        <div class="carte-date-pub">
                            Publié le : <?= hsc(date("d/m/Y H:i", strtotime($row["trajet_date_publication"]))); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

        <div class="barre-actions-inferieure">
            <button class="bouton-primaire" onclick="window.location.href = 'tousTrajets.php'">Tous les trajets</button>
            <button class="bouton-primaire" onclick="window.location.href = 'gestionTrajetsUser.php'">Gérer vos trajets</button>
        </div>
    </main>

</body>

</html>