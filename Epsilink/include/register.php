<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $tel = isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : '';
    $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : '';

    if (empty($nom) || empty($prenom) || empty($tel) || empty($mail) || empty($password) || empty($confirm_password)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    require 'bd.php'; 

    $checkMailQuery = "SELECT idUser FROM utilisateur WHERE mailUser = ?";
    $stmtMail = $conn->prepare($checkMailQuery);
    $stmtMail->bind_param("s", $mail);
    $stmtMail->execute();
    $stmtMail->store_result();
    
    if ($stmtMail->num_rows > 0) {
        echo "Un utilisateur avec cet email existe déjà.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateur (nomUser, prenomUser, mdpUser, mailUser, tel) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nom, $prenom, $hashed_password, $mail, $tel);

    if ($stmt->execute()) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur lors de l'insertion : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
