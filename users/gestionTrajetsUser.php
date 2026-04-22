<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

$stmt = $db->prepare("
    SELECT
    trajet_id,
    trajet_heure,
    trajet_ville,
    trajet_date,
    trajet_nbpassager_max,
    u1.users_firstname AS passager_1,
    u2.users_firstname AS passager_2,
    u3.users_firstname AS passager_3,
    u4.users_firstname AS passager_4
    FROM `trajet`
    RIGHT JOIN `passager` p ON p.passager_trajet_id = trajet_id
    LEFT JOIN `users` u1 ON p.passager_un_users_id = u1.users_id
    LEFT JOIN `users` u2 ON p.passager_deux_users_id = u2.users_id
    LEFT JOIN `users` u3 ON p.passager_trois_users_id = u3.users_id
    LEFT JOIN `users` u4 ON p.passager_quatre_users_id = u4.users_id
    WHERE `trajet_id` = 2;
");
$stmt->execute();
$recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer vos trajets - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/gestionTrajetsUser.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="page-specifique">

    <header class="en-tete">
        <a href="home.php">
            <div class="logo">CARPOOL</div>
        </a>
        <div class="profil-utilisateur">
            <span class="nom-utilisateur">M. Doe</span>
            <div class="avatar"></div>
            <span class="icone-menu">▼</span>
        </div>
    </header>

    <main class="conteneur-large">

        <div class="entete-section">
            <h1 class="titre-page">Gérer vos trajets :</h1>
            <a href="ajoutTrajets.php">
                <button class="bouton-icone" title="Ajouter un trajet" href="ajoutTrajets.php">+</button>
            </a>
        </div>

        <div class="conteneur-table">
            <table class="table-crud">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VILLE</th>
                        <th>DATE</th>
                        <th>HEURE</th>
                        <th>SIEGE DISPONIBLE</th>
                        <th>P1</th>
                        <th>P2</th>
                        <th>P3</th>
                        <th>P4</th>
                        <th>OPERATIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recordset as $row) {
                        $siegeDispo = $row["trajet_nbpassager_max"];
                        if (!is_null($row["passager_1"])) {
                            $siegeDispo--;
                        }
                        if (!is_null($row["passager_2"])) {
                            $siegeDispo--;
                        }
                        if (!is_null($row["passager_3"])) {
                            $siegeDispo--;
                        }
                        if (!is_null($row["passager_4"])) {
                            $siegeDispo--;
                        }
                    ?>
                        <tr>
                            <td><?= hsc($row["trajet_id"]); ?></td>
                            <td><?= hsc($row["trajet_ville"]); ?></td>
                            <td><?= hsc($row["trajet_date"]); ?></td>
                            <td><?= hsc($row["trajet_heure"]); ?></td>
                            <td><?= $siegeDispo; ?></td>
                            <td><?= hsc($row["passager_1"]); ?></td>
                            <td><?= hsc($row["passager_2"]); ?></td>
                            <td><?= hsc($row["passager_3"]); ?></td>
                            <td><?= hsc($row["passager_4"]); ?></td>
                            <td>
                                <div class="actions-tableau">
                                    <form action="modifTrajets.php" method="post" class="form-action">
                                        <input type="hidden" name="id" value="<?= hsc($row["trajet_id"]); ?>">
                                        <button type="submit" class="bouton-action bouton-modifier" title="Modifier">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="bouton-action bouton-supprimer" title="Supprimer">
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
            <span class="texte-pagination">Page 1/4</span>
            <button class="bouton-icone bouton-suivant" title="Page suivante">></button>
        </div>

    </main>

</body>

</html>