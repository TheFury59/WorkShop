<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ../index.php');
    exit();
}

require '../include/bd.php'; // fichier de connexion à la base de données

// Récupérer les informations de l'utilisateur connecté pour afficher la photo de profil dans la zone de publication
$idUser = $_SESSION['idUser'];
$sqlUser = "SELECT photoProfil FROM utilisateur WHERE idUser = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $idUser);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
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
                        <a class="nav-link" href="equipe.html">L'Equipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../include/logout.php">Déconnexion</a>
                    </li>
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
                        <form id="publicationForm" method="POST" enctype="multipart/form-data">
                            <div class="d-flex mb-3">
                                <!-- Afficher la photo de profil dans la zone de publication -->
                                <?php if ($user['photoProfil']) : ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($user['photoProfil']) ?>" alt="Avatar" class="rounded-circle me-3" width="50">
                                <?php else : ?>
                                    <img src="../img/default.png" alt="Avatar" class="rounded-circle me-3" width="50">
                                <?php endif; ?>
                                <textarea class="form-control" name="contenuPost" placeholder="Écrire une publication..." rows="2" required></textarea>
                            </div>

                            <!-- Ajout d'image -->
                            <div class="mb-3">
                                <label for="imagePost" class="form-label">Ajouter une image</label>
                                <input type="file" class="form-control" id="imagePost" name="imagePost">
                            </div>

                            <!-- Sélection du campus -->
                            <div class="mb-3">
                                <label for="campusHashtag" class="form-label">Sélectionner le campus (Hashtag)</label>
                                <select class="form-control" name="campusHashtag" id="campusHashtag" required>
                                    <option value="#EPSI_Arras">#EPSI_Arras</option>
                                    <option value="#EPSI_Bordeaux">#EPSI_Bordeaux</option>
                                    <option value="#EPSI_Lille">#EPSI_Lille</option>
                                    <option value="#EPSI_Paris">#EPSI_Paris</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Publier</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Affichage des publications -->
                <div class="feed">
                    <!-- Les publications seront chargées ici via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript pour le chargement des publications et soumission via AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadPosts(); // Charger les publications lors du chargement de la page

            const form = document.getElementById('publicationForm');

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Empêche l'envoi normal du formulaire

                const formData = new FormData(form);

                fetch('../include/post_publication.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    form.reset(); // Réinitialiser le formulaire
                    loadPosts(); // Recharger les publications
                })
                .catch(error => {
                    console.error('Erreur lors de la soumission :', error);
                });
            });
        });

        function loadPosts() {
            fetch('load_posts.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.feed').innerHTML = data;
            })
            .catch(error => {
                console.error('Erreur lors du chargement des publications :', error);
            });
        }
    </script>
</body>
</html>
