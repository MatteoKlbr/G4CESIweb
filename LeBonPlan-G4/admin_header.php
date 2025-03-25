<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="Bomou Mahamadou">
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
  <link rel="stylesheet" href="Style1.css">
    
</head>
<body>
<header>
    <div class="header-container">
        <center><h4>Dashboard Administrateur</h4></center>
        <nav class="nav-admin">
            <a href="admin_panel.php?section=dashboard">Dashboard</a>
            <a href="admin_panel.php?section=users">Utilisateurs</a>
            <a href="admin_panel.php?section=offres">Offres</a>
            <a href="admin_panel.php?section=entreprises">Entreprises</a>
            <a href="admin_panel.php?section=candidatures">Candidatures</a>
            <div class="auth-buttons">
                <a href="/LeBonPlan-G4/Public/logout.php" class="btn btn-primary">Déconnexion</a>
            </div>
        </nav>
    </div>
</header>
