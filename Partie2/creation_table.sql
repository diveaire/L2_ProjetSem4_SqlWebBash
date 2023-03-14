CREATE TABLE Metier (
   Metier PRIMARY KEY
);

CREATE TABLE TypeObjet (
   IdT INT,
   libelleT VARCHAR(32),
   PRIMARY KEY(IdT)
);

CREATE TABLE Zone (
   IdZ INT PRIMARY KEY,
   nomZ VARCHAR(32)
);

CREATE TABLE Famille (
   IdF INT PRIMARY KEY,
   libelleF VARCHAR(32)
);

CREATE TABLE Manege (
   NomM VARCHAR(32) PRIMARY KEY,
   tailleMin INT,
   description VARCHAR(400),
   IdF INT,
   IdZ INT,
   FOREIGN KEY (IdF) REFERENCES Famille(IdF)
   FOREIGN KEY (IdZ) REFERENCES Zone(IdZ)
);

CREATE TABLE Atelier (
   IdA INT PRIMARY KEY,
   nomA VARCHAR(32),
   IdZ INT,
   FOREIGN KEY (IdZ) REFERENCES Zone(IdZ)
);

CREATE TABLE Maintenance (
   IdM INT PRIMARY KEY,
   DateDebutM DATE,
   DateFinM DATE,
   NomM VARCHAR(32),
   FOREIGN KEY (NomM) REFERENCES Manege(NomM)
);

CREATE TABLE Boutique (
   IdB INT,
   nomB VARCHAR(32),
   typeB VARCHAR(32),
   IdZ INT,
   FOREIGN KEY (IdZ) REFERENCES Zone(IdZ),
   PRIMARY KEY(IdB)
);

CREATE TABLE Objet (
   IdO INT,
   nomO VARCHAR(32),
   IdB INT,
   IdT INT,
   DateVente DATE,
   Prix NUMERIC(4,2) DEFAULT 0.00,
   FOREIGN KEY (IdB) REFERENCES Boutique(IdB),
   FOREIGN KEY (IdT) REFERENCES TypeObjet(IdT),
   PRIMARY KEY(IdO)
);

CREATE TABLE PiecesDetachees (
   NumSerie NUMBER(8) PRIMARY KEY
   nomPC VARCHAR(32),
   IdA INT,
   IdM INT,
   FOREIGN KEY (IdA) REFERENCES Atelier(IdA),
   FOREIGN KEY (IdM) REFERENCES Manege(IdM)
);

CREATE TABLE Personnel (
   NumSS NUMBER(15) PRIMARY KEY,
   nomP VARCHAR(32),
   prenomP VARCHAR(32),
   date_naissance DATE,
   passwd VARCHAR(32),
   Metier VARCHAR(32),
   remplace NUMBER(15),
   IdA INT,
   chef NUMBER(1),
   IdB INT,
   responsable NUMBER(1),
   FOREIGN KEY (Metier) REFERENCES Metier(Metier),
   FOREIGN KEY (remplace) REFERENCES Personnel(NumSS)
);

CREATE TABLE Competences (
   NumSS NUMBER(15),
   IdF INT,
   PRIMARY KEY (NumSS,IdF),
   FOREIGN KEY (NumSS) REFERENCES Personne(NumSS),
   FOREIGN KEY (IdF) REFERENCES Famille(IdF)
);

CREATE TABLE Bilan (
   NomM VARCHAR(32),
   NumSS NUMBER(15),
   DateB DATE,
   frequentation INT,
   demi_journee VARCHAR(2),
   PRIMARY KEY (NomM,NumSS,Date),
   FOREIGN KEY (NumSS) REFERENCES Personnel(NumSS)
);

CREATE TABLE Equipe (
   NumSS NUMBER(15),
   IdM INT,
   PRIMARY KEY (NumSS,IdM),
   FOREIGN KEY (NumSS) REFERENCES Personnel(NumSS),
   FOREIGN KEY (IdM) REFERENCES Manege(IdM)
);

