<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js"></script>

    <script defer src="../js/main.js"></script>

    <link rel="stylesheet" href="../style/style.css">
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

    <!--https://assets.codepen.io/1651485/planet.png-->
    
    <div class="mainText">
      <div class="mainTitle">
        Crée un compte EPSILINK
      </div>
      <div class="subTitle">
        By M.Beaucheron, T.Debay, A.Flament, M.Bouchez
      </div>
      <div class="cursor"></div>
    </div>
    <div class="maincontainer">
    <form action="../include/register.php" method="post">
    <div class="input-field">
        <input type="text" id="nom" name="nom" required>
        <label for="nom">Nom :</label>
    </div>
    <div class="input-field">
        <input type="text" id="prenom" name="prenom" required>
        <label for="prenom">Prénom :</label>
    </div>
    <div class="input-field">
        <input type="text" id="tel" name="tel" required>
        <label for="tel">Téléphone :</label>
    </div>
    <div class="input-field">
        <input type="email" id="mail" name="mail" required>
        <label for="mail">E-mail :</label>
    </div>
    <div class="input-field">
        <input type="password" id="password" name="password" required>
        <label for="password">Mot de passe :</label>
    </div>
    <div class="input-field">
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label for="confirm_password">Confirmez le mot de passe :</label>
    </div>
    <button type="submit">Créer mon compte</button>
</form>


  </div>
</body>
</html>