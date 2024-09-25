<?php
// Vérifier que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer et sécuriser les données du formulaire
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $tel = isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : '';
    $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    // Vérification des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($tel) || empty($mail) || empty($password)) {
        die("Veuillez remplir tous les champs.");
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Remplacer par le mot de passe de la base de données
    $dbname = "epsilink";

    // Créer la connexion
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Hashage du mot de passe avant de l'insérer dans la base de données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête d'insertion
    $sql = "INSERT INTO utilisateur (nomUser, prenomUser, mdpUser, mailUser, tel) 
            VALUES (?, ?, ?, ?, ?)";

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Associer les valeurs aux paramètres
    $stmt->bind_param("sssss", $nom, $prenom, $hashed_password, $mail, $tel);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur lors de l'insertion : " . $stmt->error;
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>
