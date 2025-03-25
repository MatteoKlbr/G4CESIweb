<?php
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if (empty($nom) || empty($description) || empty($email) || empty($telephone)) {
        $_SESSION['create_entreprise_error'] = "Tous les champs doivent être remplis.";
        header("Location: create_entreprise.php");
        exit;
    }

    $sql = "INSERT INTO entreprises (nom, description, email, telephone) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$nom, $description, $email, $telephone])){
        header("Location: manage_entreprises.php");
        exit;
    } else {
        $_SESSION['create_entreprise_error'] = "Erreur lors de la création de l'entreprise.";
        header("Location: create_entreprise.php");
        exit;
    }
} else {
    header("Location: create_entreprise.php");
    exit;
}
?>
