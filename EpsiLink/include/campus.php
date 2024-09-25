<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epsilink";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$sql = "SELECT idCampus, nomCampus FROM campus";
$result = $conn->query($sql);

$campusOptions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $campusOptions[] = $row;
    }
}

$conn->close();
?>
