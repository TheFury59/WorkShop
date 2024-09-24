<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacer par les informations de connexion
$username = "root"; 
$password = "";
$dbname = "epsilink"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les noms des campus
$sql = "SELECT nomCampus FROM campus"; // Remplacer par ta table et colonne réelle
$result = $conn->query($sql);

// Stocker les options de campus
$campusOptions = "";

if ($result->num_rows > 0) {
    // Créer les options du select avec les campus récupérés
    while ($row = $result->fetch_assoc()) {
        $campusOptions .= "<option value='" . $row['nomCampus'] . "'>" . $row['nomCampus'] . "</option>";
    }
} else {
    $campusOptions .= "<option value=''>Aucun campus disponible</option>";
}

$conn->close();
?>
