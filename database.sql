-- Création de la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS garage_site_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE garage_site_php;

-- Création de la table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(254) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    date_joined DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Création de la table client
CREATE TABLE IF NOT EXISTS client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Création de la table marque_vehicule
CREATE TABLE IF NOT EXISTS marque_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Création de la table modele_vehicule
CREATE TABLE IF NOT EXISTS modele_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Création de la table annee_vehicule
CREATE TABLE IF NOT EXISTS annee_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    annee INT NOT NULL UNIQUE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Création de la table vehicule
CREATE TABLE IF NOT EXISTS vehicule (
    plaque_immatriculation VARCHAR(20) PRIMARY KEY,
    marque_id INT NOT NULL,
    modele_id INT NOT NULL,
    annee_id INT NOT NULL,
    client_id INT,
    FOREIGN KEY (marque_id) REFERENCES marque_vehicule(id) ON DELETE CASCADE,
    FOREIGN KEY (modele_id) REFERENCES modele_vehicule(id) ON DELETE CASCADE,
    FOREIGN KEY (annee_id) REFERENCES annee_vehicule(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE SET NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insertion d'un utilisateur de test (admin / admin123)
-- Le mot de passe est haché avec PASSWORD_DEFAULT (bcrypt)
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$12$SJ49xP1WlTkDv0z7zSDOLuErP2h5T9kk9V0hqfhj6vrbScrkv4qsi', 'admin@example.com');


-- Insertion de 10 clients
INSERT INTO client (nom, prenom) VALUES
('Martin', 'Jean'),
('Bernard', 'Marie'),
('Dubois', 'Pierre'),
('Thomas', 'Sophie'),
('Robert', 'Michel'),
('Richard', 'Catherine'),
('Petit', 'Philippe'),
('Durand', 'Isabelle'),
('Leroy', 'François'),
('Moreau', 'Nathalie');

-- Insertion de 10 marques de véhicules
INSERT INTO marque_vehicule (nom) VALUES
('Renault'),
('Peugeot'),
('Citroën'),
('BMW'),
('Mercedes-Benz'),
('Audi'),
('Volkswagen'),
('Ford'),
('Toyota'),
('Nissan');

-- Insertion de 10 modèles de véhicules
INSERT INTO modele_vehicule (nom) VALUES
('Clio'),
('308'),
('C3'),
('Série 3'),
('Classe C'),
('A3'),
('Golf'),
('Focus'),
('Corolla'),
('Micra');

-- Insertion des années de 1990 à 2020
INSERT INTO annee_vehicule (annee) VALUES
(1990), (1991), (1992), (1993), (1994), (1995), (1996), (1997), (1998), (1999),
(2000), (2001), (2002), (2003), (2004), (2005), (2006), (2007), (2008), (2009),
(2010), (2011), (2012), (2013), (2014), (2015), (2016), (2017), (2018), (2019),
(2020);

-- Insertion de 3 véhicules
INSERT INTO vehicule (plaque_immatriculation, marque_id, modele_id, annee_id, client_id) VALUES
('AB-123-CD', 1, 1, 26, 1),  -- Renault Clio 2015 pour Jean Martin
('EF-456-GH', 2, 2, 29, 2),  -- Peugeot 308 2018 pour Marie Bernard
('IJ-789-KL', 4, 4, 31, NULL);  -- BMW Série 3 2020 sans client
