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
            // Garder la valeur originale de la plaque pour l'URL
            $vehicule['plaque_immatriculation_raw'] = $vehicule['plaque_immatriculation'];
            // Échapper la plaque pour l'affichage
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

/**
 * Supprime un véhicule par sa plaque d'immatriculation
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @param string $plaque_immatriculation Plaque d'immatriculation du véhicule à supprimer
 * @return bool True si la suppression a réussi, False sinon
 */
function delete_vehicule($pdo, $plaque_immatriculation) {
    try {
        $sql = "DELETE FROM vehicule WHERE plaque_immatriculation = :plaque";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':plaque', $plaque_immatriculation, PDO::PARAM_STR);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Récupère tous les clients
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @return array Tableau associatif contenant les clients
 */
function get_all_clients($pdo) {
    try {
        $sql = "SELECT id, nom, prenom FROM client ORDER BY nom, prenom";
        $stmt = $pdo->query($sql);
        $clients = $stmt->fetchAll();
        
        // Échapper les données avec h()
        foreach ($clients as &$client) {
            $client['nom'] = h($client['nom']);
            $client['prenom'] = h($client['prenom']);
        }
        unset($client);
        
        return $clients;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Récupère toutes les marques
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @return array Tableau associatif contenant les marques
 */
function get_all_marques($pdo) {
    try {
        $sql = "SELECT id, nom FROM marque_vehicule ORDER BY nom";
        $stmt = $pdo->query($sql);
        $marques = $stmt->fetchAll();
        
        // Échapper les données avec h()
        foreach ($marques as &$marque) {
            $marque['nom'] = h($marque['nom']);
        }
        unset($marque);
        
        return $marques;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Récupère tous les modèles
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @return array Tableau associatif contenant les modèles
 */
function get_all_modeles($pdo) {
    try {
        $sql = "SELECT id, nom FROM modele_vehicule ORDER BY nom";
        $stmt = $pdo->query($sql);
        $modeles = $stmt->fetchAll();
        
        // Échapper les données avec h()
        foreach ($modeles as &$modele) {
            $modele['nom'] = h($modele['nom']);
        }
        unset($modele);
        
        return $modeles;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Récupère toutes les années
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @return array Tableau associatif contenant les années
 */
function get_all_annees($pdo) {
    try {
        $sql = "SELECT id, annee FROM annee_vehicule ORDER BY annee DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Crée un nouveau véhicule
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @param string $plaque_immatriculation Plaque d'immatriculation
 * @param int $marque_id ID de la marque
 * @param int $modele_id ID du modèle
 * @param int $annee_id ID de l'année
 * @param int|null $client_id ID du client (optionnel)
 * @return bool True si la création a réussi, False sinon
 */
function create_vehicule($pdo, $plaque_immatriculation, $marque_id, $modele_id, $annee_id, $client_id = null) {
    try {
        $sql = "INSERT INTO vehicule (plaque_immatriculation, marque_id, modele_id, annee_id, client_id) 
                VALUES (:plaque, :marque_id, :modele_id, :annee_id, :client_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':plaque', $plaque_immatriculation, PDO::PARAM_STR);
        $stmt->bindValue(':marque_id', $marque_id, PDO::PARAM_INT);
        $stmt->bindValue(':modele_id', $modele_id, PDO::PARAM_INT);
        $stmt->bindValue(':annee_id', $annee_id, PDO::PARAM_INT);
        $stmt->bindValue(':client_id', $client_id, $client_id ? PDO::PARAM_INT : PDO::PARAM_NULL);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Récupère un véhicule par sa plaque d'immatriculation
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @param string $plaque_immatriculation Plaque d'immatriculation
 * @return array|false Tableau associatif contenant le véhicule ou False si non trouvé
 */
function get_vehicule_by_plaque($pdo, $plaque_immatriculation) {
    try {
        $sql = "SELECT 
                    v.plaque_immatriculation,
                    v.marque_id,
                    v.modele_id,
                    v.annee_id,
                    v.client_id,
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
                WHERE v.plaque_immatriculation = :plaque";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':plaque', $plaque_immatriculation, PDO::PARAM_STR);
        $stmt->execute();
        
        $vehicule = $stmt->fetch();
        
        if ($vehicule) {
            // Garder la valeur originale de la plaque pour l'URL
            $vehicule['plaque_immatriculation_raw'] = $vehicule['plaque_immatriculation'];
            // Échapper la plaque pour l'affichage
            $vehicule['plaque_immatriculation'] = h($vehicule['plaque_immatriculation']);
            $vehicule['marque'] = $vehicule['marque'] ? h($vehicule['marque']) : '';
            $vehicule['modele'] = $vehicule['modele'] ? h($vehicule['modele']) : '';
            $vehicule['annee'] = $vehicule['annee'] ? h((string)$vehicule['annee']) : '';
            if ($vehicule['client_nom'] && $vehicule['client_prenom']) {
                $vehicule['client_nom'] = h($vehicule['client_nom']);
                $vehicule['client_prenom'] = h($vehicule['client_prenom']);
            }
        }
        
        return $vehicule ? $vehicule : false;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Met à jour un véhicule
 * 
 * @param PDO $pdo Instance de connexion PDO
 * @param string $plaque_immatriculation Plaque d'immatriculation actuelle
 * @param string $new_plaque_immatriculation Nouvelle plaque d'immatriculation (peut être la même)
 * @param int $marque_id ID de la marque
 * @param int $modele_id ID du modèle
 * @param int $annee_id ID de l'année
 * @param int|null $client_id ID du client (optionnel)
 * @return bool True si la mise à jour a réussi, False sinon
 */
function update_vehicule($pdo, $plaque_immatriculation, $new_plaque_immatriculation, $marque_id, $modele_id, $annee_id, $client_id = null) {
    try {
        $sql = "UPDATE vehicule 
                SET plaque_immatriculation = :new_plaque, 
                    marque_id = :marque_id, 
                    modele_id = :modele_id, 
                    annee_id = :annee_id, 
                    client_id = :client_id
                WHERE plaque_immatriculation = :old_plaque";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':new_plaque', $new_plaque_immatriculation, PDO::PARAM_STR);
        $stmt->bindValue(':old_plaque', $plaque_immatriculation, PDO::PARAM_STR);
        $stmt->bindValue(':marque_id', $marque_id, PDO::PARAM_INT);
        $stmt->bindValue(':modele_id', $modele_id, PDO::PARAM_INT);
        $stmt->bindValue(':annee_id', $annee_id, PDO::PARAM_INT);
        $stmt->bindValue(':client_id', $client_id, $client_id ? PDO::PARAM_INT : PDO::PARAM_NULL);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

