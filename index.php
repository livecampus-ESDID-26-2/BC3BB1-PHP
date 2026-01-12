<?php
require_once 'config.php';
require_once 'functions.php';

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
    <p>Cette page sert d'exemple pour l'authentification.</p>
  </main>
  <script src="js/main.js"></script>
</body>
</html>
