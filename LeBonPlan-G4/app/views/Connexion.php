<?php session_start(); ?>
<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="author" content="Jérémy GALLET">
      <meta name="description" content="Connexion à StageAlternance, retrouvez vos opportunités de stage et alternance.">
      <link rel="stylesheet" href="Style.css">
      <title>Connexion - LeBonPlan</title>
   </head>
   <body>
      <header>
         <center><h4>Connectez-vous sur LeBonPlan</h4></center>
         <div>
            <center>
               <img name="logo" src="./images/logo-lbp-header.png" alt="LeBonPlan - Le meilleur site d'offres de stages et d’alternances">
            </center>
         </div>
         <nav>
            <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
            <a href="Entreprise.php">Entreprises</a>&nbsp;|&nbsp;
            <a href="Offres.php">Offres</a>&nbsp;|&nbsp;
            <a href="Wishlist.php">Wishlist</a>&nbsp;|&nbsp;
            <a href="Contact.php">Contact</a>
            <div class="auth-buttons">
               <?php if(isset($_SESSION['user_id'])): ?>
                  <a href="profile.php" class="btn">Mon Profil</a>
                  <a href="logout.php" class="btn btn-primary">Déconnexion</a>
               <?php else: ?>
                  <a href="connexion.php" class="btn">Connexion</a>
                  <a href="inscription.php" class="btn btn-primary">Inscription</a>
               <?php endif; ?>
           </div>
         </nav>
      </header>

      <main>
         <section>
            <center><h1>Formulaire de connexion</h1></center>
            <?php 
            // Afficher un message d'erreur s'il existe
            if(isset($_SESSION['login_error'])) {
                echo '<p style="color:red;">'. $_SESSION['login_error'] .'</p>';
                unset($_SESSION['login_error']);
            }
            ?>
            <form action="login_process.php" method="POST">
               <div class="form-group">
                  <label for="email">Email :</label>
                  <input type="email" id="email" name="email" required>
               </div>
               <div class="form-group">
                  <label for="motdepasse">Mot de passe :</label>
                  <input type="password" id="motdepasse" name="motdepasse" required>
               </div>
               <button type="submit" class="btnn">Se connecter</button>
            </form>
         </section>
      </main>

      <footer>
         <em>&copy;2025 - Tous droits réservés - Web4All</em>
      </footer>
   </body>
</html>
