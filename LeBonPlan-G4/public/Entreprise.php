<?php 
$pageTitle = "Entreprises - LeBonPlan";
$pageDescription = "Découvrez les entreprises proposant des offres de stage et alternance.";
include 'header.php';
?>

<section>
  <center><h1>Nos entreprises partenaires</h1></center>
  <p>Retrouvez ici les entreprises qui recrutent des étudiants en stage et alternance.</p>

  <?php if (!empty($entreprises)): ?>
      <?php foreach($entreprises as $entreprise): ?>
      <article>
        <h2><?= htmlspecialchars($entreprise['nom']); ?></h2>
        <p><?= nl2br(htmlspecialchars($entreprise['description'])); ?></p>
        <p>
          <strong>Lieu :</strong> <?= htmlspecialchars($entreprise['localisation']); ?>
          <?php if (isset($entreprise['secteur']) && !empty($entreprise['secteur'])): ?>
            | <strong>Secteur :</strong> <?= htmlspecialchars($entreprise['secteur']); ?>
          <?php endif; ?>
        </p>
        <p><a href="Offres.php?entreprise_id=<?= htmlspecialchars($entreprise['id']); ?>">Voir les offres disponibles</a></p>
      </article>
      <?php endforeach; ?>
  <?php else: ?>
      <p style="text-align:center;">Aucune entreprise trouvée.</p>
  <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
