<?php
require_once "../include/protectUser.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un trajet - Carpool</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/ajoutTrajets.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body class="page-specifique">

    <header class="en-tete">
        <div class="logo">CARPOOL</div>
        <div class="profil-utilisateur">
            <span class="nom-utilisateur">M. Doe</span>
            <div class="avatar"></div>
            <span class="icone-menu">▼</span>
        </div>
    </header>

    <main class="conteneur-central">
        <h1 class="titre-page">Ajoutez un trajet</h1>

        <form class="formulaire" action="processTrajets.php" method="post" enctype="multipart/form-data">
            <div class="groupe-saisie">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" class="champ-texte">
            </div>

            <div class="groupe-saisie">
                <label for="date">Date :</label>
                <div class="champ-date-visuel">
                    <input type="date" id="date" name="date" class="sous-champ-date">
                </div>
            </div>

            <div class="groupe-saisie-ligne">
                <label for="heure">Heure de départ :</label>
                <input type="time" name="heure" id="heure" class="champ-heure">
            </div>

            <div class="groupe-saisie">
                <label>Nombre de passagers :</label>
                <div class="selecteur-passagers">
                    <input type="radio" name="passager_max" id="p1" value="1">
                    <label for="p1" class="bouton-passager">1</label>

                    <input type="radio" name="passager_max" id="p2" value="2">
                    <label for="p2" class="bouton-passager">2</label>

                    <input type="radio" name="passager_max" id="p3" value="3">
                    <label for="p3" class="bouton-passager">3</label>

                    <input type="radio" name="passager_max" id="p4" value="4" checked>
                    <label for="p4" class="bouton-passager">4</label>
                </div>
            </div>
            <button type="submit" class="bouton-primaire bouton-large">Sauvegarder</button>
        </form>
    </main>

</body>

</html>