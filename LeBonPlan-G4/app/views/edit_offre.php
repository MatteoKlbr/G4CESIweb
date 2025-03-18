<?php
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_offres.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM offres WHERE id = ?");
$stmt->execute([$id]);
$offre = $stmt->fetch();
if (!$offre) {
    echo "Offre non trouvée.";
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier l'Offre - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!-- <?php // include 'header.php'; ?> -->
    <main>
        <h1>Modifier l'Offre</h1>
        <form action="edit_offre_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($offre['id']); ?>">
            <label for="entreprise_id">ID Entreprise :</label>
            <input type="number" id="entreprise_id" name="entreprise_id" value="<?php echo htmlspecialchars($offre['entreprise_id']); ?>" required>
            <br>
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($offre['titre']); ?>" required>
            <br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($offre['description']); ?></textarea>
            <br>
            <label for="competences">Compétences :</label>
            <input type="text" id="competences" name="competences" value="<?php echo htmlspecialchars($offre['competences']); ?>" required>
            <br>
            <label for="base_remuneration">Base rémunération :</label>
            <input type="text" id="base_remuneration" name="base_remuneration" value="<?php echo htmlspecialchars($offre['base_remuneration']); ?>" required>
            <br>
            <label for="date_publication">Date Publication :</label>
            <input type="date" id="date_publication" name="date_publication" value="<?php echo htmlspecialchars($offre['date_publication']); ?>" required>
            <br>
            <label for="date_expiration">Date Expiration :</label>
            <input type="date" id="date_expiration" name="date_expiration" value="<?php echo htmlspecialchars($offre['date_expiration']); ?>" required>
            <br>
            <label for="localisation">Localisation :</label>
            <input type="text" id="localisation" name="localisation" value="<?php echo htmlspecialchars($offre['localisation']); ?>" required>
            <br>
            <button type="submit" class="btn">Sauvegarder les modifications</button>
        </form>
    </main>
    <!-- <?php // include 'footer.php'; ?> -->
</body>
</html>
