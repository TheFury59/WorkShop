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

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contenuCommentaire = $_POST['contenuCommentaire'];

        // Insertion du commentaire dans la base de données
        $sql = "INSERT INTO commentaire (idUser, idPost, contenuComment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $idUser, $idPost, $contenuCommentaire);

        if ($stmt->execute()) {
            header('Location: ../page/home.php');
            exit();
        } else {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    }
} else {
    echo "ID de la publication manquant.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <!-- Menu latéral -->
    <div class="side-menu">
        <div id="menuBtn">
            <input type="checkbox" />
            <span></span>
            <span></span>
        </div>
        <div class="menu"></br></br></br></br></br></br></br></br>
            <a class="menu-item" href="../page/equipe.html">L'EQUIPE</a>
            <a class="menu-item" href="../page/home.php">EPSILINK</a>
            <a class="menu-item" href="../page/profil.php">MON PROFIL</a>
            <a class="menu-item" href="../page/post.php">PUBLIE</a>
            <a class="menu-item" href="../include/logout.php">DECONNECTION</a>
        </div>
        <div class="straight-line"></div>
    </div>
    <?php

    if (isset($_GET['id'])) {
        $idPost = intval($_GET['id']);
        $idUser = $_SESSION['idUser'];
    }



    $sql = "SELECT commentaire.*, utilisateur.nomUser, utilisateur.prenomUser 
    FROM commentaire 
    JOIN utilisateur ON commentaire.idUser = utilisateur.idUser 
    WHERE idComment = $idPost
    ORDER BY publication.dateCreation DESC";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("id",$idPost);
    $result = $conn->query($stmt);

?>
    <div class="feed">
        <h2>Fil d'actualité</h2>
        <?php while ($post = $result->fetch_assoc()) { ?>
            <div class="post">
                <h3><?php $post['nomUser'] . " " . $post['prenomUser'] ?></h3>
                <p><?php $post['contenuComment'] ?></p>
                <small>Posté le : <?php $post['dateCreation'] ?></small>
            </div>
        <?php } ?>
    </div>
</body>
</html>
