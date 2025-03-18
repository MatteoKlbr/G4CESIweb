<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

$offre_id = $_GET['id'] ?? null;
if (!$offre_id) {
    header("Location: Offres.php?message=offre_non_trouvee");
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Jérémy GALLET">
    <meta name="description" content="Postulez à cette offre de stage ou alternance.">
    <link rel="stylesheet" href="Style.css">
    <title>Postuler à une Offre - LeBonPlan</title>
</head>
<body>
    <header>
         <div class="header-container">
             <center><h4>Postuler à une Offre</h4></center>
             <center><img src="./images/logo-lbp-header.png" alt="LeBonPlan"></center>
             <nav>
                 <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
                 <a href="Offres.php">Offres</a>&nbsp;|&nbsp;
                 <a href="Contact.php">Contact</a>
                 <div class="auth-buttons">
                     <a href="profile.php" class="btn">Mon Profil</a>
                     <a href="logout.php" class="btn btn-primary">Déconnexion</a>
                 </div>
             </nav>
         </div>
    </header>
    
    <main>
         <section>
             <h1>Postuler à l'Offre</h1>
             <form action="postuler_process.php" method="post" enctype="multipart/form-data">
                 <!-- On envoie l'ID de l'offre dans un champ caché -->
                 <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($offre_id); ?>">
                 
                 <label for="lettre">Lettre de motivation :</label>
                 <textarea id="lettre" name="lettre" rows="5" cols="50" required placeholder="Expliquez pourquoi vous postulez à cette offre..."></textarea>
                 <br>
                 
                 <label for="cv">Téléverser votre CV :</label>
                 <input type="file" id="cv" name="cv" required>
                 <br>
                 
                 <button type="submit" class="btn">Postuler</button>
             </form>
         </section>
    </main>
    
    <footer>
         <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
