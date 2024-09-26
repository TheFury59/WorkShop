<?php
session_start();

if (isset($_SESSION['idUser'])) {
    $idUser = $_SESSION['idUser']; // Sauvegarder l'ID utilisateur avant de détruire la session
    require 'bd.php';
    
    if (isset($_COOKIE['user_token'])) {
        setcookie("user_token", "", time() - 3600, "/"); // Expirer le cookie
        
        // Supprimer le token de la base de données
        $sql = "UPDATE utilisateur SET remember_token = NULL WHERE idUser = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $stmt->close();
    }
    
    session_unset();
    session_destroy();
}

header("Location: ../index.php");
exit();
?>
