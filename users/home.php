<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarPool Home</title>
</head>
<body>

    <div style="width: 100%; max-width: 900px;">
        <h1>Covoiturage entre collègues :<br>simplifiez vos trajets</h1>
    </div>

    <div class="search-container">
        <form class="search-form" action="/recherche" method="GET">
            <input type="text" class="search-input" name="depart" placeholder="départ">
            <button type="submit" class="search-btn">rechercher</button>
        </form>

        <button class="btn-teal">+ publier un trajet</button>
    </div>

    <div class="content-area">
        <h2>Dernier trajet disponible :</h2>

        <div class="grid-container">
            <div class="placeholder-card"></div>
            <div class="placeholder-card"></div>
            <div class="placeholder-card"></div>
            <div class="placeholder-card"></div>
        </div>

        <div class="bottom-actions">
            <button class="btn-teal">Tout les trajets</button>
            <button class="btn-teal">Gérer vos trajets</button>
        </div>
    </div>

</body>
</html>