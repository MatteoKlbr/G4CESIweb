<?php
session_start(); // À décommenter pour la production
// Pour tester, vous pouvez définir manuellement les variables de session
// $_SESSION['id'] = 1;
// $_SESSION['role'] = 'admin';

require_once 'config.php';

// Active l'affichage des erreurs (pour le débogage uniquement, à désactiver en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données du formulaire
    $entreprise_id    = trim($_POST['entreprise_id'] ?? '');
    $titre             = trim($_POST['titre'] ?? '');
    $description       = trim($_POST['description'] ?? '');
    $competences       = trim($_POST['competences'] ?? '');
    $base_remuneration = trim($_POST['base_remuneration'] ?? '');
    $date_publication  = $_POST['date_publication'] ?? '';
    $date_expiration   = $_POST['date_expiration'] ?? '';
    $localisation      = trim($_POST['localisation'] ?? '');

    // Vérifier que tous les champs sont remplis
    if (empty($entreprise_id) || empty($titre) || empty($description) || empty($competences) || empty($base_remuneration) || empty($date_publication) || empty($date_expiration) || empty($localisation)) {
        $_SESSION['create_offre_error'] = "Tous les champs sont obligatoires.";
        header("Location: create_offre.php");
        exit;
    }
    
    // Vérifier que l'ID entreprise existe dans la table 'entreprises'
    $stmtCheck = $pdo->prepare("SELECT id FROM entreprises WHERE id = ?");
    $stmtCheck->execute([$entreprise_id]);
    if (!$stmtCheck->fetch()) {
        $_SESSION['create_offre_error'] = "ID entreprise invalide. L'entreprise n'existe pas.";
        header("Location: create_offre.php");
        exit;
    }

    try {
        // Insertion de l'offre dans la base, en enregistrant la date de création avec NOW()
        $sql = "INSERT INTO offres (entreprise_id, titre, description, competences, base_remuneration, date_publication, date_expiration, localisation, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$entreprise_id, $titre, $description, $competences, $base_remuneration, $date_publication, $date_expiration, $localisation])) {
            // Redirection vers la page des offres pour les étudiants
            header("Location: admin_panel.php?section=offres");
            exit;
        } else {
            $errorInfo = $stmt->errorInfo();
            $_SESSION['create_offre_error'] = "Erreur lors de la création de l'offre: " . $errorInfo[2];
            header("Location: create_offre.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['create_offre_error'] = "Exception PDO: " . $e->getMessage();
        header("Location: create_offre.php");
        exit;
    }
} else {
    header("Location: create_offre.php");
    exit;
}
?>
