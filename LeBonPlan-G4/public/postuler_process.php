<?php
////////////////////////////////
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
require_once 'config.php';
/////////////////////////////////////////
require_once '../models/Candidature.php'; // Inclusion du modèle Candidature

// Redirige si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offre_id   = trim($_POST['offre_id'] ?? '');
    $lettre     = trim($_POST['lettre'] ?? '');
    $etudiant_id = $_SESSION['id'];

    // Vérifier que les champs obligatoires sont remplis
    if (empty($offre_id) || empty($lettre)) {
        $_SESSION['postuler_error'] = "Tous les champs sont obligatoires.";
        header("Location: postuler.php?id=" . $offre_id);
        exit;
    }

    // Gestion du téléversement du CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/cv/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileTmp  = $_FILES['cv']['tmp_name'];
        $fileName = basename($_FILES['cv']['name']);
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Vérifier que le fichier est au format PDF uniquement
        if ($fileExt !== 'pdf') {
            $_SESSION['postuler_error'] = "Seuls les fichiers PDF sont autorisés.";
            header("Location: postuler.php?id=" . $offre_id);
            exit;
        }

        // Vérifier la taille du fichier (2 Mo maximum)
        $maxSize = 2 * 1024 * 1024; // 2 Mo
        if ($_FILES['cv']['size'] > $maxSize) {
            $_SESSION['postuler_error'] = "La taille du fichier dépasse 2 Mo.";
            header("Location: postuler.php?id=" . $offre_id);
            exit;
        }

        $newFileName = uniqid('cv_', true) . '.' . $fileExt;
        $targetFile  = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmp, $targetFile)) {
            $_SESSION['postuler_error'] = "Erreur lors du téléversement du CV.";
            header("Location: postuler.php?id=" . $offre_id);
            exit;
        }
    } else {
        $_SESSION['postuler_error'] = "Veuillez téléverser votre CV.";
        header("Location: postuler.php?id=" . $offre_id);
        exit;
    }

    try {
        // Instanciation du modèle Candidature et enregistrement de la candidature
        $candidatureModel = new Candidature($pdo);
        if ($candidatureModel->apply($etudiant_id, $offre_id, $lettre, $targetFile)) {
            header("Location: postuler.php?id=$offre_id&success=1");
            exit;
        } else {
            $_SESSION['postuler_error'] = "Erreur lors de l'enregistrement de la candidature.";
            header("Location: postuler.php?id=" . $offre_id);
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['postuler_error'] = "Exception PDO: " . $e->getMessage();
        header("Location: postuler.php?id=" . $offre_id);
        exit;
    }
} else {
    header("Location: Offres.php");
    exit;
}
?>
