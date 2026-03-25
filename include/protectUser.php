<?php
session_start();

// Si la variable de session n'existe pas ou n'est pas égale à "ok", l'accès est refusé
if (!isset($_SESSION["users_connected"]) || $_SESSION["users_connected"] !== "ok") {
    header("Location: ../index.php");
    exit; // important pour empêcher le reste de la page de s'afficher
}
?>