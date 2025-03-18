<?php
session_start();
if (!isset($_SESSION['id'])) {
    if (isset($_GET['ajax'])) {
        echo "<p>Vous devez être connecté pour voir votre profil.</p>";
        exit;
    }
    header('Location: connexion.php');
    exit;
}

require_once 'config.php'; // Connexion PDO

$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT id, nom, prenom, email, role, created_at, avatar, cv FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    if (isset($_GET['ajax'])) {
        echo "<p>Utilisateur non trouvé.</p>";
        exit;
    }
    echo "Utilisateur non trouvé.";
    exit;
}

// Si le paramètre ajax est présent, on renvoie uniquement le contenu du profil
if (isset($_GET['ajax'])) {
    ?>
    <div class="profile-container">
       <div class="profile-header">
          <div class="avatar">
              <?php if (!empty($user['avatar'])): ?>
                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar">
              <?php else: ?>
                <img src="images/default-avatar.png" alt="Avatar par défaut">
              <?php endif; ?>
          </div>
          <div class="user-info">
              <h1><?php echo htmlspecialchars($user['prenom'] . " " . $user['nom']); ?></h1>
              <p><?php echo htmlspecialchars($user['role']); ?></p>
          </div>
       </div>
       <div class="profile-details">
          <div class="detail">
              <h3>Email</h3>
              <p><?php echo htmlspecialchars($user['email']); ?></p>
          </div>
          <div class="detail">
              <h3>Date d'inscription</h3>
              <p><?php echo htmlspecialchars($user['created_at']); ?></p>
          </div>
          <div class="detail">
              <h3>CV</h3>
              <?php if (!empty($user['cv'])): ?>
                 <p><a href="<?php echo htmlspecialchars($user['cv']); ?>" target="_blank">Voir mon CV</a></p>
              <?php else: ?>
                 <p>Aucun CV téléchargé.</p>
              <?php endif; ?>
          </div>
       </div>
       <div class="profile-actions">
           <a href="edit_profile.php" class="btn">Éditer</a>
           <a href="copy_profile.php?id=<?php echo $user['id']; ?>" class="btn">Copier</a>
           <a href="delete_profile.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre profil ?');">Supprimer</a>
       </div>
    </div>
    <?php
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Jérémy GALLET">
    <meta name="description" content="Votre profil sur LeBonPlan.">
    <link rel="stylesheet" href="profile.css">
    <title>Mon Profil - LeBonPlan</title>
</head>
<body>
    <header>
         <div class="header-container">
             <img src="./images/logo-lbp-header.png" alt="LeBonPlan Logo">
             <nav>
                <a href="Accueil.php">Accueil</a>
                <a href="Entreprise.php">Entreprises</a>
                <a href="Offres.php">Offres</a>
                <a href="Wishlist.php">Wishlist</a>
                <a href="Contact.php">Contact</a>
                <div class="auth-buttons">
                    <a href="profile.php" class="btn">Mon Profil</a>
                    <a href="logout.php" class="btn btn-primary">Déconnexion</a>
                </div>
             </nav>
         </div>
    </header>

    <main>
      <!-- Ici tu peux inclure le contenu complet du profil pour un accès direct -->
      <?php // Tu peux inclure à nouveau le contenu complet ici si besoin ?>
    </main>

    <footer>
         <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
