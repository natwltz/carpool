<header class="en-tete">
    <a href="home.php">
        <div class="logo">CARPOOL</div>
    </a>
    <div class="profil-utilisateur">
        <span class="nom-utilisateur">
            <?= htmlspecialchars($_SESSION['users_firstname'] ?? '') . ' ' . htmlspecialchars($_SESSION['users_lastname'] ?? '') ?>
        </span>
        <div class="avatar"></div>
        <span class="icone-menu" id="bouton-menu-profil">▼</span>
        
        <div class="menu-deroulant" id="menu-profil">
            <a href="../users/modifProfil.php" class="lien-menu">Mon profil</a>
            <a href="../users/logout.php" class="lien-deconnexion">Se déconnecter</a>
        </div>
    </div>
</header>

<script>
    // script pour ouvrir/fermer le menu déroulant au clic sur la flèche
    document.getElementById('bouton-menu-profil').addEventListener('click', function(e) {
        e.stopPropagation(); // Empêche le clic de se propager au document
        let menu = document.getElementById('menu-profil');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });

    // ferme le menu automatiquement si l'utilisateur clique ailleurs sur la page
    window.addEventListener('click', function() {
        let menu = document.getElementById('menu-profil');
        if (menu && menu.style.display === 'block') {
            menu.style.display = 'none';
        }
    });
</script>