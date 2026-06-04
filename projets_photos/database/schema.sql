USE projet1_tp2;

DROP TABLE IF EXISTS Vote;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Utilisateur;
DROP TABLE IF EXISTS Concours;

CREATE TABLE Concours (
    idConcours INT AUTO_INCREMENT PRIMARY KEY,
    annee INT NOT NULL,
    theme VARCHAR(255) NOT NULL,
    reglement TEXT,
    dateDebutDepot DATE,
    dateFinDepot DATE,
    dateDebutVote DATE,
    dateFinVote DATE,
    dateResultats DATE,
    prix1 INT,
    prix2 INT,
    prix3 INT
);

CREATE TABLE Utilisateur (
    idUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(255),
    login VARCHAR(100),
    role VARCHAR(50),
    bloque BOOLEAN DEFAULT 0
);

CREATE TABLE Photo (
    idPhoto INT AUTO_INCREMENT PRIMARY KEY,
    idUtilisateur INT NOT NULL,
    idConcours INT NOT NULL,
    titre VARCHAR(255),
    lieu VARCHAR(255),
    datePhoto DATE,
    cheminFichier VARCHAR(255),
    statut VARCHAR(50) DEFAULT 'en_attente',
    dateDepot DATETIME,

    FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
    FOREIGN KEY (idConcours) REFERENCES Concours(idConcours)
);

CREATE TABLE Vote (
    idVote INT AUTO_INCREMENT PRIMARY KEY,
    idUtilisateur INT NOT NULL,
    idPhoto INT NOT NULL,
    dateVote DATETIME,
    tour INT DEFAULT 1,

    FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
    FOREIGN KEY (idPhoto) REFERENCES Photo(idPhoto)
);
