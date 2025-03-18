<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

$offre_id = $_GET['offre_id'] ?? null;
if (!$offre_id) {
    header("Location: Wishlist.php?message=offre_non_trouvee");
    exit;
}

$etudiant_id = $_SESSION['id'];

$stmt = $pdo->prepare("DELETE FROM wishlist WHERE etudiant_id = ? AND offre_id = ?");
$stmt->execute([$etudiant_id, $offre_id]);

header("Location: Wishlist.php?message=offre_retiree");
exit;
?>
