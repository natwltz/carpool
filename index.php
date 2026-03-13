<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/login.css">
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

        <form class="formulaire">
            <div class="groupe-saisie">
                <label for="username">Username :</label>
                <input type="text" id="username" class="champ-texte">
            </div>

            <div class="groupe-saisie">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" class="champ-texte">
            </div>

            <button type="submit" class="bouton-primaire bouton-large">Sauvegarder</button>
        </form>

        <a href="#" class="lien-oubli">Mot de passe oublié</a>
    </main>

</body>
</html>