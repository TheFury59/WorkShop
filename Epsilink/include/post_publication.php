<?php
session_start();
require 'bd.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contenuPost = $_POST['contenuPost'];
    $idUser = $_SESSION['idUser'];
    $campusHashtag = $_POST['campusHashtag'];

    // Gestion de l'image (si une image est uploadée)
    $imagePost = null;
    if (isset($_FILES['imagePost']) && $_FILES['imagePost']['error'] == 0) {
        $imagePost = file_get_contents($_FILES['imagePost']['tmp_name']);
    }

    // Préparer la requête SQL avec image et hashtag du campus
    $sql = "INSERT INTO publication (idUser, contenuPost, imagePost, campusHashtag) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $idUser, $contenuPost, $imagePost, $campusHashtag);

    if ($stmt->execute()) {
        echo "Publication réussie";
    } else {
        echo "Erreur lors de la publication.";
    }
}
?>
