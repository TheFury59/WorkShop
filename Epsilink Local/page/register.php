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
    <div id="WebGL-output">
    </div>
    <div class="side-menu">
      <div id="menuBtn">
        <input type="checkbox" />
        <span></span>
        <span></span>
      </div>
      <div class="menu"></br></br></br></br></br></br></br></br>
        <a class="menu-item" href="../index.php">ACCUEIL</a>
        <a class="menu-item" href="equipe.html">L'EQUIPE</a>
        <a class="menu-item" href="epsilink.html">EPSILINK</a>
        <a class="menu-item" href="workshop.html">WORKSHOP CONCEPTION</a>
        <a class="menu-item" href="ect.html">ETC..</a>
      </div>
      <div class="straight-line"></div>
    </div>
    
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
          <h2>Crée un Compte</h2>
          <div class="input-field">
              <input type="text" name="nom" id="nom" required>
              <label for="nom">Nom</label>
          </div>
          <div class="input-field">
              <input type="text" name="Prenom" id="Prenom" required>
              <label for="Prenom">Prénom</label>
          </div>

          <div class="input-field">
              <label for="campus">Sélectionner un campus :</label>
              <select id="campus" name="campus" required>
                  <option value=""></option>
                  <?php
                  // Inclusion du fichier qui contient la logique de récupération des campus
                  include('../include/campus.php');
                  echo $campusOptions; // Affiche les options générées
                  ?>
              </select>
          </div>

          <div class="input-field">
              <input type="text" name="tel" id="tel" required>
              <label for="tel">Téléphone</label>
          </div>
          <div class="input-field">
              <input type="text" name="mail" id="mail" required>
              <label for="mail">E-mail</label>
          </div>
          <div class="input-field">
              <input type="password" name="password" id="password" required>
              <label for="password">Mot de passe</label>
          </div>

          <button class="btnEnvoie" type="submit">Crée mon compte</button>
      </form>
  </div>
</body>
</html>