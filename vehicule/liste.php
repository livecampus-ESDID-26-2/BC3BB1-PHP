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
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo h($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert"><?php echo h($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <?php if (empty($vehicules)): ?>
        <div class="no-vehicules">
            <p>Aucun véhicule</p>
            <a href="vehicule/create.php" class="btn-primary">
                Ajouter votre premier véhicule
            </a>
        </div>
    <?php else: ?>
        <div style="margin-bottom: 1.5rem;">
            <a href="vehicule/create.php" class="btn-primary">
                Ajouter un véhicule
            </a>
        </div>
        <table class="vehicules-table">
            <thead>
                <tr>
                    <th>Plaque d'immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Client</th>
                    <th>Actions</th>
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
                        <td>
                            <div class="action-buttons">
                                <a href="vehicule/edit.php?plaque=<?php echo urlencode($vehicule['plaque_immatriculation_raw']); ?>" 
                                   class="edit-btn" 
                                   title="Modifier">
                                    <span class="edit-icon">✏️</span>
                                </a>
                                <a href="vehicule/delete.php?plaque=<?php echo urlencode($vehicule['plaque_immatriculation_raw']); ?>" 
                                   class="delete-btn" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');"
                                   title="Supprimer">
                                    <span class="delete-icon">🗑️</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

