<?php session_start(); ?>
<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="author" content="Jérémy GALLET">
      <meta name="description" content="Contactez-nous en utilisant notre formulaire.">
      <link rel="stylesheet" href="Style.css">
      <title>Contact - LeBonPlan</title>
   </head>
   <body>
      <header>
         <div>
            <center>
               <img name="logo" src="./images/logo-lbp-header.png" alt="LeBonPlan - Le meilleur site d'annonces en ligne">
            </center>
         </div>
         <nav>
            <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
            <a href="Entreprise.php">Entreprises</a>&nbsp;|&nbsp;
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
            <center><h1>Nous sommes à votre écoute</h1></center>
            <p>
               Vous pouvez nous contacter directement via 
               <a href="mailto:info@lebonplan.fr">notre adresse de courriel</a> 
               ou utiliser le formulaire ci-dessous. Nous vous répondrons dans les délais les plus brefs.
            </p>
            <article>
               <form method="post" action="contact_process.php">
                  <label>Nom complet<br>
                     <input name="fullname" type="text" value="" size="100" placeholder="Ex : Eden SMITH" required>
                  </label>
                  <br><br>
                  <label>Votre message<br>
                     <textarea name="feedbacks" rows="5" cols="100" placeholder="Décrivez votre problème/Question/Clarification..." required></textarea>
                  </label>
                  <br><br>
                  <button type="submit" class="postuler">Envoyer</button>
                  <button type="reset" class="postuler">Effacer</button>
               </form>
            </article>
         </section>
      </main>
      
      <footer>
         <em>&copy;2025 - Tous droits réservés - Web4All</em>
      </footer>
      <script src="Script.js"></script>
   </body>
</html>
