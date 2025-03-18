<?php
session_start();
require_once 'config.php';

// Requête avec jointure pour afficher le nom de l'entreprise, etc.
$sql = "SELECT o.*, e.nom AS entreprise, o.localisation AS lieu 
        FROM offres o 
        LEFT JOIN entreprises e ON o.entreprise_id = e.id 
        ORDER BY o.date_publication DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offres = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr"> 
<head> 
    <meta charset="utf-8">
    <meta name="author" content="Jérémy GALLET">
    <meta name="description" content="Découvrez les offres de stage et alternance.">
    <link rel="stylesheet" href="Style.css">
    <title>Offres - Web4All</title> 
</head> 
<body>
    <header>
         <div class="header-container">
            <center><h4>Postuler à une offre!</h4></center>
            <center><img src="./images/logo-lbp-header.png" alt="LeBonPlan"></center>
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
         </div>
    </header>
     
    <main>
         <section>
             <center><h1>Liste des Offres de Stage et Alternance</h1></center>
             <?php if (!empty($offres)): ?>
                 <?php foreach ($offres as $offre): ?>
                     <article class="offre">
                         <h2><?php echo htmlspecialchars($offre['titre']); ?></h2>
                         <p>
                           <strong>Entreprise :</strong> <?php echo htmlspecialchars($offre['entreprise']); ?>  
                           | <strong>Lieu :</strong> <?php echo htmlspecialchars($offre['lieu']); ?>  
                           | <strong>Publiée le :</strong> <?php echo htmlspecialchars($offre['date_publication']); ?>
                         </p>
                         <p><?php echo htmlspecialchars($offre['description']); ?></p>
                         <div class="offre-actions">
                             <!-- Options pour les étudiants -->
                             <a href="postuler.php?id=<?php echo $offre['id']; ?>" class="btn">Postuler</a>
                             <a href="wishlist_add.php?id=<?php echo $offre['id']; ?>" class="btn">Ajouter à ma wishlist</a>
                         </div>
                     </article>
                 <?php endforeach; ?>
             <?php else: ?>
                 <p>Aucune offre n'est disponible pour le moment.</p>
             <?php endif; ?>
         </section>
    </main>
     
    <footer>
         <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body> 
</html>
