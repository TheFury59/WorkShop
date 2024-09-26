<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>".$_SESSION['error']."</p>";
    unset($_SESSION['error']);
}

// Vérifier si un cookie est présent pour pré-remplir l'email
if (isset($_COOKIE['user_token'])) {
    require 'include/bd.php';
    $token = $_COOKIE['user_token'];

    // Rechercher l'utilisateur avec ce token
    $sql = "SELECT mailUser FROM utilisateur WHERE remember_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $email_remembered = $user['mailUser']; // Pré-remplir l'email
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js"></script>

    <script defer src="js/main.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <title>WorkShop</title>
</head>
<body>
<div id="WebGL-output">
    </div>
    
    <div class="side-menu">
        <div id="menuBtn">
            <input type="checkbox" />
            <span></span>
            <span></span>
        </div>
        <div class="menu"></br></br></br></br></br></br></br></br>
            <a class="menu-item" href="/">VEUILLEZ VOUS CONNECTER</a>
        </div>
        <div class="straight-line"></div>
    </div>
    
    <img class="planetImg" src="/img/Epsi.png" alt="Epsi Planet Image" />

    <div class="mainText">
      <div class="mainTitle">
        BIENVENUE SUR EPSILINK
      </div>
      <div class="subTitle">
        By M.Beaucheron, T.Debay, A.Flament, M.Bouchez
      </div>
      <div class="cursor"></div>
    </div>


    <div class="maincontainer">
        <form action="include/connection.php" method='post'>
            <h2>Se Connecter</h2>

            <!-- Champ email avec pré-remplissage si disponible -->
            <div class="input-field">
                <input type="email" name="mail" id="mail" required value="<?= htmlspecialchars($email_remembered) ?>">
                <label for="mail">E-mail</label>
            </div>

            <!-- Champ mot de passe -->
            <div class="input-field">
                <input type="password" name="password" id="password" required>
                <label for="password">Mot de passe</label>
            </div>

            <!-- Option de se souvenir de moi -->
            <div class="password-options">
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <p>Se Souvenir de moi</p>
                </label>
            </div>

            <!-- Lien de récupération du mot de passe -->
            <a href="#">Mot de passe oublié</a></br>

            <!-- Bouton de connexion -->
            <button type="submit" id="connection">Connexion</button>

            <!-- Options de création de compte -->
            <div class="account-options">
                <p>Vous n'avez pas de compte ? <a href="page/register.php"></br></br>Créez un compte</a></p>
            </div>
        </form>
    </div>
</body>
</html>
