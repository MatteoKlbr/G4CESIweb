<?php
// Pour tester, décommentez ces lignes en production
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';

// Définir la section (dashboard par défaut)
$section = $_GET['section'] ?? 'dashboard';
$message = '';

// Traitement des actions POST pour la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($section === 'users' && $action === 'delete_user') {
        $userId = $_POST['user_id'] ?? '';
        if ($userId) {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $message = "Utilisateur supprimé.";
        }
    } elseif ($section === 'offres' && $action === 'delete_offre') {
        $offreId = $_POST['offre_id'] ?? '';
        if ($offreId) {
            $stmt = $pdo->prepare("DELETE FROM offres WHERE id = ?");
            $stmt->execute([$offreId]);
            $message = "Offre supprimée.";
        }
    } elseif ($section === 'entreprises' && $action === 'delete_entreprise') {
        $entrepriseId = $_POST['entreprise_id'] ?? '';
        if ($entrepriseId) {
            $stmt = $pdo->prepare("DELETE FROM entreprises WHERE id = ?");
            $stmt->execute([$entrepriseId]);
            $message = "Entreprise supprimée.";
        }
    } elseif ($section === 'candidatures' && $action === 'delete_candidature') {
        $candId = $_POST['candidature_id'] ?? '';
        if ($candId) {
            $stmt = $pdo->prepare("DELETE FROM candidatures WHERE id = ?");
            $stmt->execute([$candId]);
            $message = "Candidature supprimée.";
        }
    }
    header("Location: admin_panel.php?section=" . $section);
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Dashboard Administrateur - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        .nav-admin { text-align: center; margin: 20px 0; }
        .nav-admin a { margin: 0 10px; text-decoration: none; font-weight: bold; color: #ff6600; }
        .message { text-align: center; color: green; margin: 10px 0; }
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f4f4f4; }
        .section-title { text-align: center; margin: 20px 0; }
        .action-btn { background: #ff6600; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .action-btn.btn-danger { background: #cc0000; }
    </style>
</head>
<body>
    <header>
         <div class="header-container">
             <center><h4>Dashboard Administrateur</h4></center>
             <center><img src="/images/logo-lbp-header.png" alt="LeBonPlan Logo"></center>
             <nav>
                 <!-- Navigation simplifiée pour l'administrateur -->
                 <a href="admin_panel.php?section=dashboard">Dashboard</a>|
                 <a href="admin_panel.php?section=users">Utilisateurs</a>|
                 <a href="admin_panel.php?section=offres">Offres</a>|
                 <a href="admin_panel.php?section=entreprises">Entreprises</a>|
                 <a href="admin_panel.php?section=candidatures">Candidatures</a>|
                 <div class="auth-buttons">
                     <a href="admin_panel.php" class="btn">Admin Panel</a>
                     <a href="logout.php" class="btn btn-primary">Déconnexion</a>
                 </div>
             </nav>
         </div>
    </header>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <main>
    <?php
    switch ($section) {
        case 'users':
            echo '<h1 class="section-title">Gestion des Utilisateurs</h1>';
            $stmt = $pdo->query("SELECT id, nom, prenom, email, role, created_at FROM users ORDER BY created_at DESC");
            $users = $stmt->fetchAll();
            if ($users) {
                echo '<table>';
                echo '<thead><tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Email</th>
                      <th>Rôle</th>
                      <th>Date d\'inscription</th>
                      <th>Actions</th>
                      </tr></thead><tbody>';
                foreach ($users as $user) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['nom']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['prenom']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['role']) . '</td>';
                    echo '<td>' . htmlspecialchars($user['created_at']) . '</td>';
                    echo '<td>
                         <form action="admin_panel.php?section=users" method="post" style="display:inline;">
                             <input type="hidden" name="action" value="delete_user">
                             <input type="hidden" name="user_id" value="' . htmlspecialchars($user['id']) . '">
                             <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                         </form>
                         </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p style="text-align:center;">Aucun utilisateur trouvé.</p>';
            }
            break;

        case 'offres':
            echo '<h1 class="section-title">Gestion des Offres</h1>';
            echo '<div style="text-align:center;">
                    <a href="create_offre.php" class="action-btn">Ajouter une offre</a>
                  </div>';
            // Liste des offres avec jointure pour afficher le nom de l'entreprise
            $sql = "SELECT o.id, o.titre, o.description, o.localisation, o.date_publication, e.nom AS entreprise
                    FROM offres o
                    LEFT JOIN entreprises e ON o.entreprise_id = e.id
                    ORDER BY o.date_publication DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $offres = $stmt->fetchAll();
            echo '<h1 class="section-title">Liste des Offres</h1>';
            if ($offres) {
                echo '<table>';
                echo '<thead><tr>
                      <th>ID</th>
                      <th>Titre</th>
                      <th>Entreprise</th>
                      <th>Localisation</th>
                      <th>Date Publication</th>
                      <th>Actions</th>
                      </tr></thead><tbody>';
                foreach ($offres as $offre) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($offre['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($offre['titre']) . '</td>';
                    echo '<td>' . htmlspecialchars($offre['entreprise'] ?? 'Non défini') . '</td>';
                    echo '<td>' . htmlspecialchars($offre['localisation']) . '</td>';
                    echo '<td>' . htmlspecialchars($offre['date_publication']) . '</td>';
                    echo '<td>
                          <a href="edit_offre.php?id=' . htmlspecialchars($offre['id']) . '" class="action-btn">Modifier</a> |
                          <form action="admin_panel.php?section=offres" method="post" style="display:inline;">
                              <input type="hidden" name="action" value="delete_offre">
                              <input type="hidden" name="offre_id" value="' . htmlspecialchars($offre['id']) . '">
                              <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">
                                  Supprimer
                              </button>
                          </form>
                          </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p style="text-align:center;">Aucune offre publiée pour le moment.</p>';
            }
            break;

        case 'entreprises':
            echo '<h1 class="section-title">Gestion des Entreprises</h1>';
            echo '<div style="text-align:center;">
                    <a href="create_entreprise.php" class="action-btn">Ajouter une entreprise</a>
                  </div>';
            $stmt = $pdo->query("SELECT * FROM entreprises ORDER BY nom ASC");
            $entreprises = $stmt->fetchAll();
            if ($entreprises) {
                echo '<table>';
                echo '<thead><tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Email</th>
                      <th>Téléphone</th>
                      <th>Actions</th>
                      </tr></thead><tbody>';
                foreach ($entreprises as $entreprise) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($entreprise['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($entreprise['nom']) . '</td>';
                    echo '<td>' . htmlspecialchars($entreprise['description']) . '</td>';
                    echo '<td>' . htmlspecialchars($entreprise['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($entreprise['telephone']) . '</td>';
                    echo '<td>
                          <a href="edit_entreprise.php?id=' . htmlspecialchars($entreprise['id']) . '">Modifier</a> |
                          <form action="admin_panel.php?section=entreprises" method="post" style="display:inline;">
                              <input type="hidden" name="action" value="delete_entreprise">
                              <input type="hidden" name="entreprise_id" value="' . htmlspecialchars($entreprise['id']) . '">
                              <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">
                                  Supprimer
                              </button>
                          </form>
                          </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p style="text-align:center;">Aucune entreprise trouvée.</p>';
            }
            break;

        case 'candidatures':
            echo '<h1 class="section-title">Gestion des Candidatures</h1>';
            // Récupérer les candidatures avec les informations de l'étudiant et de l'offre
            $sql = "SELECT c.id, c.date_candidature, c.cv, c.lettre_motivation,
                           u.nom, u.prenom,
                           o.titre AS offre_titre
                    FROM candidatures c
                    LEFT JOIN users u ON c.etudiant_id = u.id
                    LEFT JOIN offres o ON c.offre_id = o.id
                    ORDER BY c.date_candidature DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $candidatures = $stmt->fetchAll();
            if ($candidatures) {
                echo '<table>';
                echo '<thead><tr>
                      <th>ID</th>
                      <th>Étudiant</th>
                      <th>Offre</th>
                      <th>Date</th>
                      <th>CV</th>
                      <th>Lettre de motivation</th>
                      <th>Actions</th>
                      </tr></thead><tbody>';
                foreach ($candidatures as $cand) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($cand['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($cand['prenom'] . " " . $cand['nom']) . '</td>';
                    echo '<td>' . htmlspecialchars($cand['offre_titre']) . '</td>';
                    echo '<td>' . htmlspecialchars($cand['date_candidature']) . '</td>';
                    echo '<td>';
                    if (!empty($cand['cv'])) {
                        echo '<a href="' . htmlspecialchars($cand['cv']) . '" target="_blank" class="action-btn">Voir CV</a>';
                    } else {
                        echo 'Aucun';
                    }
                    echo '</td>';
                    echo '<td>' . htmlspecialchars(substr($cand['lettre_motivation'], 0, 100)) . (strlen($cand['lettre_motivation']) > 100 ? '...' : '') . '</td>';
                    echo '<td>
                          <form action="admin_panel.php?section=candidatures" method="post" style="display:inline;">
                              <input type="hidden" name="action" value="delete_candidature">
                              <input type="hidden" name="candidature_id" value="' . htmlspecialchars($cand['id']) . '">
                              <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                          </form>
                          </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p style="text-align:center;">Aucune candidature trouvée.</p>';
            }
            break;

        default:
            // Dashboard par défaut
            $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
            $total_offres = $pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
            $total_enterprises = $pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
            echo '<h1 class="section-title">Dashboard Administrateur</h1>';
            echo '<div class="stats">';
            echo '<div class="stat"><h3>Total Utilisateurs</h3><p>' . $total_users . '</p></div>';
            echo '<div class="stat"><h3>Total Offres</h3><p>' . $total_offres . '</p></div>';
            echo '<div class="stat"><h3>Total Entreprises</h3><p>' . $total_enterprises . '</p></div>';
            echo '</div>';
            break;
    }
    ?>
    </main>

    <footer>
         <p style="text-align:center;">&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
