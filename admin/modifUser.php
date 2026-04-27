<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    header("Location: ../users/home.php");
    exit;
}

// Vérifie si un ID est passé 
$id = isset($_POST["id"]) ? hsc($_POST["id"]) : (isset($_GET["id"]) ? hsc($_GET["id"]) : null);

$firstname = '';
$lastname = '';
$mail = '';
$ville = '';
$contact = '';
$titre_page = "Ajouter un utilisateur";

if ($id) {
    $stmt = $db->prepare("SELECT * FROM `users` WHERE `users_id` = :id");
    $stmt->execute(['id' => $id]);
    $recordset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recordset) {
        $firstname = isset($recordset["users_firstname"]) ? hsc($recordset["users_firstname"]) : '';
        $lastname = isset($recordset["users_lastname"]) ? hsc($recordset["users_lastname"]) : '';
        $mail = isset($recordset["users_mail"]) ? hsc($recordset["users_mail"]) : '';
        $ville = isset($recordset["users_ville"]) ? hsc($recordset["users_ville"]) : '';
        $contact = isset($recordset["users_contact"]) ? hsc($recordset["users_contact"]) : '';
        $titre_page = "Modifier un utilisateur";
    } else {
        $id = null; // ID introuvable, on repasse en mode ajout
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre_page ?> - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/modifUser.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-central">
        <h1 class="titre-page"><?= $titre_page ?></h1>

        <form class="formulaire" action="processUser.php" method="post">
            <div class="groupe-saisie">
                <label for="firstname">Prénom :</label>
                <input type="text" id="firstname" name="firstname" class="champ-texte" value="<?= $firstname ?>" required>
            </div>
            <div class="groupe-saisie">
                <label for="lastname">Nom :</label>
                <input type="text" id="lastname" name="lastname" class="champ-texte" value="<?= $lastname ?>" required>
            </div>
            <div class="groupe-saisie">
                <label for="mail">Email :</label>
                <input type="email" id="mail" name="mail" class="champ-texte" value="<?= $mail ?>" required>
            </div>
            <div class="groupe-saisie">
                <label for="password">Mot de passe <?= $id ? '(laisser vide pour conserver)' : ':' ?></label>
                <input type="password" id="password" name="password" class="champ-texte" <?= $id ? '' : 'required' ?>>
            </div>
            <div class="groupe-saisie">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" class="champ-texte" value="<?= $ville ?>">
            </div>
            <div class="groupe-saisie">
                <label for="contact">Contact :</label>
                <input type="text" id="contact" name="contact" class="champ-texte" value="<?= $contact ?>">
            </div>
            
            <?php if ($id): ?>
                <input type="hidden" value="<?= hsc($id); ?>" name="id">
            <?php endif; ?>
            <button type="submit" class="bouton-primaire bouton-large"><?= $id ? 'Sauvegarder' : 'Ajouter' ?></button>
        </form>
    </main>

</body>
</html>