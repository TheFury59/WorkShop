<?php
require '../include/bd.php'; // Connexion à la base de données

// Récupérer les publications de tous les utilisateurs
$sql = "SELECT publication.*, utilisateur.nomUser, utilisateur.prenomUser, utilisateur.photoProfil, 
               (SELECT COUNT(*) FROM like_post WHERE like_post.idPost = publication.idPost) AS likeCount
        FROM publication 
        JOIN utilisateur ON publication.idUser = utilisateur.idUser 
        ORDER BY publication.dateCreation DESC";
$result = $conn->query($sql);

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
                        <!-- Lien pour déclencher le modal -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal-<?= $post['idPost'] ?>">
                            <img src="data:image/jpeg;base64,<?= base64_encode($post['imagePost']) ?>" class="img-fluid mt-3" alt="Image de publication">
                        </a>

                        <!-- Modal pour afficher l'image en taille réelle -->
                        <div class="modal fade" id="imageModal-<?= $post['idPost'] ?>" tabindex="-1" aria-labelledby="imageModalLabel-<?= $post['idPost'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: none;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel-<?= $post['idPost'] ?>">Image de publication</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($post['imagePost']) ?>" class="img-modal" id="image-modal-<?= $post['idPost'] ?>" alt="Image de publication">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Afficher les hashtags -->
                    <?php if ($post['campusHashtag']) : ?>
                        <p class="mt-2"><strong>Campus:</strong> <?= htmlspecialchars($post['campusHashtag']) ?></p>
                    <?php endif; ?>
                    <div><small class="text-muted">Posté le : <?= $post['dateCreation'] ?></small></div>
                    
                    <div class="mt-2">
                        <a href="../include/like.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-hand-thumbs-up"></i> Aimer 
                            <span class="text-muted ms-2"><?= $post['likeCount'] ?> j'aime</span> <!-- Affichage du compteur de j'aime -->
                        </a>
                        
                        <a href="seeComment.php?id=<?= $post['idPost'] ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-chat"></i> Voir les Commentaires
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
