<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

// Récupérer l'ID de l'offre depuis l'URL
$offre_id = $_GET['id'] ?? null;
if (!$offre_id) {
    header("Location: Offres.php?message=offre_non_trouvee");
    exit;
}

$etudiant_id = $_SESSION['id'];

// Vérifier si l'offre est déjà dans la wishlist
$stmt = $pdo->prepare("SELECT * FROM wishlist WHERE etudiant_id = ? AND offre_id = ?");
$stmt->execute([$etudiant_id, $offre_id]);
if ($stmt->rowCount() > 0) {
    header("Location: Offres.php?message=offre_deja_ajoutee");
    exit;
}

// Insérer l'offre dans la wishlist
$stmt = $pdo->prepare("INSERT INTO wishlist (etudiant_id, offre_id) VALUES (?, ?)");
if ($stmt->execute([$etudiant_id, $offre_id])) {
    header("Location: Offres.php?message=offre_ajoutee");
    exit;
} else {
    header("Location: Offres.php?message=erreur_ajout");
    exit;
}
?>
