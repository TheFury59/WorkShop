<?php
    if (file_exists('pdoepsilink.php')) {
        require_once 'pdoepsilink.php';
        // echo "Le fichier est bien include";
    } else {
        echo "Le fichier pdoepsilink.php est introuvable.";
    }
    
    session_start();
    
    // $_POST['connection'];
    $mail = $_POST['mail'];
    $mdp = $_POST['password'];
    // echo $mail;
    // echo $mdp;
    $pdoEpsiLink = PdoEpsiLink::getPdoEpsiLink();

    // Utiliser la méthode checkUser
    if ($pdoEpsiLink->checkUser($mail, $mdp)) {
        echo "Utilisateur reconnu";
    } else {
        echo "Utilisateur non reconnu";
    }
    
?>