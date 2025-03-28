<?php
// Pour tester, la vérification d'authentification est commentée
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Créer une Offre - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!-- <?php // include 'header.php'; ?> -->
    <main>
        <h1>Créer une Nouvelle Offre</h1>
        <?php 
          if(isset($_SESSION['create_offre_error'])) { 
              echo '<p style="color:red;">'.$_SESSION['create_offre_error'].'</p>'; 
              unset($_SESSION['create_offre_error']);
          }
        ?>
        <form action="create_offre_process.php" method="post">
            <label for="entreprise_id">ID Entreprise :</label>
            <input type="number" id="entreprise_id" name="entreprise_id" required>
            <br>
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>
            <br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <br>
            <label for="competences">Compétences :</label>
            <input type="text" id="competences" name="competences" required>
            <br>
            <label for="base_remuneration">Base rémunération :</label>
            <input type="text" id="base_remuneration" name="base_remuneration" required>
            <br>
            <label for="date_publication">Date Publication :</label>
            <input type="date" id="date_publication" name="date_publication" required>
            <br>
            <label for="date_expiration">Date Expiration :</label>
            <input type="date" id="date_expiration" name="date_expiration" required>
            <br>
            <label for="localisation">Localisation :</label>
            <input type="text" id="localisation" name="localisation" required>
            <br>
            <button type="submit" class="btn">Créer l'offre</button>
        </form>
    </main>
    <!-- <?php // include 'footer.php'; ?> -->
</body>
</html>
