<?php
require_once 'config.php';
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($motdepasse)) {
        $_SESSION['register_error'] = "Tous les champs sont obligatoires.";
        header("Location: Inscription.php");
        exit;
    }

    $userModel = new User($pdo);
    if (!$userModel->register($nom, $prenom, $email, $motdepasse)) {
        $_SESSION['register_error'] = "Cet email est déjà utilisé ou une erreur s'est produite.";
        header("Location: Inscription.php");
        exit;
    } else {
        $_SESSION['register_success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header("Location: Connexion.php");
        exit;
    }
} else {
    header("Location: Inscription.php");
    exit;
}

?>
