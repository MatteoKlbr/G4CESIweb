<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jérémy GALLET">
  <meta name="description" content="Le site de gestion d’offres de stages et d’alternances. Trouvez l’opportunité qui vous correspond.">
  <link rel="stylesheet" href="Style1.css">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Accueil - Web4All</title>
</head>
<body>
  <header>
    <div class="logo">
      <img src="C:\xampp\htdocs\LeBonPlan-G4\LeBonPlan-G4\images\WEB4ALL__4_-removebg-preview.png" alt="Web4All Logo">
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Accueil</a>&nbsp;|&nbsp;</li>
        <li><a href="Offres.php">Offres</a>&nbsp;|&nbsp;</li>
        <li><a href="Wishlist.php">Wishlist</a>&nbsp;|&nbsp;</li>
        <li><a href="Contact.php">Contact</a>&nbsp;|&nbsp;</li>
        <li><a href="Entreprise.php">Entreprises</a>&nbsp;|&nbsp;</li>
        <li><a href="OffresGestion.html">Gérer les Offres</a>&nbsp;|&nbsp;</li>
        <li><a href="Dashboard.html">Statistiques</a>&nbsp;|&nbsp;</li>
        <li><a href="Pilote.html">Pilotes</a>&nbsp;|&nbsp;</li>
        <li><a href="Etudiant.html">Étudiants</a>&nbsp;|&nbsp;</li>
        <?php if(!isset($_SESSION['id'])): ?>
          <li><a href="Connexion.php" class="cnx-link">Connexion</a></li>
          <li><a href="Inscription.php" class="cnx-link">Inscription</a></li>
        <?php endif; ?>
      </ul>
    </nav>
      <div class="auth-buttons">
        <?php if(isset($_SESSION['id'])): ?>
          <!-- Bouton déclencheur de la modale -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">
            Mon Profil
          </button>
          <a href="logout.php" class="btn btn-primary">Déconnexion</a>
        <?php endif; ?>
      </div>
    </nav>
  </header>
  <section class="hero">
    <div class="hero-content">
        <h1>Bienvenue sur Web4All</h1>
        <p>Trouvez votre stage ou alternance facilement et rapidement !</p>
        <a href="Offres.html" class="btn-main">Voir les offres</a>
    </div>
  </section>
  <footer>
    <p>2025 - Tous droits réservés - Web4All</p>
  </footer>

  <!-- Modale Bootstrap pour afficher le profil -->
  <?php if(isset($_SESSION['id'])): ?>
    <?php
      require_once 'config.php';
      $user_id = $_SESSION['id'];
      $stmt = $pdo->prepare("SELECT id, nom, prenom, email, role, created_at, avatar, cv FROM users WHERE id = ?");
      $stmt->execute([$user_id]);
      $user = $stmt->fetch();
    ?>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">Mon Profil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4 text-center">
                <?php if (!empty($user['avatar'])): ?>
                  <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="img-fluid rounded-circle">
                <?php else: ?>
                  <img src="images/default-avatar.png" alt="Avatar par défaut" class="img-fluid rounded-circle">
                <?php endif; ?>
              </div>
              <div class="col-md-8">
                <h2><?php echo htmlspecialchars($user['prenom'] . " " . $user['nom']); ?></h2>
                <p><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Date d'inscription :</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                <?php if (!empty($user['cv'])): ?>
                  <p><strong>CV :</strong> <a href="<?php echo htmlspecialchars($user['cv']); ?>" target="_blank">Voir mon CV</a></p>
                <?php else: ?>
                  <p><strong>CV :</strong> Aucun CV téléchargé.</p>
                <?php endif; ?>
                <div class="mt-3">
                  <a href="edit_profile.php" class="btn btn-primary">Éditer</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
