<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php'; // Connexion PDO

// Récupérer les informations de l'utilisateur pour pré-remplir le formulaire
$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT id, nom, prenom, email, avatar, statut_recherche, cv FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Jérémy GALLET">
  <meta name="description" content="Modifier votre profil sur LeBonPlan.">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Style.css">
  <title>Modifier mon profil - LeBonPlan</title>
</head>
<body>
  <header class="bg-light py-3 mb-4">
    <div class="container">
      <h4 class="text-center">Modifier mon profil</h4>
      <div class="text-center my-2">
        <img src="./images/logo-lbp-header.png" alt="LeBonPlan - Le meilleur site d'offres de stages et d’alternances" class="img-fluid" style="max-height: 100px;">
      </div>
      <nav class="d-flex justify-content-center">
        <a href="Accueil.php" class="mx-2 text-decoration-none">Accueil</a>
        <a href="Entreprise.php" class="mx-2 text-decoration-none">Entreprises</a>
        <a href="Offres.php" class="mx-2 text-decoration-none">Offres</a>
        <a href="Wishlist.php" class="mx-2 text-decoration-none">Wishlist</a>
        <a href="Contact.php" class="mx-2 text-decoration-none">Contact</a>
        <div class="auth-buttons mx-2">
          <a href="profile.php" class="btn btn-outline-primary">Mon Profil</a>
          <a href="logout.php" class="btn btn-primary">Déconnexion</a>
        </div>
      </nav>
    </div>
  </header>
  
  <main class="container">
    <section class="mb-5">
      <h1 class="mb-4">Modifier votre profil</h1>
      <?php 
      // Affichage des messages de succès ou d'erreur
      if (isset($_SESSION['edit_profile_error'])) {
          echo '<div class="alert alert-danger" role="alert">' . $_SESSION['edit_profile_error'] . '</div>';
          unset($_SESSION['edit_profile_error']);
      }
      if (isset($_SESSION['edit_profile_success'])) {
          echo '<div class="alert alert-success" role="alert">' . $_SESSION['edit_profile_success'] . '</div>';
          unset($_SESSION['edit_profile_success']);
      }
      ?>
      <form action="edit_profile_process.php" method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
          <label for="nom" class="form-label">Nom :</label>
          <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>
        <div class="col-md-6">
          <label for="prenom" class="form-label">Prénom :</label>
          <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email :</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="col-md-6">
          <label for="statut_recherche" class="form-label">Statut de recherche :</label>
          <input type="text" class="form-control" id="statut_recherche" name="statut_recherche" value="<?php echo htmlspecialchars($user['statut_recherche']); ?>">
        </div>
        <div class="col-md-6">
          <label for="avatar" class="form-label">Avatar (Photo de profil) :</label>
          <?php if (!empty($user['avatar'])): ?>
            <div class="mb-2">
              <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="img-thumbnail" style="width:100px;">
            </div>
          <?php else: ?>
            <p class="text-muted">Aucun avatar défini.</p>
          <?php endif; ?>
          <input type="file" class="form-control" id="avatar" name="avatar">
        </div>
        <div class="col-md-6">
          <label for="cv" class="form-label">CV :</label>
          <?php if (!empty($user['cv'])): ?>
            <p><a href="<?php echo htmlspecialchars($user['cv']); ?>" target="_blank">Voir mon CV</a></p>
          <?php else: ?>
            <p class="text-muted">Aucun CV défini.</p>
          <?php endif; ?>
          <input type="file" class="form-control" id="cv" name="cv">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-success">Sauvegarder les modifications</button>
          <a href="Accueil.php" class="btn btn-secondary ms-2">Annuler</a>
        </div>
      </form>
    </section>
  </main>
  
  <footer class="bg-light py-3 mt-4">
    <div class="container text-center">
      <em>&copy;2025 - Tous droits réservés - Web4All</em>
    </div>
  </footer>
  
  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
