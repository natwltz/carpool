<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool - Covoiturage entre collègues</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>

    <main class="conteneur-page">
        <h1 class="titre-principal">Covoiturage entre collègues :<br>simplifiez vos trajets</h1>

        <div class="barre-actions-superieure">
            <div class="groupe-recherche">
                <input type="text" class="champ-recherche" placeholder="départ">
                <button class="bouton-recherche">rechercher</button>
            </div>

            <button class="bouton-primaire">+ publier un trajet</button>
        </div>

        <section class="section-trajets">
            <h2 class="sous-titre">Dernier trajet publié disponible :</h2>

            <div class="grille-cartes">
                <div class="carte-trajet"></div>
                <div class="carte-trajet"></div>
                <div class="carte-trajet"></div>
                <div class="carte-trajet"></div>
            </div>
        </section>

        <div class="barre-actions-inferieure">
            <button class="bouton-primaire">Tous les trajets</button>
            <button class="bouton-primaire">Gérer vos trajets</button>
        </div>
    </main>

</body>

</html>