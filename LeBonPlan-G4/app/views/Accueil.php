<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jérémy GALLET">
  <meta name="description" content="Le site de gestion d’offres de stages et d’alternances. Trouvez l’opportunité qui vous correspond.">
  <link rel="stylesheet" href="Style.css">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Accueil - LeBonPlan</title>
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
        <?php if(isset($_SESSION['id'])): ?>
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
    <section>
      <center><h1>Trouvez votre stage ou alternance</h1></center>
      <p>Bienvenue sur StageAlternance, la plateforme dédiée aux étudiants à la recherche d’un stage ou d’une alternance. Découvrez les meilleures opportunités adaptées à votre parcours.</p>
      
      <article>
        <h2>Domaines d'activité</h2>
        <ul class="category-list">
          <li><a href="https://www.example.com/informatique" target="_blank">Informatique & Développement</a></li>
          <li><a href="https://www.example.com/marketing" target="_blank">Marketing & Communication</a></li>
          <li><a href="https://www.example.com/finance" target="_blank">Finance & Comptabilité</a></li>
          <li><a href="https://www.example.com/ingenierie" target="_blank">Ingénierie & Industrie</a></li>
          <li><a href="https://www.example.com/commerce" target="_blank">Commerce & Vente</a></li>
          <li><a href="https://www.example.com/ressources-humaines" target="_blank">Ressources Humaines</a></li>
        </ul>
      </article>
      
      <br />
      
      <article>
        <h2>Dernières offres publiées</h2>
        <table border="1" cellpadding="15">
          <thead>
            <tr>
              <th>Intitulé</th>
              <th>Localisation</th>
              <th>Entreprise</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Stage Développeur Web</td>
              <td>Paris</td>
              <td>TechCorp</td>
              <td>Stage 6 mois</td>
            </tr>
            <tr>
              <td>Alternance Marketing Digital</td>
              <td>Lyon</td>
              <td>Market&Co</td>
              <td>Alternance 1 an</td>
            </tr>
            <tr>
              <td>Stage en Gestion Financière</td>
              <td>Bordeaux</td>
              <td>FinancePlus</td>
              <td>Stage 4 mois</td>
            </tr>
          </tbody>
        </table>
      </article>               
    </section>
  </main>

  <footer>
    <em>&copy;2025 - Tous droits réservés - Web4All</em>
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
