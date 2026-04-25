<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

// Sécurité : on s'assure que seul un administrateur peut accéder à cette page
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    header("Location: ../users/home.php");
    exit;
}

// Requête pour récupérer tous les trajets avec les infos du conducteur
$stmt = $db->prepare("
    SELECT trajet.*, passager_un_users_id, passager_deux_users_id, 
           passager_trois_users_id, passager_quatre_users_id,
           users_firstname, users_lastname
    FROM trajet
    LEFT JOIN passager ON trajet_id = passager_trajet_id
    LEFT JOIN users ON trajet_users_id = users_id
    ORDER BY trajet_id DESC
");
$stmt->execute();
$recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les trajets - Carpool Admin</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/gestionTrajets.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-large">

        <div class="entete-section">
            <h1 class="titre-page">Gérer les trajets :</h1>
            <a href="../users/ajoutTrajets.php">
                <button class="bouton-icone" title="Ajouter un trajet">+</button>
            </a>
        </div>

        <div class="conteneur-table">
            <table class="table-crud">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CONDUCTEUR</th>
                        <th>VILLE</th>
                        <th>DATE</th>
                        <th>HEURE</th>
                        <th>PLACES DISPO</th>
                        <th>OPÉRATIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recordset as $row) {
                        // Calcul des places disponibles
                        $places_occupees = 0;
                        if (!is_null($row["passager_un_users_id"])) $places_occupees++;
                        if (!is_null($row["passager_deux_users_id"])) $places_occupees++;
                        if (!is_null($row["passager_trois_users_id"])) $places_occupees++;
                        if (!is_null($row["passager_quatre_users_id"])) $places_occupees++;

                        $places_dispo = $row["trajet_nbpassager_max"] - $places_occupees;
                    ?>
                        <tr>
                            <td><?= hsc($row["trajet_id"]); ?></td>
                            <td><?= hsc($row["users_firstname"]) . " " . hsc($row["users_lastname"]); ?></td>
                            <td><?= hsc($row["trajet_ville"]); ?></td>
                            <td><?= hsc($row["trajet_date"]); ?></td>
                            <td><?= hsc($row["trajet_heure"]); ?></td>
                            <td><?= $places_dispo ?> / <?= hsc($row["trajet_nbpassager_max"]); ?></td>
                            <td>
                                <div class="actions-tableau">
                                    <form action="modifTrajet.php" method="post" class="form-action">
                                        <input type="hidden" name="id" value="<?= hsc($row["trajet_id"]); ?>">
                                        <button type="submit" class="bouton-action bouton-modifier" title="Modifier">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </form>
                                    <!-- Une petite sécurité JS (confirm) avant de soumettre la suppression -->
                                    <form action="supprTrajet.php" method="post" class="form-action" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                                        <input type="hidden" name="id" value="<?= hsc($row["trajet_id"]); ?>">
                                        <button type="submit" class="bouton-action bouton-supprimer" title="Supprimer">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>