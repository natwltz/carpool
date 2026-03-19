<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

$errorMessage = "";
if (!empty($_POST["password"]) && !empty($_POST["mail"])) {
    $errorMessage = "<p>Le mail ou le mdp sont incorrect</p>";
    $sql = "SELECT * 
            FROM users
            WHERE users_mail = :mail";
    $stmt = $db->prepare($sql);
    $stmt->execute([":mail" => $_POST["mail"]]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($_POST["password"], $row["users_pwd"])) {
            
            // Crée un nouvel ID de session sécurisé suite à la connexion
            session_regenerate_id(true);
            
            $_SESSION["is_admin"] = (bool)$row["users_is_admin"];
            $_SESSION["users_connected"] = "ok";
            $_SESSION["users_id"] = $row["users_id"];
            header("Location:users/home.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Carpool</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-connexion">

    <header class="en-tete">
        <div class="logo">CARPOOL</div>
    </header>

    <main class="conteneur-central">
        <h1 class="titre-connexion">Connexion</h1>

        <form class="formulaire" action="index.php" method="post">
            <div class="groupe-saisie">
                <label for="mail">Mail :</label>
                <input type="email" name="mail" id="mail" class="champ-texte" required>
            </div>

            <div class="groupe-saisie">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" class="champ-texte" required>
            </div>

            <button type="submit" value="OK" class="bouton-primaire bouton-large">Connexion</button>
            <?= $errorMessage ?>
        </form>

        <a href="#" class="lien-oubli">Mot de passe oublié</a>
    </main>

</body>

</html>