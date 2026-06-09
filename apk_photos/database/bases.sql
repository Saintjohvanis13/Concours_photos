-- Base de données simple du concours photo 2026
-- À importer dans MariaDB/MySQL après avoir sélectionné la base projet1_tp2.

DROP TABLE IF EXISTS vote2;
DROP TABLE IF EXISTS vote1;
DROP TABLE IF EXISTS configuration;
DROP TABLE IF EXISTS etudiant;

CREATE TABLE etudiant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    admin BOOLEAN NOT NULL DEFAULT FALSE,
    date DATETIME NOT NULL,
    description VARCHAR(200) NOT NULL DEFAULT ''
);

CREATE TABLE vote1 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATETIME NOT NULL,
    id_etu INT NOT NULL,
    id_photo INT NOT NULL,
    FOREIGN KEY (id_etu) REFERENCES etudiant(id)
);

CREATE TABLE vote2 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATETIME NOT NULL,
    id_etu INT NOT NULL,
    id_photo INT NOT NULL,
    FOREIGN KEY (id_etu) REFERENCES etudiant(id)
);

CREATE TABLE configuration (
    parametre VARCHAR(30) PRIMARY KEY,
    valeur DATE NOT NULL
);

CREATE TABLE photo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_fichier VARCHAR(255) NOT NULL,
    date_depot DATETIME NOT NULL,
    id_etu INT NOT NULL,
    FOREIGN KEY (id_etu) REFERENCES etudiant(id)
);

INSERT INTO configuration (parametre, valeur) VALUES
('depot_debut', '2026-09-07'),
('depot_fin', '2026-09-18'),


