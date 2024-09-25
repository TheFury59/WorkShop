<?php
$servername = "localhost"; // Remplace par les informations de connexion correctes
$username = "root";
$password = "";
$dbname = "epsilink"; // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
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
    $nom = $_POST['nom'];
    $prenom = $_POST['Prenom'];
    $tel = $_POST['tel'];
    // echo $mail;
    // echo $mdp;
    $pdoEpsiLink = PdoEpsiLink::getPdoEpsiLink();

    // Utiliser la méthode checkUser
    if($pdoEpsiLink->creeUser($mail, $mdp,$nom,$prenom,$tel)) 
        echo "utilisateur créé";
?>