<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $remember = isset($_POST['remember']) ? true : false;

    if (empty($mail) || empty($password)) {
        $_SESSION['error'] = "Email et mot de passe sont requis.";
        header("Location: ../index.php");
        exit();
    }

    require 'bd.php';

    $sql = "SELECT idUser, nomUser, prenomUser, mdpUser FROM utilisateur WHERE mailUser = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['mdpUser'])) {
            // Connexion réussie
            $_SESSION['idUser'] = $user['idUser'];
            $_SESSION['nomUser'] = $user['nomUser'];
            $_SESSION['prenomUser'] = $user['prenomUser'];
            session_regenerate_id(true); // Sécurité supplémentaire

            // Si l'utilisateur coche "Se souvenir de moi"
            if ($remember) {
                $token = bin2hex(random_bytes(16)); // Générer un token sécurisé
                setcookie("user_token", $token, time() + (86400 * 30), "/"); // Stocker un cookie pour 30 jours

                // Enregistrer le token dans la base de données
                $sql = "UPDATE utilisateur SET remember_token = ? WHERE idUser = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("si", $token, $user['idUser']);
                    $stmt->execute();
                } else {
                    $_SESSION['error'] = "Erreur lors de la connexion. Veuillez réessayer.";
                    header("Location: ../index.php");
                    exit();
                }
            }

            header("Location: ../page/home.php");
            exit();
        } else {
            $_SESSION['error'] = "Mot de passe incorrect.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: ../index.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
