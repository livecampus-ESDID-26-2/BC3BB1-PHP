-- Création de la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS garage_site_php;
USE garage_site_php;

-- Création de la table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(254) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    date_joined DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur de test (admin / admin123)
-- Le mot de passe est haché avec PASSWORD_DEFAULT (bcrypt)
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$12$SJ49xP1WlTkDv0z7zSDOLuErP2h5T9kk9V0hqfhj6vrbScrkv4qsi', 'admin@example.com');
