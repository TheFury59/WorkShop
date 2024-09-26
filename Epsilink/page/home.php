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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPSILINK</title>
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
                    <a class="nav-link active" href="#">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page/post.php">Publier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page/profil.php">Mon Compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../include/logout.php">Déconection</a>
                </li>
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </li>-->
            </ul>
        </div>
    </div>
</nav>

    <!-- Container principal -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar gauche -->
            <div class="col-md-3">
                <div class="bg-warning p-3 rounded">
                    <h5 class="text-dark">Les Campus</h5>
                    <ul class="list-unstyled">
                        <li class="my-2"><a href="#">EPSI Arras</a></li>
                        <li class="my-2"><a href="#">EPSI France</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-9">
                <!-- Ecrire une publication -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="d-flex mb-3">
                                <img src="../img/profile.png" alt="Avatar" class="rounded-circle me-3" width="50">
                                <textarea class="form-control" name="contenuPost" placeholder="Écrire une publication..." rows="2"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-light">
                                        <i class="bi bi-image"></i> Image
                                    </button>
                                    <button type="button" class="btn btn-light">
                                        <i class="bi bi-calendar"></i> Événement
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary">Publier</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Affichage des publications -->
                <div class="feed">
                    <h2>Fil d'actualité</h2>
                    <?php while ($post = $result->fetch_assoc()) { ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex">
                                    <img src="../img/profile.png" alt="Avatar" class="rounded-circle me-3" width="50">
                                    <div>
                                        <h5 class="card-title"><?= $post['nomUser'] . " " . $post['prenomUser'] ?></h5>
                                        <p class="card-text"><?= $post['contenuPost'] ?></p>
                                        <small class="text-muted">Posté le : <?= $post['dateCreation'] ?></small>
                                        <div class="mt-2">
                                            <a href="../include/like.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                                                <i class="bi bi-hand-thumbs-up"></i> Aimer
                                            </a>
                                            <a href="comment.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                                                <i class="bi bi-chat"></i> Commenter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Traitement du formulaire de publication
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
