<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../requetes.php';

// Vérification de l'authentification
if (!is_logged_in()) {
    redirect('../login.php');
}

// Vérifier que la plaque d'immatriculation est fournie
if (!isset($_GET['plaque']) || empty($_GET['plaque'])) {
    $_SESSION['error'] = 'Plaque d\'immatriculation manquante';
    redirect('../index.php');
}

// Récupérer et nettoyer la plaque d'immatriculation
$plaque_immatriculation = trim($_GET['plaque']);

// Supprimer le véhicule
$success = delete_vehicule($pdo, $plaque_immatriculation);

if ($success) {
    $_SESSION['success'] = 'Véhicule supprimé avec succès';
} else {
    $_SESSION['error'] = 'Erreur lors de la suppression du véhicule';
}

// Rediriger vers la page d'accueil
redirect('../index.php');

