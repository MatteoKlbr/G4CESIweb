<?php
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
    <title>Créer une Entreprise - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!-- <?php // include 'header.php'; ?> -->
    <main>
        <h1>Créer une Nouvelle Entreprise</h1>
        <form action="create_entreprise_process.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <br>
            <label for="email">Email de contact :</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" required>
            <br>
            <button type="submit" class="btn">Créer l'entreprise</button>
        </form>
    </main>
    <!-- <?php // include 'footer.php'; ?> -->
</body>
</html>
