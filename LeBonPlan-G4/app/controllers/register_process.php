<?php
session_start();
require_once 'config.php'; // Fichier de connexion à la base (objet PDO $pdo)

// Vérifier que la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';

    // Vérifier que tous les champs sont remplis
    if (empty($nom) || empty($prenom) || empty($email) || empty($motdepasse)) {
        $_SESSION['register_error'] = "Tous les champs sont obligatoires.";
        header("Location: inscription.php");
        exit;
    }

    // Vérifier que l'email n'est pas déjà utilisé
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['register_error'] = "Cet email est déjà utilisé.";
        header("Location: inscription.php");
        exit;
    }

    // Hacher le mot de passe
    $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la base (ici, rôle par défaut "etudiant")
    $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $role = 'etudiant';
    $result = $stmt->execute([$nom, $prenom, $email, $hashedPassword, $role]);

    if ($result) {
        // En cas de succès, on peut rediriger l'utilisateur vers la page de connexion avec un message de succès
        $_SESSION['register_success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header("Location: connexion.php");
        exit;
    } else {
        // Si l'insertion échoue, renvoyer un message d'erreur
        $_SESSION['register_error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
        header("Location: inscription.php");
        exit;
    }
} else {
    // Si l'accès n'est pas en POST, rediriger vers le formulaire d'inscription
    header("Location: inscription.php");
    exit;
}
?>
