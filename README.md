# Guide de Déploiement - Garage Auto (PHP Version)

Ce projet est une version PHP native (sans framework MVC) de l'application Garage Auto.

## Prérequis

### Avec Docker (Recommandé)

- **Docker** : Version 20.10 ou supérieure
- **Docker Compose** : Version 2.0 ou supérieure

### Sans Docker (Installation Manuelle)

Pour faire tourner ce projet sans Docker, vous avez besoin d'un environnement AMP (Apache/Nginx, MySQL, PHP) standard :

- **PHP** : Version 8.0 ou supérieure.
  - Extensions requises : `pdo`, `pdo_mysql`.
- **Base de données** : MySQL 5.7+ ou MariaDB.
- **Serveur Web** : Apache (avec `mod_rewrite` activé si nécessaire) ou Nginx.

## Installation avec Docker

### 1. Prérequis : Créer le fichier .env

Avant de lancer Docker, assurez-vous d'avoir un fichier `.env` à la racine du projet avec les variables suivantes :

```env
DB_HOST=db
DB_NAME=garage_site_php
DB_USER=root
DB_PASSWORD=rootpassword
```

**Important** : Le fichier `.env` est obligatoire pour que l'application fonctionne.

### 2. Lancement des conteneurs Docker

Depuis le répertoire racine du projet, exécutez :

```bash
docker compose up -d --build
```

Cette commande va :

- Construire l'image PHP/Apache avec toutes les extensions nécessaires
- Démarrer le conteneur MySQL
- Exécuter automatiquement le script `database.sql` pour initialiser la base de données
- Démarrer le serveur web

**Options de la commande :**

- `-d` : Lance les conteneurs en arrière-plan (mode détaché)
- `--build` : Reconstruit les images avant de démarrer (utile la première fois ou après modification du Dockerfile)

**Alternative :** Si vous voulez voir les logs en temps réel :

```bash
docker compose up --build
```

(Pour arrêter, utilisez `Ctrl+C` puis `docker compose down`)

### 3. Accès à l'application

Une fois les conteneurs démarrés, accédez à l'application via :

- **URL** : `http://localhost:8080`

### 3.1. Hot-reload automatique

Les modifications de code sont automatiquement reflétées dans le conteneur Docker grâce au volume monté. Vous n'avez **pas besoin de reconstruire l'image** ou de redémarrer les conteneurs lorsque vous modifiez :

- Les fichiers PHP (`.php`)
- Les fichiers CSS (`.css`)
- Les fichiers JavaScript (`.js`)
- Les fichiers HTML
- Tout autre fichier du projet

**Note** : PHP lit les fichiers à chaque requête, donc les changements sont immédiatement visibles après un simple rafraîchissement de la page dans votre navigateur.

### 4. Commandes Docker utiles

#### Vérifier l'état des conteneurs

```bash
docker compose ps
```

#### Voir les logs

```bash
# Logs de tous les services
docker compose logs

# Logs du service web uniquement
docker compose logs web

# Logs en temps réel (suivre les logs)
docker compose logs -f
```

#### Redémarrer les conteneurs

```bash
# Redémarrer tous les services
docker compose restart

# Redémarrer un service spécifique
docker compose restart web
```

#### Arrêter les conteneurs

```bash
# Arrêter les conteneurs (sans les supprimer)
docker compose stop

# Arrêter et supprimer les conteneurs
docker compose down

# Arrêter et supprimer les conteneurs + volumes (supprime les données de la base)
docker compose down -v
```

#### Reconstruire après modification du Dockerfile

```bash
docker compose up -d --build
```

#### Accéder au shell du conteneur web

```bash
docker compose exec web bash
```

#### Accéder à MySQL

```bash
docker compose exec db mysql -u root -p
```

(Le mot de passe est celui défini dans votre fichier `.env` pour `DB_PASSWORD`)

### 4. Configuration Docker

#### Fichier .env

Créez un fichier `.env` à la racine du projet avec les variables suivantes :

```env
DB_HOST=db
DB_NAME=garage_site_php
DB_USER=root
DB_PASSWORD=rootpassword
```

**Note** : Le fichier `.env` est automatiquement chargé par `docker-compose.yml` et par `config.php`.

#### Variables d'environnement

- `DB_HOST` : Nom du service MySQL (par défaut : `db`)
- `DB_NAME` : Nom de la base de données (par défaut : `garage_site_php`)
- `DB_USER` : Utilisateur MySQL (par défaut : `root`)
- `DB_PASSWORD` : Mot de passe MySQL (par défaut : `rootpassword`)

Le script `database.sql` est automatiquement exécuté lors du premier démarrage du conteneur MySQL grâce au volume monté dans `/docker-entrypoint-initdb.d/`.

#### Port MySQL

Le port MySQL est mappé sur le port **3307** de votre machine (au lieu de 3306) pour éviter les conflits avec une instance MySQL locale qui pourrait déjà tourner.

- **Depuis l'application PHP** : Utilisez `DB_HOST=db` (nom du service, pas besoin du port)
- **Depuis l'extérieur du conteneur** (outils comme MySQL Workbench, phpMyAdmin, etc.) : Connectez-vous à `localhost:3307`

**Note** : Si vous avez une erreur "Port 3306 already in use", c'est normal. Le port a été changé pour 3307 pour éviter ce conflit.

## Installation Manuelle

### 1. Installation des fichiers

Copiez l'ensemble des fichiers du dossier `BC3BB1-PHP` dans le répertoire racine de votre serveur web :

- **XAMPP/WAMP** : `C:\xampp\htdocs\` ou `C:\wamp64\www\`
- **MAMP (Mac)** : `/Applications/MAMP/htdocs/`
- **Linux (Apache)** : `/var/www/html/`

### 2. Configuration de la Base de Données

1.  Ouvrez votre gestionnaire de base de données (phpMyAdmin, MySQL Workbench, ou ligne de commande).
2.  Exécutez le script SQL `database.sql` fourni à la racine du projet.
    - Ce script crée la base de données `garage_site_php`.
    - Il crée la table `users`.
    - Il insère un utilisateur administrateur par défaut.

### 3. Configuration de la Connexion

#### Option 1 : Utiliser un fichier .env (Recommandé)

Créez un fichier `.env` à la racine du projet :

```env
DB_HOST=127.0.0.1
DB_NAME=garage_site_php
DB_USER=root
DB_PASSWORD=votre_mot_de_passe
```

Le fichier `config.php` chargera automatiquement ces variables depuis le fichier `.env`.

#### Option 2 : Modifier config.php directement

Le fichier `config.php` gère la connexion à la base de données. Il est configuré pour fonctionner avec des variables d'environnement (depuis `.env` ou Docker) OU avec des valeurs par défaut.

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

- Exemple : `http://localhost/BC3BB1-PHP/`

## Identifiants par défaut

Une fois installé, vous pouvez vous connecter avec :

- **Utilisateur** : `admin`
- **Mot de passe** : `admin123`
