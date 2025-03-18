<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

// Récupération de la liste des offres en wishlist pour l'étudiant connecté
$user_id = $_SESSION['id'];
$sql = "SELECT o.id AS offre_id, o.titre, o.description, o.localisation 
        FROM wishlist w
        JOIN offres o ON w.offre_id = o.id
        WHERE w.etudiant_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$wishlist = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr"> 
<head> 
    <meta charset="utf-8">
    <meta name="author" content="Jérémy GALLET">
    <meta name="description" content="Consultez et gérez vos offres favorites de stages et alternances.">
    <link rel="stylesheet" href="Style.css">
    <title>Wishlist - LeBonPlan</title> 
</head> 
<body>
    <header>
        <div class="header-container">
            <center><h4>Vos offres sauvegardées</h4></center>
            <center>
                <img src="./images/logo-lbp-header.png" alt="LeBonPlan - Le site des offres de stage et alternance">
            </center>
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
            <center><h1>Mes offres de stage et alternance favorites</h1></center>
            
            <?php if (!empty($wishlist)): ?>
                <?php foreach ($wishlist as $item): ?>
                    <article class="wishlist-offer">
                        <h2><?php echo htmlspecialchars($item['titre']); ?></h2>
                        <p>Lieu : <?php echo htmlspecialchars($item['localisation']); ?></p>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                        
                        <!-- Lien pour retirer de la wishlist -->
                        <a href="wishlist_remove.php?offre_id=<?php echo $item['offre_id']; ?>" class="btn">Retirer de la wishlist</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune offre n’a été ajoutée à la wishlist.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
