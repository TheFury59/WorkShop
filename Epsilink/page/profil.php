<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php';

$idUser = $_SESSION['idUser'];

// Mise à jour des informations utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $nomUser = $_POST['nomUser'];
    $prenomUser = $_POST['prenomUser'];
    $mailUser = $_POST['mailUser'];

    // Gestion de la photo de profil en BLOB
    $photoProfil = null;
    if (isset($_FILES['photoProfil']) && $_FILES['photoProfil']['error'] == 0) {
        $photoProfil = file_get_contents($_FILES['photoProfil']['tmp_name']);
    }

    // Si la photo est fournie, on la met à jour avec un BLOB
    if ($photoProfil) {
        $sql = "UPDATE utilisateur SET nomUser=?, prenomUser=?, mailUser=?, photoProfil=? WHERE idUser=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nomUser, $prenomUser, $mailUser, $photoProfil, $idUser);
    } else {
        // Si aucune nouvelle photo n'est fournie, on ne met à jour que les autres informations
        $sql = "UPDATE utilisateur SET nomUser=?, prenomUser=?, mailUser=? WHERE idUser=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nomUser, $prenomUser, $mailUser, $idUser);
    }

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit();
    }
}

// Récupérer les informations de l'utilisateur
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

// Suppression de publication
if (isset($_GET['deletePost'])) {
    $postId = $_GET['deletePost'];
    $sqlDelete = "DELETE FROM publication WHERE idPost = ? AND idUser = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("ii", $postId, $idUser);
    $stmt->execute();
    header("Location: profil.php");
    exit();
}

// Modification de publication
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPost'])) {
    $postId = $_POST['postId'];
    $newContent = $_POST['contenuPost'];
    $sqlUpdatePost = "UPDATE publication SET contenuPost = ? WHERE idPost = ? AND idUser = ?";
    $stmt = $conn->prepare($sqlUpdatePost);
    $stmt->bind_param("sii", $newContent, $postId, $idUser);
    $stmt->execute();
    header("Location: profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $user['prenomUser'] ?></title>
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

    <!-- Section Profil -->
    <div class="container mt-4">
        <div class="profile-header bg-primary text-white p-3 rounded">
            <div class="info d-flex align-items-center">
                <!-- Afficher la photo de profil en tant que BLOB -->
                <?php if ($user['photoProfil']) : ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($user['photoProfil']) ?>" alt="Photo de profil" class="rounded-circle" width="100">
                <?php else : ?>
                    <img src="../img/default.png" alt="Photo de profil" class="rounded-circle" width="100">
                <?php endif; ?>
                <div class="ms-3">
                    <h1><?= $user['nomUser'] . " " . $user['prenomUser'] ?></h1>
                    <p>Email : <?= $user['mailUser'] ?></p>
                </div>
            </div>
        </div>

        <!-- Formulaire de mise à jour du profil -->
        <div class="profile-content mt-4">
            <h2>Modifier vos informations</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nomUser" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nomUser" name="nomUser" value="<?= $user['nomUser'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenomUser" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenomUser" name="prenomUser" value="<?= $user['prenomUser'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mailUser" class="form-label">Email</label>
                    <input type="email" class="form-control" id="mailUser" name="mailUser" value="<?= $user['mailUser'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="photoProfil" class="form-label">Photo de profil</label>
                    <input type="file" class="form-control" id="photoProfil" name="photoProfil">
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>

        <!-- Mes publications -->
        <div class="profile-content mt-4">
            <h2>Mes publications</h2>
            <?php while ($post = $posts->fetch_assoc()) { ?>
                <div class="post bg-white p-3 mb-3 rounded shadow-sm">
                    <p><?= $post['contenuPost'] ?></p>
                    <small class="text-muted">Posté le : <?= $post['dateCreation'] ?></small>
                    <!-- Actions de modification et suppression -->
                    <div class="mt-2">
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="postId" value="<?= $post['idPost'] ?>">
                            <input type="text" name="contenuPost" class="form-control mb-2" value="<?= $post['contenuPost'] ?>">
                            <button type="submit" name="editPost" class="btn btn-secondary btn-sm">Modifier</button>
                        </form>
                        <a href="profil.php?deletePost=<?= $post['idPost'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
