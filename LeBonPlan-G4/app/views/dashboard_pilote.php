<?php

session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'pilote') {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';

// Récupérer les informations du pilote connecté
$pilot_id = $_SESSION['id'];
$stmtPilot = $pdo->prepare("SELECT id, nom, prenom, email, created_at FROM users WHERE id = ? AND role = 'pilote'");
$stmtPilot->execute([$pilot_id]);
$pilot = $stmtPilot->fetch();

// Récupérer la liste des étudiants (vous pouvez ajuster la requête si vous souhaitez filtrer par promotion)
$stmtStudents = $pdo->query("SELECT id, nom, prenom, email, created_at FROM users WHERE role = 'etudiant' ORDER BY created_at DESC");
$students = $stmtStudents->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Jérémy GALLET">
    <meta name="description" content="Dashboard pilote - Gestion des étudiants">
    <link rel="stylesheet" href="Style.css">
    <title>Dashboard Pilote - LeBonPlan</title>
</head>
<body>
    <header>
         <div class="header-container">
             <center><h4>Dashboard Pilote</h4></center>
             <center>
                 <img src="./images/logo-lbp-header.png" alt="LeBonPlan Logo">
             </center>
             <nav>
                 <a href="Accueil.php">Accueil</a>&nbsp;|&nbsp;
                 <a href="Entreprise.php">Entreprises</a>&nbsp;|&nbsp;
                 <a href="Offres.php">Offres</a>&nbsp;|&nbsp;
                 <a href="Wishlist.php">Wishlist</a>&nbsp;|&nbsp;
                 <a href="Contact.php">Contact</a>&nbsp;|&nbsp;
                 <a href="dashboard_pilote.php">Dashboard Pilote</a>
                 <div class="auth-buttons">
                     <a href="dashboard_pilote.php" class="btn">Mon Dashboard</a>
                     <a href="logout.php" class="btn btn-primary">Déconnexion</a>
                 </div>
             </nav>
         </div>
    </header>

    <main>
         <section>
             <h1>Bienvenue, <?php echo htmlspecialchars($pilot['prenom'] . " " . $pilot['nom']); ?> !</h1>
             <p>Voici la liste des étudiants de votre promotion :</p>
             
             <?php if (!empty($students)): ?>
                 <table border="1" cellpadding="10">
                     <thead>
                         <tr>
                             <th>ID</th>
                             <th>Nom</th>
                             <th>Prénom</th>
                             <th>Email</th>
                             <th>Date d'inscription</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($students as $student): ?>
                         <tr>
                             <td><?php echo htmlspecialchars($student['id']); ?></td>
                             <td><?php echo htmlspecialchars($student['nom']); ?></td>
                             <td><?php echo htmlspecialchars($student['prenom']); ?></td>
                             <td><?php echo htmlspecialchars($student['email']); ?></td>
                             <td><?php echo htmlspecialchars($student['created_at']); ?></td>
                         </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
             <?php else: ?>
                 <p>Aucun étudiant trouvé.</p>
             <?php endif; ?>
         </section>
    </main>

    <footer>
         <p>&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
