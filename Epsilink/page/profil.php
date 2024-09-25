<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php';

// Récupérer les informations de l'utilisateur connecté
$idUser = $_SESSION['idUser'];
$sql = "SELECT * FROM utilisateur WHERE idUser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Récupérer les publications de l'utilisateur
$sqlPosts = "SELECT * FROM publication WHERE idUser = ? ORDER BY dateCreation DESC";
$stmt = $conn->prepare($sqlPosts);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$posts = $stmt->get_result();
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
    <h1>Profil de <?= $user['nomUser'] . " " . $user['prenomUser'] ?></h1>
    <p>Email : <?= $user['mailUser'] ?></p>

    <div class="my-posts">
        <h2>Mes publications</h2>
        <?php while ($post = $posts->fetch_assoc()) { ?>
            <div class="post">
                <p><?= $post['contenuPost'] ?></p>
                <small>Posté le : <?= $post['dateCreation'] ?></small>
            </div>
        <?php } ?>
    </div>
</body>
</html>
