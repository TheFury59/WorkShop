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
            header('Location: seeComment.php');
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
    <title>Commenter</title>
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

    <h1>Ajouter un commentaire</h1>

    <form method="POST">
        <textarea name="contenuCommentaire" rows="5" placeholder="Votre commentaire..." required></textarea>
        <button type="submit">Commenter</button>
    </form>
</body>
</html>