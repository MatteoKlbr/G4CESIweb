<?php 
$pageTitle = "Inscription - LeBonPlan";
$pageDescription = "Inscription pour StageAlternance, trouvez l'opportunité qui vous correspond.";
include 'header.php';
?>

<!-- Contenu principal -->
<main>
  <section>
    <center><h1>Formulaire d'inscription</h1></center>
    <?php 
    if (isset($_SESSION['register_error'])) {
        echo '<p style="color:red;">' . $_SESSION['register_error'] . '</p>';
        unset($_SESSION['register_error']);
    }
    ?>
    <form action="register_process.php" method="POST">
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
      </div>
      <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
      </div>
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" required>
      </div>
      <!-- Sélection du rôle (par défaut, "Étudiant") -->
      <div class="form-group">
        <label for="role">Rôle :</label>
        <select id="role" name="role">
          <option value="etudiant" selected>Étudiant</option>
          <option value="pilote">Pilote</option>
          <!-- Vous pouvez ajouter une option pour l'administrateur si nécessaire -->
          <!-- <option value="admin">Administrateur</option> -->
        </select>
      </div>
      <button type="submit" class="btnn">S'inscrire</button>
    </form>
  </section>
</main>

<?php include 'footer.php'; ?>
