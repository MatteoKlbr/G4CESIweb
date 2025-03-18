<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['id'];

// Récupérer les valeurs actuelles de l'utilisateur (avatar et cv)
$stmtCurrent = $pdo->prepare("SELECT avatar, cv FROM users WHERE id = ?");
$stmtCurrent->execute([$user_id]);
$current = $stmtCurrent->fetch();
$avatar_path = $current['avatar'] ?? '';
$cv_path = $current['cv'] ?? '';

// Récupérer et nettoyer les données du formulaire
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$statut_recherche = trim($_POST['statut_recherche'] ?? '');

// Vérifier que les champs obligatoires sont remplis
if (empty($nom) || empty($prenom) || empty($email)) {
    $_SESSION['edit_profile_error'] = "Tous les champs obligatoires doivent être remplis.";
    header("Location: edit_profile.php");
    exit;
}

// Traitement du téléversement de l'avatar si fourni
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/avatars/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $tmpAvatar = $_FILES['avatar']['tmp_name'];
    $origAvatar = basename($_FILES['avatar']['name']);
    $extAvatar = strtolower(pathinfo($origAvatar, PATHINFO_EXTENSION));
    $allowedAvatar = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extAvatar, $allowedAvatar)) {
        $_SESSION['edit_profile_error'] = "Format d'image non autorisé. Formats acceptés : jpg, jpeg, png, gif.";
        header("Location: edit_profile.php");
        exit;
    }
    $newAvatarName = uniqid('avatar_', true) . '.' . $extAvatar;
    $targetAvatar = $uploadDir . $newAvatarName;
    if (!move_uploaded_file($tmpAvatar, $targetAvatar)) {
        $_SESSION['edit_profile_error'] = "Erreur lors de l'upload de l'avatar.";
        header("Location: edit_profile.php");
        exit;
    }
    $avatar_path = $targetAvatar;
}

// Traitement du téléversement du CV si fourni
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/cv/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $tmpCV = $_FILES['cv']['tmp_name'];
    $origCV = basename($_FILES['cv']['name']);
    $extCV = strtolower(pathinfo($origCV, PATHINFO_EXTENSION));
    // Seul le format PDF est autorisé pour le CV
    if ($extCV !== 'pdf') {
        $_SESSION['edit_profile_error'] = "Format de CV non autorisé. Seul le format PDF est accepté.";
        header("Location: edit_profile.php");
        exit;
    }
    $newCVName = uniqid('cv_', true) . '.' . $extCV;
    $targetCV = $uploadDir . $newCVName;
    if (!move_uploaded_file($tmpCV, $targetCV)) {
        $_SESSION['edit_profile_error'] = "Erreur lors de l'upload du CV.";
        header("Location: edit_profile.php");
        exit;
    }
    $cv_path = $targetCV;
}

try {
    // Mise à jour du profil de l'utilisateur dans la base
    $sql = "UPDATE users SET nom = ?, prenom = ?, email = ?, statut_recherche = ?, avatar = ?, cv = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nom, $prenom, $email, $statut_recherche, $avatar_path, $cv_path, $user_id])) {
        $_SESSION['edit_profile_success'] = "Profil mis à jour avec succès.";
        // Redirige vers Accueil.php avec le paramètre openProfile pour ouvrir la modale profil
        header("Location: Accueil.php?openProfile=1");
        exit;
    } else {
        $_SESSION['edit_profile_error'] = "Erreur lors de la mise à jour du profil.";
        header("Location: edit_profile.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['edit_profile_error'] = "Exception PDO: " . $e->getMessage();
    header("Location: edit_profile.php");
    exit;
}
?>
