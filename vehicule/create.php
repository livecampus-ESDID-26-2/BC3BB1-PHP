<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../requetes.php';

// Vérification de l'authentification
if (!is_logged_in()) {
    redirect('../login.php');
}

// Récupération des données pour les menus déroulants
$clients = get_all_clients($pdo);
$marques = get_all_marques($pdo);
$modeles = get_all_modeles($pdo);
$annees = get_all_annees($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ajouter un véhicule — Garage Auto</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/vehicule.css">
</head>
<body>
  <header class="topbar">
    <h1>Garage Automobile</h1>
    <nav>
      <a href="../index.php">Retour</a>
      <a href="../logout.php">Se déconnecter</a>
    </nav>
  </header>
  <main class="container">
    <div class="vehicules-section">
      <h2>Ajouter un véhicule</h2>
      
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert"><?php echo h($_SESSION['error']); unset($_SESSION['error']); ?></div>
      <?php endif; ?>
      
      <form method="POST" action="verifCreateFormVehicule.php" class="vehicule-form">
        <div class="form-group">
          <label for="plaque_immatriculation">Plaque d'immatriculation *</label>
          <input type="text" 
                 id="plaque_immatriculation" 
                 name="plaque_immatriculation" 
                 required 
                 maxlength="20"
                 placeholder="Ex: AB-123-CD">
        </div>
        
        <div class="form-group">
          <label for="marque_id">Marque *</label>
          <select id="marque_id" name="marque_id" required>
            <option value="">Sélectionner une marque</option>
            <?php foreach ($marques as $marque): ?>
              <option value="<?php echo $marque['id']; ?>"><?php echo $marque['nom']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="modele_id">Modèle *</label>
          <select id="modele_id" name="modele_id" required>
            <option value="">Sélectionner un modèle</option>
            <?php foreach ($modeles as $modele): ?>
              <option value="<?php echo $modele['id']; ?>"><?php echo $modele['nom']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="annee_id">Année *</label>
          <select id="annee_id" name="annee_id" required>
            <option value="">Sélectionner une année</option>
            <?php foreach ($annees as $annee): ?>
              <option value="<?php echo $annee['id']; ?>"><?php echo $annee['annee']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="client_id">Client</label>
          <select id="client_id" name="client_id">
            <option value="">Aucun client</option>
            <?php foreach ($clients as $client): ?>
              <option value="<?php echo $client['id']; ?>">
                <?php echo $client['prenom'] . ' ' . $client['nom']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn-primary">Ajouter le véhicule</button>
          <a href="../index.php" class="btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </main>
  <script src="../js/main.js"></script>
</body>
</html>

