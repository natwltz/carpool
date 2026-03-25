<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

$stmt = $db->prepare("
    SELECT 
    t.trajet_ville,
    t.trajet_date,
    u_conducteur.users_firstname AS prenom_conducteur,
    u1.users_firstname AS passager_1,
    u2.users_firstname AS passager_2,
    u3.users_firstname AS passager_3,
    u4.users_firstname AS passager_4
    FROM `trajet` t
    RIGHT JOIN `passager` p ON p.passager_trajet_id = t.trajet_id
    LEFT JOIN `users` u_conducteur ON t.trajet_users_id = u_conducteur.users_id
    LEFT JOIN `users` u1 ON p.passager_un_users_id = u1.users_id
    LEFT JOIN `users` u2 ON p.passager_deux_users_id = u2.users_id
    LEFT JOIN `users` u3 ON p.passager_trois_users_id = u3.users_id
    LEFT JOIN `users` u4 ON p.passager_quatre_users_id = u4.users_id;
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

    <main class="conteneur-large">
        
        <div class="entete-section">
            <h1 class="titre-page">Gérer vos trajets :</h1>
            <button class="bouton-icone" title="Ajouter un trajet">+</button>
        </div>

        <div class="conteneur-table">
            <table class="table-crud">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VILLE</th>
                        <th>DATE</th>
                        <th>HEURE</th>
                        <th>NB PASSAGER</th>
                        <th>NB PASSAGER RESTANT</th>
                        <th>P1</th>
                        <th>P2</th>
                        <th>P3</th>
                        <th>P4</th>
                        <th>OPERATIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>X</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>X</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>X</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>X</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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