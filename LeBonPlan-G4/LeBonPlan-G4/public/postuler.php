<?php
////////////////////////////////
// Démarrage de la session
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
/////////////////////////////////////////
require_once '../Config/config.php';

// Récupérer l'id de l'offre via GET
$offre_id = $_GET['id'] ?? null;
if (!$offre_id) {
    header("Location: Offres.php?message=offre_non_trouvee");
    exit;
}

// Optionnel : récupérer les informations de l'utilisateur (pour accéder à son CV déjà enregistré)
require_once '../models/User.php';
$userModel = new User($pdo);
$userInfo = $userModel->getUserById($_SESSION['id']);
$user_cv = $userInfo['cv'] ?? '';

$pageTitle = "Postuler à une Offre - LeBonPlan";
$pageDescription = "Postulez à cette offre de stage ou alternance.";
include 'header.php';
?>

<main>
  <section>
    <center><h1>Postuler à l'Offre</h1></center>
    
    <!-- Message de succès si success=1 -->
    <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
      <div class="alert alert-success text-center mx-4">
        Votre candidature a été envoyée avec succès !
      </div>
    <?php endif; ?>

    <!-- Message d'erreur si postuler_error existe -->
    <?php if (isset($_SESSION['postuler_error'])): ?>
      <div class="alert alert-danger text-center mx-4">
        <?php 
          echo $_SESSION['postuler_error'];
          unset($_SESSION['postuler_error']);
        ?>
      </div>
    <?php endif; ?>

    <form action="../process/postuler_process.php" method="post" enctype="multipart/form-data" class="form-postuler">
      <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($offre_id); ?>">

      <label for="lettre">Lettre de motivation :</label><br>
      <textarea id="lettre" name="lettre" rows="5" cols="50" required placeholder="Expliquez pourquoi vous postulez à cette offre..."></textarea>
      <br><br>

      <?php if (!empty($user_cv)): ?>
        <p>Votre CV actuel : <a href="<?php echo htmlspecialchars($baseUrl . $user_cv); ?>" target="_blank">Voir mon CV</a></p>
      <?php else: ?>
        <p class="text-muted">Aucun CV enregistré.</p>
      <?php endif; ?>
      <br><br>
      <button type="submit" class="btn btn-primary">Postuler</button>
    </form>
  </section>
</main>

<?php include 'footer.php'; ?>
