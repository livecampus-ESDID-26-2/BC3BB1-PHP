<?php
require_once 'config.php';
require_once 'functions.php';

// Définir l'encodage UTF-8 pour les en-têtes HTTP
header('Content-Type: text/html; charset=utf-8');

// Vérification de l'authentification
if (!is_logged_in()) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accueil — Garage Auto</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/vehicule.css">
</head>
<body>
  <header class="topbar">
    <h1>Garage Automobile</h1>
    <nav>
      <a href="logout.php">Se déconnecter</a>
    </nav>
  </header>
  <main class="container">
    <p>Bienvenue, <?php echo h($_SESSION['username']); ?> ! Vous êtes connecté.</p>
    <?php include 'vehicule/liste.php'; ?>
  </main>
  <script src="js/main.js"></script>
</body>
</html>
