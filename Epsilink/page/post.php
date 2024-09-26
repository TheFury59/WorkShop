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
                    <a class="nav-link active" href="../page/home.php">Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page/post.php">Publier
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page/profil.php">Mon Compte
                    </a>
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
    <h1>Créer une nouvelle publication</h1>

    <form method="POST">
        <textarea name="contenuPost" rows="5" placeholder="Exprimez-vous..."></textarea>
        <button type="submit">Publier</button>
    </form>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>
