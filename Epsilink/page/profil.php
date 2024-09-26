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
        $sql = "UPDATE utilisateur SET nomUser=?, prenomUser=?, mailUser=? WHERE idUser=?";
        $stmt->bind_param("sssi", $nomUser, $prenomUser, $mailUser, $idUser);
    }

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit();
    }
}

// Gestion de la suppression de publication
if (isset($_GET['deletePost'])) {
    $postId = $_GET['deletePost'];
    $sqlDelete = "DELETE FROM publication WHERE idPost = ? AND idUser = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("ii", $postId, $idUser);
    if ($stmt->execute()) {
        header("Location: profil.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du post.";
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

// Gestion de la modification de publication
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPost'])) {
    $postId = $_POST['postId'];
    $newContent = $_POST['contenuPost'];
    $imagePost = null;

    // Gestion de l'image si elle est modifiée
    if (isset($_FILES['imagePost']) && $_FILES['imagePost']['error'] == 0) {
        $imagePost = file_get_contents($_FILES['imagePost']['tmp_name']);
    }

    // Mise à jour avec ou sans image
    if ($imagePost) {
        $sqlUpdatePost = "UPDATE publication SET contenuPost = ?, imagePost = ? WHERE idPost = ? AND idUser = ?";
        $stmt = $conn->prepare($sqlUpdatePost);
        $stmt->bind_param("sbii", $newContent, $imagePost, $postId, $idUser);
    } else {
        $sqlUpdatePost = "UPDATE publication SET contenuPost = ? WHERE idPost = ? AND idUser = ?";
        $stmt->bind_param("sii", $newContent, $postId, $idUser);
    }

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du post.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlspecialchars($user['prenomUser']) ?></title>
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
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">Publier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Mon Compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="equipe.html">L'Équipe</a>
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
                    <h1><?= htmlspecialchars($user['nomUser'] . " " . $user['prenomUser']) ?></h1>
                    <p>Email : <?= htmlspecialchars($user['mailUser']) ?></p>
                </div>
            </div>
        </div>

        <!-- Formulaire de mise à jour du profil -->
        <div class="profile-content mt-4">
            <h2>Modifier vos informations</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nomUser" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nomUser" name="nomUser" value="<?= htmlspecialchars($user['nomUser']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenomUser" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenomUser" name="prenomUser" value="<?= htmlspecialchars($user['prenomUser']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mailUser" class="form-label">Email</label>
                    <input type="email" class="form-control" id="mailUser" name="mailUser" value="<?= htmlspecialchars($user['mailUser']) ?>" required>
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
                    <p><?= htmlspecialchars($post['contenuPost']) ?></p>

                    <!-- Affichage de l'image de la publication -->
                    <?php if ($post['imagePost']) : ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($post['imagePost']) ?>" class="img-fluid mt-3" alt="Image de publication">
                    <?php endif; ?>

                    <small class="text-muted">Posté le : <?= htmlspecialchars($post['dateCreation']) ?></small>

                    <!-- Actions de modification et suppression -->
                    <div class="mt-2">
                        <a href="profil.php?editPost=<?= $post['idPost'] ?>" class="btn btn-secondary btn-sm">Modifier</a>
                        <a href="profil.php?deletePost=<?= $post['idPost'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </div>
                </div>
            <?php } ?>

            <!-- Si un post est en cours de modification -->
            <?php if (isset($_GET['editPost'])) {
                $postId = $_GET['editPost'];
                $sqlGetPost = "SELECT * FROM publication WHERE idPost = ? AND idUser = ?";
                $stmt = $conn->prepare($sqlGetPost);
                $stmt->bind_param("ii", $postId, $idUser);
                $stmt->execute();
                $editPost = $stmt->get_result()->fetch_assoc();
            ?>
                <div class="post bg-light p-3 mt-3 rounded shadow-sm">
                    <h3>Modifier la publication</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="postId" value="<?= $editPost['idPost'] ?>">
                        <div class="mb-3">
                            <label for="contenuPost" class="form-label">Contenu</label>
                            <textarea name="contenuPost" id="contenuPost" class="form-control" rows="3"><?= htmlspecialchars($editPost['contenuPost']) ?></textarea>
                        </div>

                        <!-- Modification de l'image -->
                        <div class="mb-3">
                            <label for="imagePost" class="form-label">Modifier l'image</label>
                            <input type="file" class="form-control" id="imagePost" name="imagePost">
                        </div>

                        <button type="submit" name="editPost" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
