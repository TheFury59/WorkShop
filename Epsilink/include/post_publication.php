<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contenuPost = $_POST['contenuPost'];
    $idUser = $_SESSION['idUser'];

    // Gestion de l'image de publication
    $imagePost = null;
    if (isset($_FILES['imagePost']) && $_FILES['imagePost']['error'] == 0) {
        $imagePost = file_get_contents($_FILES['imagePost']['tmp_name']);
    }

    // Insertion dans la base de données (avec image si présente)
    $sql = "INSERT INTO publication (idUser, contenuPost, imagePost) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $idUser, $contenuPost, $imagePost);

    if ($stmt->execute()) {
        header('Location: ../page/home.php');
        exit();
    } else {
        echo "Erreur lors de la publication.";
    }
}
?>
