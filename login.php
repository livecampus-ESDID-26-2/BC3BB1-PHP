<?php
require_once 'config.php';
require_once 'functions.php';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (is_logged_in()) {
    redirect('index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect('index.php');
        } else {
            $error = "Identifiants invalides, veuillez réessayer.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion — Garage Auto</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-body">
  <main class="auth-card">
    <h1>Garage Automobile</h1>
    <h2>Connexion</h2>

    <?php if ($error): ?>
      <div class="alert"><?php echo h($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" class="auth-form">
      <label for="id_username">Nom d'utilisateur</label>
      <input id="id_username" name="username" type="text" required autofocus value="<?php echo h($_POST['username'] ?? ''); ?>" />

      <label for="id_password">Mot de passe</label>
      <input id="id_password" name="password" type="password" required />

      <button type="submit" class="btn-primary">Se connecter</button>
    </form>
    <!-- Le lien mot de passe oublié n'est pas implémenté dans cette version simple -->
    <!-- <p style="margin-top:1rem"><a href="#">Mot de passe oublié ?</a></p> -->
  </main>

  <script src="js/main.js"></script>
</body>
</html>
