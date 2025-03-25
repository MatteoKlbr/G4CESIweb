<?php
////////////////////////////////
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';
/////////////////////////////////////////
$offre_id = $_GET['id'] ?? null;
if (!$offre_id) {
    header("Location: Offres.php?message=offre_non_trouvee");
    exit;
}

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

    <form action="postuler_process.php" method="post" enctype="multipart/form-data" class="form-postuler">
      <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($offre_id); ?>">

      <label for="lettre">Lettre de motivation :</label><br>
      <textarea id="lettre" name="lettre" rows="5" cols="50" required placeholder="Expliquez pourquoi vous postulez à cette offre..."></textarea>
      <br><br>

      <label for="cv">Téléverser votre CV :</label><br>
      <input type="file" id="cv" name="cv" required>
      <br><br>

      <button type="submit" class="btn btn-primary">Postuler</button>
    </form>
  </section>
</main>

<?php include 'footer.php'; ?>
