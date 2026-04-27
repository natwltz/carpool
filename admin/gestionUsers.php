<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/protectUser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/connect.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "../include/function.php";

// vérification admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    header("Location: ../users/home.php");
    exit;
}

// Requête pour récupérer tous les utilisateurs
$stmt = $db->prepare("
    SELECT users_id, users_firstname, users_lastname, users_mail, users_is_admin 
    FROM users 
    ORDER BY users_id DESC
");
$stmt->execute();
$recordset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs - Carpool Admin</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/gestionUser.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="page-specifique">

    <?php require_once "../include/header.php"; ?>

    <main class="conteneur-large">

        <div class="entete-section">
            <h1 class="titre-page">Gérer les utilisateurs :</h1>
            <a href="modifUser.php">
                <button class="bouton-icone" title="Ajouter un utilisateur">+</button>
            </a>
        </div>

        <div class="conteneur-table">
            <table class="table-crud">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PRÉNOM</th>
                        <th>NOM</th>
                        <th>EMAIL</th>
                        <th>RÔLE</th>
                        <th>OPÉRATIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recordset as $row) { ?>
                        <tr>
                            <td><?= hsc($row["users_id"]); ?></td>
                            <td><?= hsc($row["users_firstname"]); ?></td>
                            <td><?= hsc($row["users_lastname"]); ?></td>
                            <td><?= hsc($row["users_mail"]); ?></td>
                            <td><?= $row["users_is_admin"] ? 'Administrateur' : 'Utilisateur'; ?></td>
                            <td>
                                <div class="actions-tableau">
                                    <form action="modifUser.php" method="post" class="form-action">
                                        <input type="hidden" name="id" value="<?= hsc($row["users_id"]); ?>">
                                        <button type="submit" class="bouton-action bouton-modifier" title="Modifier">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </form>
                                    <!-- Bouton déclenchant la modale JS -->
                                    <button type="button" class="bouton-action bouton-supprimer" title="Supprimer" onclick="ouvrirModal(<?= hsc($row['users_id']); ?>)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modale de confirmation de suppression -->
    <div id="modal-suppression" class="modal">
        <div class="modal-contenu">
            <span class="fermer-modal-croix" onclick="fermerModal()">&times;</span>
            <h2 style="margin-bottom: 15px; color: var(--couleur-texte);">Confirmer la suppression</h2>
            <p style="margin-bottom: 20px; color: #555;">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
            <form action="supprUser.php" method="post" id="form-suppression">
                <input type="hidden" name="id" id="modal-user-id" value="">
                <button type="submit" class="bouton-primaire bouton-modal-confirmer" style="background-color: #e53935; border-color: #c62828;">Supprimer définitivement</button>
                <button type="button" class="bouton-secondaire bouton-modal-annuler" onclick="fermerModal()">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-suppression');
        const inputId = document.getElementById('modal-user-id');

        function ouvrirModal(id) {
            inputId.value = id;
            modal.style.display = 'flex';
        }

        function fermerModal() {
            modal.style.display = 'none';
            inputId.value = '';
        }

        // Fermer la modale si on clique en dehors de la boîte de dialogue
        window.onclick = function(event) {
            if (event.target === modal) {
                fermerModal();
            }
        }
    </script>
</body>

</html>