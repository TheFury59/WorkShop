<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script defer src="https:////cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js"></script>
    <script defer src="js/main.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <title>WorkShop</title>
</head>
<body>
    <div id="WebGL-output">
    </div>
    
    <img class="planetImg" src="img/Epsi.png" />

    <!--https://assets.codepen.io/1651485/planet.png-->
    
    <div class="mainText">
      <div class="mainTitle">
        Bienvenue Sur EPSILINK
      </div>
      <div class="subTitle">
        By M.Beaucheron, T.Debay, A.Flament, M.Bouchez
      </div>
      <div class="cursor"></div>
    </div>
    <div class="maincontainer">

      <form action="include/connection.php" method='post'>
          <h2>Se Connecter</h2>
          <div class="input-field">
              <input type="text" name="mail" id="mail" required>
              <label for="mail">E-mail</label>
          </div>
          <div class="input-field">
              <input type="password" name="password" id="password" required>
              <label for="password">Mot de passe</label>
          </div>

          <div class="password-options">
              <label for="remember">
                  <input type="checkbox" id="remember">
                  <p>Se Souvenir de moi</p>
              </label>
          </div>

          <a href="#">Mot de passe oublié</a></br>

          <button type="submit" id="connection">Connexion</button>

          <div class="account-options">
              <p>Vous n'avez pas de compte ? <a href="page/register.php"></br></br>Crée un compte</a></p>
          </div>
      </form>
  </div>
</body>
</html>