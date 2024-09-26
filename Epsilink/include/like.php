<?php
session_start();
require '../include/bd.php'; // Connexion à la base de données

if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

$idUser = $_SESSION['idUser'];
$idPost = $_GET['id'];

// Vérifier si l'utilisateur a déjà aimé le post
$sql = "SELECT * FROM like_post WHERE idUser = ? AND idPost = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idUser, $idPost);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si l'utilisateur a déjà aimé, on supprime le "like"
    $sql = "DELETE FROM like_post WHERE idUser = ? AND idPost = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUser, $idPost);
    $stmt->execute();
} else {
    // Sinon, on ajoute un "like"
    $sql = "INSERT INTO like_post (idUser, idPost) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUser, $idPost);
    $stmt->execute();
}

// Rediriger l'utilisateur à la page d'accueil après avoir cliqué sur "j'aime"
header("Location: ../page/home.php");
exit();
?>
