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

    $sql = "INSERT INTO publication (idUser, contenuPost) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $idUser, $contenuPost);

    if ($stmt->execute()) {
        header('Location: ../page/home.php');
        exit();
    } else {
        echo "Erreur lors de la publication.";
    }
}
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
            <a class="menu-item" href="../page/equipe.html">L'EQUIPE</a>
            <a class="menu-item" href="../page/home.php">EPSILINK</a>
            <a class="menu-item" href="../page/profil.php">MON PROFIL</a>
            <a class="menu-item" href="../page/post.php">PUBLIE</a>
            <a class="menu-item" href="../include/logout.php">DECONNECTION</a>
        </div>
        <div class="straight-line"></div>
    </div>
    <h1>Créer une nouvelle publication</h1>

    <form method="POST">
        <textarea name="contenuPost" rows="5" placeholder="Exprimez-vous..."></textarea>
        <button type="submit">Publier</button>
    </form>
</body>
</html>
