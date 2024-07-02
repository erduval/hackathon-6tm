CREATE DATABASE cooptation_db;
USE cooptation_db;

CREATE TABLE Utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    motDePasse VARCHAR(255) NOT NULL
);

CREATE TABLE RH (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Coopteur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    points INT DEFAULT 0,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Notification (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT NOT NULL,
    dateDebut DATE,
    dateFin DATE,
    rh_id INT,
    FOREIGN KEY (rh_id) REFERENCES RH(id)
);

CREATE TABLE OffreEmploi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    datePublication DATE NOT NULL,
    notification_id INT,
    FOREIGN KEY (notification_id) REFERENCES Notification(id)
);

CREATE TABLE Cooptation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dateCooptation DATE NOT NULL,
    statut VARCHAR(255) NOT NULL,
    coopteur_id INT,
    FOREIGN KEY (coopteur_id) REFERENCES Coopteur(id)
);

CREATE TABLE Equipe (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE Classement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    position INT NOT NULL,
    nomEquipe VARCHAR(255) NOT NULL,
    points INT DEFAULT 0,
    equipe_id INT,
    FOREIGN KEY (equipe_id) REFERENCES Equipe(id)
);

CREATE TABLE Equipe_Utilisateur (
    equipe_id INT,
    utilisateur_id INT,
    PRIMARY KEY (equipe_id, utilisateur_id),
    FOREIGN KEY (equipe_id) REFERENCES Equipe(id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Cooptation_OffreEmploi (
    cooptation_id INT,
    offreEmploi_id INT,
    PRIMARY KEY (cooptation_id, offreEmploi_id),
    FOREIGN KEY (cooptation_id) REFERENCES Cooptation(id),
    FOREIGN KEY (offreEmploi_id) REFERENCES OffreEmploi(id)
);

CREATE TABLE Candidature (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cv LONGBLOB NOT NULL,
    lien VARCHAR(255),
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    coopteur_id INT,
    offreEmploi_id INT,
    FOREIGN KEY (coopteur_id) REFERENCES Coopteur(id),
    FOREIGN KEY (offreEmploi_id) REFERENCES OffreEmploi(id)
);


