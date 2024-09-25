<?php
// Connexion à la base de données
$servername = "localhost"; // Remplace par les informations de connexion correctes
$username = "root";
$password = "";
$dbname = "epsilink"; // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les noms des campus
$sql = "SELECT nomCampus FROM campus"; // Requête pour sélectionner les campus
$result = $conn->query($sql);

// Initialiser une variable pour stocker les options
$campusOptions = "";

// Vérifier si la requête renvoie des résultats
if ($result->num_rows > 0) {
    // Parcourir les résultats et créer les balises <option>
    while ($row = $result->fetch_assoc()) {
        $campusOptions .= "<option value='" . htmlspecialchars($row['nomCampus']) . "'>" . htmlspecialchars($row['nomCampus']) . "</option>";
    }
} else {
    $campusOptions .= "<option value=''>Aucun campus disponible</option>";
}

// Fermer la connexion
$conn->close();
?>
