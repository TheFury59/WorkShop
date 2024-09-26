<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php'; // Connexion à la base de données

// Vérification que l'ID du post est passé en paramètre
if (isset($_GET['id'])) {
    $idPost = intval($_GET['id']);
    $idUser = $_SESSION['idUser'];

    // Vérification si l'utilisateur a déjà liké la publication
    $checkLike = $conn->prepare("SELECT * FROM like_post WHERE idUser = ? AND idPost = ?");
    $checkLike->bind_param("ii", $idUser, $idPost);
    $checkLike->execute();
    $result = $checkLike->get_result();

    if ($result->num_rows == 0) {
        // Si l'utilisateur n'a pas encore liké, on ajoute un like
        $addLike = $conn->prepare("INSERT INTO like_post (idUser, idPost) VALUES (?, ?)");
        $addLike->bind_param("ii", $idUser, $idPost);
        if ($addLike->execute()) {
            header('Location: ../page/home.php');
            exit();
        } else {
            echo "Erreur lors de l'ajout du like.";
        }
    } else {
        // Si l'utilisateur a déjà liké, on retire le like
        $removeLike = $conn->prepare("DELETE FROM like_post WHERE idUser = ? AND idPost = ?");
        $removeLike->bind_param("ii", $idUser, $idPost);
        if ($removeLike->execute()) {
            header('Location: ../page/home.php');
            exit();
        } else {
            echo "Erreur lors de la suppression du like.";
        }
    }
} else {
    echo "ID de la publication manquant.";
}
?>
