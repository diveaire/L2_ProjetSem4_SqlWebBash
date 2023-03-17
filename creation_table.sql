CREATE TABLE Metier (
   Metier VARCHAR(32),
   CONSTRAINT pk_Metier PRIMARY KEY (Metier)
);

CREATE TABLE TypeObjet (
   IdT INT,
   libelleT VARCHAR(32),
   CONSTRAINT pk_TypeObjet PRIMARY KEY(IdT)
);

CREATE TABLE Zone (
   IdZ INT,
   nomZ VARCHAR(32),
   CONSTRAINT pk_Zone PRIMARY KEY(IdZ)
);

CREATE TABLE Famille (
   IdF INT,
   libelleF VARCHAR(32),
   CONSTRAINT pk_Famille PRIMARY KEY(IdF)
);

CREATE TABLE Manege (
   NomM VARCHAR(32),
   tailleMin INT,
   description VARCHAR(400),
   IdF INT,
   IdZ INT,
   CONSTRAINT fk_Manege_Famille FOREIGN KEY (IdF) REFERENCES Famille(IdF),
   CONSTRAINT fk_Manege_Zone FOREIGN KEY (IdZ) REFERENCES Zone(IdZ),
   CONSTRAINT pk_Manege PRIMARY KEY(NomM)
);

CREATE TABLE Atelier (
   IdA INT,
   nomA VARCHAR(32),
   IdZ INT,
   CONSTRAINT fk_Atelier_Zone FOREIGN KEY (IdZ) REFERENCES Zone(IdZ),
   CONSTRAINT pk_Atelier PRIMARY KEY (IdA)
);

CREATE TABLE Maintenance (
   IdM INT,
   DateDeb DATE,
   DateFin DATE,
   NomM VARCHAR(32),
   CONSTRAINT fk_Maintenance_Manege FOREIGN KEY (NomM) REFERENCES Manege(NomM),
   CONSTRAINT pk_Maintenance PRIMARY KEY (IdM)
);

CREATE TABLE Boutique (
   IdB INT,
   nomB VARCHAR(32),
   typeB VARCHAR(32),
   IdZ INT,
   CONSTRAINT fk_Boutique_Zone FOREIGN KEY (IdZ) REFERENCES Zone(IdZ),
   CONSTRAINT pk_Boutique PRIMARY KEY(IdB)
);

CREATE TABLE Objet (
   IdO INT,
   nomO VARCHAR(32),
   IdB INT,
   IdT INT,
   DateVente DATE,
   Prix NUMERIC(4,2) DEFAULT 0.00,
   CONSTRAINT fk_Objet_Boutique FOREIGN KEY (IdB) REFERENCES Boutique(IdB),
   CONSTRAINT fk_Objet_TypeObjet FOREIGN KEY (IdT) REFERENCES TypeObjet(IdT),
   CONSTRAINT pk_Objet PRIMARY KEY(IdO)
);

CREATE TABLE PiecesDetachees (
   NumSerie NUMERIC(8),
   nomPC VARCHAR(32),
   IdA INT,
   IdM INT,
   CONSTRAINT fk_PieceDetachees_Atelier FOREIGN KEY (IdA) REFERENCES Atelier(IdA),
   CONSTRAINT fk_PieceDetachees_Manege FOREIGN KEY (IdM) REFERENCES Maintenance(IdM),
   CONSTRAINT pk_PieceDetachees PRIMARY KEY (NumSerie)
);

CREATE TABLE Personnel (
   NumSS NUMERIC(15),
   nomP VARCHAR(32),
   prenomP VARCHAR(32),
   date_naissance DATE,
   passwd VARCHAR(32),
   Metier VARCHAR(32),
   remplace NUMERIC(15),
   IdA INT,
   chef NUMERIC(1),
   IdB INT,
   responsable NUMERIC(1),
   CONSTRAINT fk_Personnel_Atelier FOREIGN KEY (IdA) REFERENCES Atelier(IdA),
   CONSTRAINT fk_Personnel_Boutique FOREIGN KEY (IdB) REFERENCES Boutique(IdB),
   CONSTRAINT fk_Personnel_Metier FOREIGN KEY (Metier) REFERENCES Metier(Metier),
   CONSTRAINT fk_Personnel_Personnel FOREIGN KEY (remplace) REFERENCES Personnel(NumSS),
   CONSTRAINT pk_Personnel PRIMARY KEY (NumSS)
);

CREATE TABLE Competences (
   NumSS NUMERIC(15),
   IdF INT,
   CONSTRAINT fk_Competences_Personnel FOREIGN KEY (NumSS) REFERENCES Personnel(NumSS),
   CONSTRAINT fk_Competences_Famille FOREIGN KEY (IdF) REFERENCES Famille(IdF),
   CONSTRAINT pk_Competences PRIMARY KEY (NumSS,IdF)
);

CREATE TABLE Bilan (
   NomM VARCHAR(32),
   NumSS NUMERIC(15),
   DateB DATE,
   frequentation INT,
   demi_journee VARCHAR(2),
   CONSTRAINT fk_Bilan_Personnel FOREIGN KEY (NumSS) REFERENCES Personnel(NumSS),
   CONSTRAINT pk_Bilan PRIMARY KEY (NomM,NumSS,DateB,demi_journee)
);

CREATE TABLE Equipe (
   NumSS NUMERIC(15),
   IdM INT,
   CONSTRAINT fk_Equipe_Personnel FOREIGN KEY (NumSS) REFERENCES Personnel(NumSS),
   CONSTRAINT fk_Equipe_Manege FOREIGN KEY (IdM) REFERENCES Maintenance(IdM),
   CONSTRAINT pk_Equipe PRIMARY KEY (NumSS,IdM)
);