<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../requetes.php';

// Vérification de l'authentification
if (!is_logged_in()) {
    redirect('login.php');
}

// Récupération de tous les véhicules avec leurs relations
$vehicules = get_all_vehicules($pdo);
?>

<div class="vehicules-section">
    <h2>Liste des véhicules</h2>
    
    <?php if (empty($vehicules)): ?>
        <div class="no-vehicules">
            <p>Aucun véhicule</p>
            <button class="btn-primary" onclick="alert('Fonctionnalité à venir')">
                Ajouter votre premier véhicule
            </button>
        </div>
    <?php else: ?>
        <table class="vehicules-table">
            <thead>
                <tr>
                    <th>Plaque d'immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Client</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicules as $vehicule): ?>
                    <tr>
                        <td><?php echo $vehicule['plaque_immatriculation']; ?></td>
                        <td><?php echo $vehicule['marque']; ?></td>
                        <td><?php echo $vehicule['modele']; ?></td>
                        <td><?php echo $vehicule['annee']; ?></td>
                        <td>
                            <?php 
                            if ($vehicule['client_nom'] && $vehicule['client_prenom']) {
                                echo $vehicule['client_prenom'] . ' ' . $vehicule['client_nom'];
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

