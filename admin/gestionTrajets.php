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

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$stmtCount = $db->query("SELECT COUNT(*) FROM `trajet`");
$total = $stmtCount->fetchColumn();
$totalPages = ceil($total / $limit);
if ($totalPages < 1) $totalPages = 1;

// récupérer tous les trajets avec les infos du conducteur
$stmt = $db->prepare("
    SELECT trajet.*, passager_un_users_id, passager_deux_users_id, 
           passager_trois_users_id, passager_quatre_users_id,
           users_firstname, users_lastname
    FROM trajet
    LEFT JOIN passager ON trajet_id = passager_trajet_id
    LEFT JOIN users ON trajet_users_id = users_id
    ORDER BY trajet_id DESC
    LIMIT $limit OFFSET $offset
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
                        // calcul des places disponibles
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
                                    <form action="modifTrajetAdmin.php" method="post" class="form-action">
                                        <input type="hidden" name="id" value="<?= hsc($row["trajet_id"]); ?>">
                                        <button type="submit" class="bouton-action bouton-modifier" title="Modifier">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </form>
                                    <!-- Bouton déclenchant la modale JS -->
                                    <button type="button" class="bouton-action bouton-supprimer" title="Supprimer" onclick="ouvrirModal('<?= hsc($row['trajet_id']); ?>')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>"><button class="bouton-icone bouton-suivant" title="Page précédente">&lt;</button></a>
            <?php endif; ?>
            <span class="texte-pagination">Page <?= $page ?>/<?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>"><button class="bouton-icone bouton-suivant" title="Page suivante">&gt;</button></a>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modale de confirmation de suppression -->
    <div id="modal-suppression" class="modal">
        <div class="modal-contenu">
            <span class="fermer-modal-croix" onclick="fermerModal()">&times;</span>
            <h2 class="modal-titre">Confirmer la suppression</h2>
            <p class="modal-texte">Êtes-vous sûr de vouloir supprimer ce trajet ? Cette action est irréversible.</p>
            <form action="supprTrajet.php" method="post" id="form-suppression">
                <input type="hidden" name="id" id="modal-trajet-id" value="">
                <button type="submit" class="bouton-primaire bouton-modal-confirmer bouton-danger">Supprimer définitivement</button>
                <button type="button" class="bouton-secondaire bouton-modal-annuler" onclick="fermerModal()">Annuler</button>
            </form>
        </div>
    </div>

    <script src="../script/gestionTrajets.js?v=1.1"></script>
</body>

</html>