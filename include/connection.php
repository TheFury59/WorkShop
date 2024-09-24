<?php
    require_once('pdoepsilink.php');
    session_start();
    
    // $_POST['connection'];
    $mail = $_POST['mail'];
    $mdp = $_POST['password'];
    // echo $mail;
    // echo $mdp;
    checkUser($mail,$mdp);
?>