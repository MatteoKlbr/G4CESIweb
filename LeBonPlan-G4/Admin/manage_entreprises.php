<?php
// Pour tester, on commente la vérification d'authentification
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once 'config.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion des Entreprises - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f4f4f4; }
        .section-title { text-align: center; margin: 20px 0; }
        .action-btn { background: #ff6600; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .action-btn.btn-danger { background: #cc0000; }
    </style>
</head>
<body>
    <!-- Pour tester, vous pouvez inclure un header commun si besoin -->
    <header>
        <div class="header-container">
            <center><h4>Gestion des Entreprises</h4></center>
            <center><img src="/images/logo-lbp-header.png" alt="LeBonPlan Logo"></center>
            <nav>
                <a href="Accueil.php">Accueil</a> |
                <a href="admin_panel.php?section=entreprises">Entreprises</a> |
                <a href="create_entreprise.php">Ajouter une entreprise</a> |
                <a href="/logout.php">Déconnexion</a>
            </nav>
        </div>
    </header>
    
    <main>
        <h1 class="section-title">Liste des Entreprises</h1>
        <?php
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
                      <a href="edit_entreprise.php?id=' . htmlspecialchars($entreprise['id']) . '" class="action-btn">Modifier</a> |
                      <a href="delete_entreprise.php?id=' . htmlspecialchars($entreprise['id']) . '" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</a>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p style="text-align:center;">Aucune entreprise trouvée.</p>';
        }
        ?>
    </main>
    
    <footer>
        <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
