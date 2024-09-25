<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script defer src="https:////cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js"></script>
    <script defer src="../js/main.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>WorkShop</title>
</head>
<body>
    <div id="WebGL-output"></div>
    
    <img class="planetImg" src="../img/Epsi.png"/>

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
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
    </div>
    <div class="input-field">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
    </div>
    <div class="input-field">
        <label for="tel">Téléphone :</label>
        <input type="text" id="tel" name="tel" required>
    </div>
    <div class="input-field">
        <label for="mail">E-mail :</label>
        <input type="email" id="mail" name="mail" required>
    </div>
    <div class="input-field">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="btnEnvoie">Créer mon compte</button>
</form>
  </div>
</body>
</html>