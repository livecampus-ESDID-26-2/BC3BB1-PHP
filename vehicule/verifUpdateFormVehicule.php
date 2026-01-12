<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../requetes.php';

// Vérification de l'authentification
if (!is_logged_in()) {
    redirect('../login.php');
}

// Vérifier que le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Méthode non autorisée';
    redirect('../index.php');
}

// Validation des champs obligatoires
$old_plaque = trim($_POST['old_plaque'] ?? '');
$plaque_immatriculation = trim($_POST['plaque_immatriculation'] ?? '');
$marque_id = isset($_POST['marque_id']) ? (int)$_POST['marque_id'] : 0;
$modele_id = isset($_POST['modele_id']) ? (int)$_POST['modele_id'] : 0;
$annee_id = isset($_POST['annee_id']) ? (int)$_POST['annee_id'] : 0;
$client_id = isset($_POST['client_id']) && !empty($_POST['client_id']) ? (int)$_POST['client_id'] : null;

// Validation
$errors = [];

if (empty($old_plaque)) {
    $errors[] = 'La plaque d\'immatriculation originale est manquante';
}

if (empty($plaque_immatriculation)) {
    $errors[] = 'La plaque d\'immatriculation est obligatoire';
}

if ($marque_id <= 0) {
    $errors[] = 'La marque est obligatoire';
}

if ($modele_id <= 0) {
    $errors[] = 'Le modèle est obligatoire';
}

if ($annee_id <= 0) {
    $errors[] = 'L\'année est obligatoire';
}

if (!empty($errors)) {
    $_SESSION['error'] = implode('<br>', $errors);
    redirect('edit.php?plaque=' . urlencode($old_plaque));
}

// Mettre à jour le véhicule
$success = update_vehicule($pdo, $old_plaque, $plaque_immatriculation, $marque_id, $modele_id, $annee_id, $client_id);

if ($success) {
    $_SESSION['success'] = 'Véhicule modifié avec succès';
    redirect('../index.php');
} else {
    $_SESSION['error'] = 'Erreur lors de la modification du véhicule. La nouvelle plaque d\'immatriculation existe peut-être déjà.';
    redirect('edit.php?plaque=' . urlencode($old_plaque));
}

