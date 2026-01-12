<?php
/**
 * Fonctions de requêtes SQL pour les véhicules
 */

// Inclusion de functions.php pour utiliser la fonction h()
require_once __DIR__ . '/functions.php';

/**
 * Récupère tous les véhicules avec leurs relations (marque, modèle, année, client)
 * Les données sont échappées avec la fonction h() pour la sécurité XSS
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @return array Tableau associatif contenant les véhicules ou tableau vide en cas d'erreur
 */
function get_all_vehicules($pdo) {
    try {
        $sql = "SELECT 
                    v.plaque_immatriculation,
                    mv.nom AS marque,
                    modv.nom AS modele,
                    av.annee,
                    c.nom AS client_nom,
                    c.prenom AS client_prenom
                FROM vehicule v
                LEFT JOIN marque_vehicule mv ON v.marque_id = mv.id
                LEFT JOIN modele_vehicule modv ON v.modele_id = modv.id
                LEFT JOIN annee_vehicule av ON v.annee_id = av.id
                LEFT JOIN client c ON v.client_id = c.id
                ORDER BY v.plaque_immatriculation";
        
        $stmt = $pdo->query($sql);
        $vehicules = $stmt->fetchAll();
        
        // Échapper toutes les données avec la fonction h() pour la sécurité XSS
        foreach ($vehicules as &$vehicule) {
            $vehicule['plaque_immatriculation'] = $vehicule['plaque_immatriculation'] ? h($vehicule['plaque_immatriculation']) : '';
            $vehicule['marque'] = $vehicule['marque'] ? h($vehicule['marque']) : '';
            $vehicule['modele'] = $vehicule['modele'] ? h($vehicule['modele']) : '';
            $vehicule['annee'] = $vehicule['annee'] ? h((string)$vehicule['annee']) : '';
            if ($vehicule['client_nom'] && $vehicule['client_prenom']) {
                $vehicule['client_nom'] = h($vehicule['client_nom']);
                $vehicule['client_prenom'] = h($vehicule['client_prenom']);
            } else {
                $vehicule['client_nom'] = null;
                $vehicule['client_prenom'] = null;
            }
        }
        unset($vehicule); // Libérer la référence
        
        return $vehicules;
    } catch (PDOException $e) {
        return [];
    }
}

