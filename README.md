# Guide de Déploiement - Garage Auto (PHP Version)

Ce projet est une version PHP native (sans framework MVC) de l'application Garage Auto.

## Prérequis

Pour faire tourner ce projet sans Docker, vous avez besoin d'un environnement AMP (Apache/Nginx, MySQL, PHP) standard :

*   **PHP** : Version 8.0 ou supérieure.
    *   Extensions requises : `pdo`, `pdo_mysql`.
*   **Base de données** : MySQL 5.7+ ou MariaDB.
*   **Serveur Web** : Apache (avec `mod_rewrite` activé si nécessaire) ou Nginx.

## Installation Manuelle

### 1. Installation des fichiers
Copiez l'ensemble des fichiers du dossier `BC3BB1-PHP` dans le répertoire racine de votre serveur web :
*   **XAMPP/WAMP** : `C:\xampp\htdocs\` ou `C:\wamp64\www\`
*   **MAMP (Mac)** : `/Applications/MAMP/htdocs/`
*   **Linux (Apache)** : `/var/www/html/`

### 2. Configuration de la Base de Données
1.  Ouvrez votre gestionnaire de base de données (phpMyAdmin, MySQL Workbench, ou ligne de commande).
2.  Exécutez le script SQL `database.sql` fourni à la racine du projet.
    *   Ce script crée la base de données `garage_site_php`.
    *   Il crée la table `users`.
    *   Il insère un utilisateur administrateur par défaut.

### 3. Configuration de la Connexion (`config.php`)
Le fichier `config.php` gère la connexion à la base de données. Il est configuré pour fonctionner avec des variables d'environnement (pour Docker) OU avec des valeurs par défaut.

Ouvrez `config.php` et modifiez les valeurs par défaut dans les lignes suivantes pour qu'elles correspondent à votre serveur local :

```php
// Modifiez les valeurs après le '?:'
$db_host = getenv('DB_HOST') ?: '127.0.0.1';      // Votre hôte (souvent localhost)
$db_name = getenv('DB_NAME') ?: 'garage_site_php'; // Nom de la base (défini dans database.sql)
$db_user = getenv('DB_USER') ?: 'root';            // Votre utilisateur MySQL
$db_pass = getenv('DB_PASSWORD') ?: '';            // Votre mot de passe MySQL
```

### 4. Lancement
Accédez simplement à l'URL de votre projet dans votre navigateur.
*   Exemple : `http://localhost/BC3BB1-PHP/`

## Identifiants par défaut

Une fois installé, vous pouvez vous connecter avec :
*   **Utilisateur** : `admin`
*   **Mot de passe** : `admin123`