<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

$users_id = $_SESSION["users_id"];
$message = "";

// traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"] ?? '');
    $lastname = trim($_POST["lastname"] ?? '');
    $mail = trim($_POST["mail"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $ville = trim($_POST["ville"] ?? '');
    $contact = trim($_POST["contact"] ?? '');

    if (!empty($firstname) && !empty($lastname) && !empty($mail)) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE `users` SET `users_firstname` = :firstname, `users_lastname` = :lastname, `users_mail` = :mail, `users_pwd` = :password, `users_ville` = :ville, `users_contact` = :contact WHERE `users_id` = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'password' => $hashed_password, 'ville' => $ville, 'contact' => $contact, 'id' => $users_id]);
        } else {
            $sql = "UPDATE `users` SET `users_firstname` = :firstname, `users_lastname` = :lastname, `users_mail` = :mail, `users_ville` = :ville, `users_contact` = :contact WHERE `users_id` = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'ville' => $ville, 'contact' => $contact, 'id' => $users_id]);
        }
        
        // Mise à jour des variables de session pour refléter les changements instantanément dans le header
        $_SESSION["users_firstname"] = $firstname;
        $_SESSION["users_lastname"] = $lastname;
        
        $message = "<p class='message-succes'>Votre profil a été mis à jour avec succès !</p>";
    } else {
        $message = "<p class='message-erreur'>Veuillez remplir les champs obligatoires.</p>";
    }
}

// récupération des données actuelles pour pré-remplir le formulaire
$stmt = $db->prepare("SELECT * FROM `users` WHERE `users_id` = :id");
$stmt->execute(['id' => $users_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$firstname = hsc($user["users_firstname"] ?? '');
$lastname = hsc($user["users_lastname"] ?? '');
$mail = hsc($user["users_mail"] ?? '');
$ville = hsc($user["users_ville"] ?? '');
$contact = hsc($user["users_contact"] ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/modifProfil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="page-specifique">
    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-central">
        <h1 class="titre-page">Mon Profil</h1>
        
        <?= $message ?>

        <form class="formulaire" action="modifProfil.php" method="post">
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
                <label for="password">Mot de passe (laisser vide pour conserver) :</label>
                <input type="password" id="password" name="password" class="champ-texte">
            </div>
            <div class="groupe-saisie">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" class="champ-texte" value="<?= $ville ?>">
            </div>
            <div class="groupe-saisie">
                <label for="contact">Contact :</label>
                <input type="text" id="contact" name="contact" class="champ-texte" value="<?= $contact ?>">
            </div>
            
            <button type="submit" class="bouton-primaire bouton-large">Mettre à jour</button>
        </form>
    </main>
</body>
</html>