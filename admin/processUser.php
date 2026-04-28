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

// récupération des données
$id = isset($_POST["id"]) && !empty($_POST["id"]) ? $_POST["id"] : null;
$firstname = isset($_POST["firstname"]) ? trim($_POST["firstname"]) : '';
$lastname = isset($_POST["lastname"]) ? trim($_POST["lastname"]) : '';
$mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : '';
$password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
$ville = isset($_POST["ville"]) ? trim($_POST["ville"]) : '';
$contact = isset($_POST["contact"]) ? trim($_POST["contact"]) : '';

if ($id) {
    // UPDATE
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // si le mdp est rempli on le met à jour
        $sql = "UPDATE `users` SET `users_firstname` = :firstname, `users_lastname` = :lastname, `users_mail` = :mail, `users_pwd` = :password, `users_ville` = :ville, `users_contact` = :contact WHERE `users_id` = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'password' => $hashed_password, 'ville' => $ville, 'contact' => $contact, 'id' => $id]);
    } else {
        // si il est vide on met à jour sauf le mdp
        $sql = "UPDATE `users` SET `users_firstname` = :firstname, `users_lastname` = :lastname, `users_mail` = :mail, `users_ville` = :ville, `users_contact` = :contact WHERE `users_id` = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'ville' => $ville, 'contact' => $contact, 'id' => $id]);
    }
} else {
    // INSERT
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (`users_firstname`, `users_lastname`, `users_mail`, `users_pwd`, `users_ville`, `users_contact`, `users_is_admin`) 
            VALUES (:firstname, :lastname, :mail, :password, :ville, :contact, 0)";
    $stmt = $db->prepare($sql);
    $stmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'mail' => $mail, 'password' => $hashed_password, 'ville' => $ville, 'contact' => $contact]);
}

header("Location: gestionUsers.php");
exit;
?>