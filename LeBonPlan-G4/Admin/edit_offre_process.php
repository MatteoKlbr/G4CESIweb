<?php
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $entreprise_id = trim($_POST['entreprise_id'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $competences = trim($_POST['competences'] ?? '');
    $base_remuneration = trim($_POST['base_remuneration'] ?? '');
    $date_publication = $_POST['date_publication'] ?? '';
    $date_expiration = $_POST['date_expiration'] ?? '';
    $localisation = trim($_POST['localisation'] ?? '');

    if (empty($id) || empty($entreprise_id) || empty($titre) || empty($description) || empty($competences) || empty($base_remuneration) || empty($date_publication) || empty($date_expiration) || empty($localisation)) {
        $_SESSION['edit_offre_error'] = "Tous les champs sont obligatoires.";
        header("Location: edit_offre.php?id=$id");
        exit;
    }

    $sql = "UPDATE offres SET entreprise_id = ?, titre = ?, description = ?, competences = ?, base_remuneration = ?, date_publication = ?, date_expiration = ?, localisation = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$entreprise_id, $titre, $description, $competences, $base_remuneration, $date_publication, $date_expiration, $localisation, $id])){
        header("Location: manage_offres.php");
        exit;
    } else {
        $_SESSION['edit_offre_error'] = "Erreur lors de la mise à jour de l'offre.";
        header("Location: edit_offre.php?id=$id");
        exit;
    }
} else {
    header("Location: manage_offres.php");
    exit;
}
?>
