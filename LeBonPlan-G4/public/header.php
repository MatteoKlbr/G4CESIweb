
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Inclusion de la configuration pour la connexion à la BDD
require_once 'config.php';

// Si l'utilisateur est connecté, on récupère ses infos pour la modale
if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT id, nom, prenom, email, role, created_at, avatar, cv FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();
}

// Variables de page par défaut (à redéfinir dans chaque page si besoin)
if (!isset($pageTitle)) {
    $pageTitle = "LeBonPlan";
}
if (!isset($pageDescription)) {
    $pageDescription = "Bienvenue sur LeBonPlan, le site de gestion d'offres de stages et d'alternances.";
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="Bomou Mahamadou">
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
  <link rel="stylesheet" href="Style.css">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <title><?php echo htmlspecialchars($pageTitle); ?></title>
</head>
<body>
  <header>
    <center><h4>Bienvenue sur LeBonPlan</h4></center>
    <div>
      <center>
        <img name="logo" src="./images/logo-lbp-header.png" alt="LeBonCoin - Le meilleur site d'offres de stages et d’alternances">
      </center>
    </div>
    <nav>
      <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
      <a href="Entreprise.php">Entreprises</a>&nbsp;|&nbsp;
      <a href="Offres.php">Offres</a>&nbsp;|&nbsp;
      <a href="Wishlist.php">Wishlist</a>&nbsp;|&nbsp;
      <a href="Contact.php">Contact</a>
      <div class="auth-buttons">
        <?php if (isset($_SESSION['id'])): ?>
          <!-- Bouton déclencheur de la modale -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">
            Mon Profil
          </button>
          <a href="logout.php" class="btn btn-primary">Déconnexion</a>
        <?php else: ?>
          <a href="connexion.php" class="btn btn-primary">Connexion</a>
          <a href="inscription.php" class="btn btn-primary">Inscription</a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

  <main>
