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

-- Insertion de 25 véhicules
INSERT INTO vehicule (plaque_immatriculation, marque_id, modele_id, annee_id, client_id) VALUES
('AB-123-CD', 1, 1, 26, 1),   -- Renault Clio 2015 pour Jean Martin
('EF-456-GH', 2, 2, 29, 2),   -- Peugeot 308 2018 pour Marie Bernard
('IJ-789-KL', 4, 4, 31, NULL), -- BMW Série 3 2020 sans client
('MN-234-OP', 3, 3, 28, 3),   -- Citroën C3 2017 pour Pierre Dubois
('QR-567-ST', 5, 5, 30, 4),   -- Mercedes-Benz Classe C 2019 pour Sophie Thomas
('UV-890-WX', 6, 6, 27, 5),   -- Audi A3 2016 pour Michel Robert
('YZ-111-AA', 7, 7, 25, 6),   -- Volkswagen Golf 2014 pour Catherine Richard
('BB-222-CC', 8, 8, 24, 7),   -- Ford Focus 2013 pour Philippe Petit
('DD-333-EE', 9, 9, 23, 8),   -- Toyota Corolla 2012 pour Isabelle Durand
('FF-444-GG', 10, 10, 22, 9), -- Nissan Micra 2011 pour François Leroy
('HH-555-II', 1, 1, 21, 10),  -- Renault Clio 2010 pour Nathalie Moreau
('JJ-666-KK', 2, 2, 20, 1),   -- Peugeot 308 2009 pour Jean Martin
('LL-777-MM', 4, 4, 19, 2),   -- BMW Série 3 2008 pour Marie Bernard
('NN-888-OO', 5, 5, 18, 3),   -- Mercedes-Benz Classe C 2007 pour Pierre Dubois
('PP-999-QQ', 6, 6, 17, 4),   -- Audi A3 2006 pour Sophie Thomas
('RR-000-SS', 7, 7, 16, 5),   -- Volkswagen Golf 2005 pour Michel Robert
('TT-111-UU', 8, 8, 15, 6),   -- Ford Focus 2004 pour Catherine Richard
('VV-222-WW', 9, 9, 14, 7),   -- Toyota Corolla 2003 pour Philippe Petit
('XX-333-YY', 10, 10, 13, 8), -- Nissan Micra 2002 pour Isabelle Durand
('ZZ-444-AB', 1, 2, 12, 9),   -- Renault 308 2001 pour François Leroy
('CD-555-EF', 2, 3, 11, 10),  -- Peugeot C3 2000 pour Nathalie Moreau
('GH-666-IJ', 3, 4, 10, NULL), -- Citroën Série 3 1999 sans client
('KL-777-MN', 4, 5, 9, 1),    -- BMW Classe C 1998 pour Jean Martin
('OP-888-QR', 5, 6, 8, 2),    -- Mercedes-Benz A3 1997 pour Marie Bernard
('ST-999-UV', 6, 7, 7, 3);    -- Audi Golf 1996 pour Pierre Dubois
