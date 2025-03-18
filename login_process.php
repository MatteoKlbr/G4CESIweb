<?php
require_once 'config.php'; // Ce fichier démarre la session et établit la connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';

    if (empty($email) || empty($motdepasse)) {
        $_SESSION['login_error'] = "Tous les champs sont obligatoires.";
        header("Location: connexion.php");
        exit;
    }

    // Rechercher l'utilisateur dans la base
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['password'])) {
        // Définir les variables de session
        $_SESSION['id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'] . " " . $user['prenom'];
        $_SESSION['role'] = $user['role'];

        // Mettre à jour le champ last_login avec l'heure actuelle
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateStmt->execute([$user['id']]);

        // Redirection en fonction du rôle
        if ($user['role'] === 'pilote') {
            header("Location: dashboard_pilote.php");
        } else {
            header("Location: Accueil.php");
        }
        exit;
    } else {
        $_SESSION['login_error'] = "Identifiants incorrects.";
        header("Location: connexion.php");
        exit;
    }
} else {
    header("Location: connexion.php");
    exit;
}
?>
