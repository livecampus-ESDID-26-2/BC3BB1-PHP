<?php
// Configuration de la base de données
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASSWORD');

// Vérification que toutes les variables requises sont définies
if (empty($db_host) || empty($db_name) || empty($db_user) || $db_pass === false) {
    die("ERREUR : Les variables suivantes doivent être définies (via .env ou variables d'environnement Docker) : DB_HOST, DB_NAME, DB_USER et DB_PASSWORD.<br>DB_HOST actuel: " . ($db_host ?: 'non défini') . "<br>DB_NAME actuel: " . ($db_name ?: 'non défini') . "<br>DB_USER actuel: " . ($db_user ?: 'non défini'));
}

try {
    // Ajout d'un timeout de connexion et options de connexion
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_PERSISTENT => false
    ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // Message d'erreur détaillé pour le débogage
    $error_msg = "Erreur de connexion à la base de données : " . $e->getMessage();
    $error_msg .= "<br><br>Détails de connexion :";
    $error_msg .= "<br>- Host: " . htmlspecialchars($db_host);
    $error_msg .= "<br>- Database: " . htmlspecialchars($db_name);
    $error_msg .= "<br>- User: " . htmlspecialchars($db_user);
    $error_msg .= "<br><br>Vérifiez que :";
    $error_msg .= "<br>1. Le conteneur MySQL est démarré et en bonne santé (docker compose ps)";
    $error_msg .= "<br>2. DB_HOST est défini à 'db' dans Docker (nom du service)";
    $error_msg .= "<br>3. Les conteneurs sont sur le même réseau Docker";
    die($error_msg);
}

// Démarrage de la session pour gérer l'authentification
session_start();
?>
