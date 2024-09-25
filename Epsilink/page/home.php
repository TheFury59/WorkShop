<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php'; // fichier de connexion à la base de données

// Récupérer les publications de tous les utilisateurs
$sql = "SELECT publication.*, utilisateur.nomUser, utilisateur.prenomUser 
        FROM publication 
        JOIN utilisateur ON publication.idUser = utilisateur.idUser 
        ORDER BY publication.dateCreation DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPSILINK</title>
    <link rel="stylesheet" href="../style/style.css">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js"></script>
    <script defer src="../js/main.js"></script>
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
            <a class="menu-item" href="../index.php">ACCUEIL</a>
            <a class="menu-item" href="/equipe.html">L'EQUIPE</a>
            <a class="menu-item" href="/home.php">EPSILINK</a>
            <a class="menu-item" href="/profil.php">MON PROFIL</a>
            <a class="menu-item" href="/post.php">PUBLIE</a>
            <a class="menu-item" href="../include/logout.php">DECONNECTION</a>
        </div>
        <div class="straight-line"></div>
    </div>
    <h1>Bienvenue sur EpsiLink, <?= $_SESSION['nomUser'] ?></h1>

    <div class="post">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $contenuPost = $_POST['contenuPost'];
            $idUser = $_SESSION['idUser'];

            $sql = "INSERT INTO publication (idUser, contenuPost) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $idUser, $contenuPost);

            if ($stmt->execute()) {
                header('Location: ../page/home.php');
                exit();
            }
            else {
                echo "Erreur lors de la publication.";
            }
        }
    ?>
    </div>
    <div class="feed">
        <h2>Fil d'actualité</h2>
        <?php while ($post = $result->fetch_assoc()) { ?>
            <div class="post">
                <h3><?= $post['nomUser'] . " " . $post['prenomUser'] ?></h3>
                <p><?= $post['contenuPost'] ?></p>
                <small>Posté le : <?= $post['dateCreation'] ?></small>
                <a href="like.php?id=<?= $post['idPost'] ?>">Aimer</a> | 
                <a href="comment.php?id=<?= $post['idPost'] ?>">Commenter</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
