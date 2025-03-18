<?php session_start(); ?>
<!doctype html>
<html lang="fr"> 
   <head> 
      <meta charset="utf-8">
      <meta name="author" content="Jérémy GALLET">
      <meta name="description" content="Découvrez les entreprises proposant des offres de stage et alternance.">
      <link rel="stylesheet" href="Style.css">
      <title>Entreprises - LeBonPlan</title> 
   </head> 
   <body>
      <header>
         <center><h4>Les entreprises partenaires</h4></center>
         <div>
            <center>
               <img name="logo" src="./images/logo-lbp-header.png" alt="LeBonCoin - Le meilleur site d'offres de stages et d’alternances">
            </center>
         </div>
         <nav>
            <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
            <a href="entreprise.php">Entreprises</a>&nbsp;|&nbsp;
            <a href="Offres.php">Offres</a>&nbsp;|&nbsp;
            <a href="Wishlist.php">Wishlist</a>&nbsp;|&nbsp;
            <a href="Contact.php">Contact</a>
            <div class="auth-buttons">
               <?php if(isset($_SESSION['id'])): ?>
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
            <center><h1>Nos entreprises partenaires</h1></center>
            <p>Retrouvez ici les entreprises qui recrutent des étudiants en stage et alternance.</p>
            
            <article>
               <h2>CF Technologies</h2>
               <p><strong>Lieu :</strong> Paris | <strong>Secteur :</strong> Technologie</p>
               <p><a href="Offres.php">Voir les offres disponibles</a></p>
            </article>
            
            <article>
               <h2>SMMA MEDIA</h2>
               <p><strong>Lieu :</strong> Lyon | <strong>Secteur :</strong> Réseaux sociaux</p>
               <p><a href="Offres.php">Voir les offres disponibles</a></p>
            </article>
            
            <article>
               <h2>PACKNOW-STORE</h2>
               <p><strong>Lieu :</strong> Lyon | <strong>Secteur :</strong> Commerce</p>
               <p><a href="Offres.php">Voir les offres disponibles</a></p>
            </article>
         </section>
      </main>

      <footer>
         <em>&copy;2025 - Tous droits réservés - Web4All</em>
      </footer>
   </body> 
</html>
