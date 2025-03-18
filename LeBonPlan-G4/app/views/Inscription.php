<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
   <meta charset="utf-8">
   <meta name="author" content="Jérémy GALLET">
   <meta name="description" content="Inscription pour StageAlternance, trouvez l'opportunité qui vous correspond.">
   <link rel="stylesheet" href="Style.css">
   <title>Inscription - LeBonPlan</title>
</head>
<body>
   <header>
      <center><h4>Inscrivez-vous sur LeBonPlan</h4></center>
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
         <center><h1>Formulaire d'inscription</h1></center>
         <?php 
         if(isset($_SESSION['register_error'])) {
             echo '<p style="color:red;">' . $_SESSION['register_error'] . '</p>';
             unset($_SESSION['register_error']);
         }
         ?>
         <form action="register_process.php" method="POST">
            <div class="form-group">
               <label for="nom">Nom :</label>
               <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
               <label for="prenom">Prénom :</label>
               <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
               <label for="email">Email :</label>
               <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
               <label for="motdepasse">Mot de passe :</label>
               <input type="password" id="motdepasse" name="motdepasse" required>
            </div>
            <!-- Sélection du rôle (par défaut, "Étudiant") -->
            <div class="form-group">
               <label for="role">Rôle :</label>
               <select id="role" name="role">
                  <option value="etudiant" selected>Étudiant</option>
                  <option value="pilote">Pilote</option>
                  <!-- Vous pouvez ajouter une option pour l'administrateur si nécessaire -->
                  <!-- <option value="admin">Administrateur</option> -->
               </select>
            </div>
            <button type="submit" class="btnn">S'inscrire</button>
         </form>
      </section>
   </main>

   <footer>
      <em>&copy;2025 - Tous droits réservés - Web4All</em>
   </footer>
</body>
</html>
