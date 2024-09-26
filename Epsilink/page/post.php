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

    // Insertion dans la base de données (avec ou sans image)
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPSILINK - Publier</title>
    <link href="https://bootswatch.com/5/zephyr/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/pageStyle.css">
</head>
<body class="bg-light">
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
                <ul class="navbar-nav ms-auto"> <!-- Ajout de ms-auto pour aligner à droite -->
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
                        <a class="nav-link" href="../page/equipe.html">L'Équipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../include/logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Créer une nouvelle publication</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <!-- Champ texte pour la publication -->
                            <div class="mb-3">
                                <label for="contenuPost" class="form-label">Exprimez-vous</label>
                                <textarea name="contenuPost" id="contenuPost" class="form-control" rows="5" placeholder="Votre publication..." required></textarea>
                            </div>

                            <!-- Champ pour télécharger une image -->
                            <div class="mb-3">
                                <label for="imagePost" class="form-label">Ajouter une image</label>
                                <input type="file" class="form-control" id="imagePost" name="imagePost">
                            </div>

                            <button type="submit" class="btn btn-primary">Publier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
