<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

if (!isset($_POST["id"]) || empty($_POST["id"])) {
    header("Location: gestionTrajetsUser.php");
    exit;
}
$id = $_POST["id"];

$stmt = $db->prepare("
        SELECT
            trajet_id,
            trajet_heure,
            trajet_ville,
            trajet_date,
            trajet_nbpassager_max
        FROM `trajet`
        WHERE `trajet_id` = :id AND `trajet_users_id` = :users_id
    ");
$stmt->execute([
    'id' => $id,
    'users_id' => $_SESSION['users_id']
]);
$trajet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trajet) {
    header("Location: gestionTrajetsUser.php");
    exit;
}

$heure = hsc($trajet["trajet_heure"]);
$ville = hsc($trajet["trajet_ville"]);
$date = hsc($trajet["trajet_date"]);
$nbpassager = hsc($trajet["trajet_nbpassager_max"]);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un trajet - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/ajoutTrajets.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-central">
        <h1 class="titre-page">Modifiez un trajet</h1>

        <form class="formulaire" action="processTrajets.php" method="post" enctype="multipart/form-data">
            <div class="groupe-saisie">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" class="champ-texte" value="<?= $ville ?>">
            </div>

            <div class="groupe-saisie">
                <label for="date">Date :</label>
                <div class="champ-date-visuel">
                    <input type="date" id="date" name="date" class="sous-champ-date" value="<?= $date ?>">
                </div>
            </div>

            <div class="groupe-saisie-ligne">
                <label for="heure">Heure de départ :</label>
                <input type="time" name="heure" id="heure" class="champ-heure" value="<?= $heure ?>">
            </div>

            <div class="groupe-saisie">
                <label>Nombre de passagers :</label>
                <div class="selecteur-passagers">
                    <input type="radio" name="passager_max" id="p1" value="1"
                        <?= $nbpassager == 1 ? "checked" : "" ?>>
                    <label for="p1" class="bouton-passager">1</label>

                    <input type="radio" name="passager_max" id="p2" value="2"
                        <?= $nbpassager == 2 ? "checked" : "" ?>>
                    <label for="p2" class="bouton-passager">2</label>

                    <input type="radio" name="passager_max" id="p3" value="3"
                        <?= $nbpassager == 3 ? "checked" : "" ?>>
                    <label for="p3" class="bouton-passager">3</label>

                    <input type="radio" name="passager_max" id="p4" value="4"
                        <?= $nbpassager == 4 ? "checked" : "" ?>>
                    <label for="p4" class="bouton-passager">4</label>
                </div>
            </div>
            <input type="hidden" value="<?= hsc($trajet['trajet_id']); ?>" name="id">
            <button type="submit" class="bouton-primaire bouton-large">Sauvegarder</button>
        </form>
    </main>

</body>

</html>