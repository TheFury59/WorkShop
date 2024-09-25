<?php
session_start();

// Vérifier que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire et les sécuriser
    $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    require 'bd.php';
    
    // Préparer la requête pour récupérer les informations de l'utilisateur par email
    $sql = "SELECT idUser, nomUser, prenomUser, mdpUser FROM utilisateur WHERE mailUser = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Associer l'email au paramètre de la requête
    $stmt->bind_param("s", $mail);

    // Exécuter la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($password, $user['mdpUser'])) {
            // Mot de passe correct, démarrer la session utilisateur
            $_SESSION['idUser'] = $user['idUser'];
            $_SESSION['nomUser'] = $user['nomUser'];
            $_SESSION['prenomUser'] = $user['prenomUser'];

            // Redirection vers la page "epsilink.html"
            header("Location: ../page/home.php");
            exit();
        } else {
            // Mot de passe incorrect
            echo "Mot de passe incorrect.";
        }
    } else {
        // Aucun utilisateur trouvé avec cet email
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>
