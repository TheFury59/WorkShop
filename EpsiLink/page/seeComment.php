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
            header('Location: seeComment.php?id='.$idPost); // Redirection vers la même page après ajout
            exit();
        } else {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    }
} else {
    echo "ID de la publication manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires</title>
    <link href="https://bootswatch.com/5/zephyr/bootstrap.min.css" rel="stylesheet"> <!-- Utilisation de Bootstrap -->
    <link rel="stylesheet" href="../style/pageStyle.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <img src="../img/Epsi.png" alt="Logo" width="50" height="40" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <form class="d-flex">
                <input class="form-control me-sm-2" type="search" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="../page/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../page/post.php">Publier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../page/profil.php">Mon Compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../page/equipe.html">L' Equipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../include/logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Commentaires</h2>

        <?php
        // Récupérer les commentaires associés au post
        $sql = "SELECT commentaire.*, utilisateur.nomUser, utilisateur.prenomUser, utilisateur.photoProfil 
                FROM commentaire 
                JOIN utilisateur ON commentaire.idUser = utilisateur.idUser 
                WHERE commentaire.idPost = ? 
                ORDER BY commentaire.dateCreation DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPost);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <div class="feed">
            <?php while ($comment = $result->fetch_assoc()) { ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex">
                            <!-- Affichage de la photo de profil en base64 (ou image par défaut) -->
                            <?php if ($comment['photoProfil']) : ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($comment['photoProfil']) ?>" alt="Avatar" class="rounded-circle me-3" width="50">
                            <?php else : ?>
                                <img src="../img/default.png" alt="Avatar" class="rounded-circle me-3" width="50">
                            <?php endif; ?>
                            <div>
                                <h5 class="card-title"><?= htmlspecialchars($comment['nomUser'] . " " . $comment['prenomUser']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($comment['contenuComment']) ?></p>
                                <small class="text-muted">Posté le : <?= htmlspecialchars($comment['dateCreation']) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Formulaire pour ajouter un commentaire -->
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <textarea name="contenuCommentaire" class="form-control" rows="3" placeholder="Ajouter un commentaire..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Commenter</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
