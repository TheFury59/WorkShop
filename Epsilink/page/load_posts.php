<?php
require '../include/bd.php'; // Connexion à la base de données

// Récupérer les publications de tous les utilisateurs
$sql = "SELECT publication.*, utilisateur.nomUser, utilisateur.prenomUser, utilisateur.photoProfil
        FROM publication 
        JOIN utilisateur ON publication.idUser = utilisateur.idUser 
        ORDER BY publication.dateCreation DESC";
$result = $conn->query($sql);
?>

<style>
/* Insertion du CSS directement ici */
.img-fluid {
    width: 300px; /* Largeur fixe pour les images carrées */
    height: 300px; /* Hauteur fixe */
    object-fit: cover; /* Assurer que l'image reste proportionnelle */
    border-radius: 0; /* Supprimer les coins arrondis */
}

.rounded-circle {
    object-fit: cover;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
</style>

<?php
while ($post = $result->fetch_assoc()) {
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex">
                <!-- Afficher la photo de profil -->
                <?php if ($post['photoProfil']) : ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($post['photoProfil']) ?>" alt="Avatar" class="rounded-circle me-3" width="50">
                <?php else : ?>
                    <img src="../img/default.png" alt="Avatar" class="rounded-circle me-3" width="50">
                <?php endif; ?>
                <div>
                    <h5 class="card-title"><?= htmlspecialchars($post['nomUser']) . " " . htmlspecialchars($post['prenomUser']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($post['contenuPost']) ?></p>

                    <!-- Afficher l'image de la publication si elle existe -->
                    <?php if ($post['imagePost']) : ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($post['imagePost']) ?>" class="img-fluid mt-3" alt="Image de publication">
                    <?php endif; ?>

                    <!-- Afficher les hashtags -->
                    <?php if ($post['campusHashtag']) : ?>
                        <p class="mt-2"><strong>Campus:</strong> <?= htmlspecialchars($post['campusHashtag']) ?></p>
                    <?php endif; ?>

                    <small class="text-muted">Posté le : <?= $post['dateCreation'] ?></small>
                    <div class="mt-2">
                        <a href="../include/like.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-hand-thumbs-up"></i> Aimer
                        </a>
                        <a href="comment.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-chat"></i> Commenter
                        </a>
                        <a href="seeComment.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-chat"></i> Voir les commentaires
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
