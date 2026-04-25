<?php
session_start();

// Détruit toutes les données de la session
session_unset();
session_destroy();

// Redirige vers la page de connexion à la racine
header("Location: ../index.php");
exit;
?>