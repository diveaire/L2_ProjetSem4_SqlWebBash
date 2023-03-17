INSERT INTO Metier VALUES ('Directeur');
INSERT INTO Metier VALUES ('Chargé de manège');
INSERT INTO Metier VALUES ('Vendeur');
INSERT INTO Metier VALUES ('Serveur');
INSERT INTO Metier VALUES ('Technicien');


INSERT INTO TypeObjet VALUES (1,'Friandise');
INSERT INTO TypeObjet VALUES (2,'Gadget');
INSERT INTO TypeObjet VALUES (3,'Peluche');
INSERT INTO TypeObjet VALUES (4,'Bijoux');
INSERT INTO TypeObjet VALUES (5,'Souvenir');
INSERT INTO TypeObjet VALUES (6,'Vetement');
INSERT INTO TypeObjet VALUES (7,'Jouet');


INSERT INTO Zone VALUES (1,'Aqualand');
INSERT INTO Zone VALUES (2,'Haute-Voltige');
INSERT INTO Zone VALUES (3,'Lumber-zone');


INSERT INTO Famille VALUES (1,'Carrousel');
INSERT INTO Famille VALUES (2,'Tour');
INSERT INTO Famille VALUES (3,'Chenille');
INSERT INTO Famille VALUES (4,'Grand-huit');
INSERT INTO Famille VALUES (5,'Train');
INSERT INTO Famille VALUES (6,'Auto-tamponeuse');
INSERT INTO Famille VALUES (7,'Roue');


INSERT INTO Manege VALUES ('Balade des hypocampes',125,'carrousel pour enfant immergé dans l eau',1,1);
INSERT INTO Manege VALUES ('Le moulin',0,'Petit carrousel',1,3);
INSERT INTO Manege VALUES ('L hirrondelle',145,'Chaises volante ascendante',2,2);
INSERT INTO Manege VALUES ('Mille-Patte',120,'Petit train pour enfant',3,3);
INSERT INTO Manege VALUES ('L envol des troglodytes',120,'Manège circulaire aérien pour enfant',3,2);
INSERT INTO Manege VALUES ('La danse des dauphins',155,'Attraction à sensation forte',4,1);
INSERT INTO Manege VALUES ('La racine',155,'Attraction à sensation forte',4,3);
INSERT INTO Manege VALUES ('La chute d Icare',155,'Attraction à sensation forte',4,2);
INSERT INTO Manege VALUES ('Wave',150,'Descente à haute vitesse, avec chute d eau et cascade',5,1);
INSERT INTO Manege VALUES ('Buffalo',150,'Auto-tamponeuse en forme de buffle',6,3);
INSERT INTO Manege VALUES ('L oeil',0,'Tour de grande roue',7,2);


INSERT INTO Atelier VALUES (1,'La base sous marine',1);
INSERT INTO Atelier VALUES (2,'La forge des airs',2);
INSERT INTO Atelier VALUES (3,'L établi',3);
INSERT INTO Atelier VALUES (4,'Entrepôt',3);


INSERT INTO Maintenance VALUES (1,TO_DATE('25/05/2023','dd/mm/yyyy'),TO_DATE('30/05/2023','dd/mm/yyyy'),'Le moulin');
INSERT INTO Maintenance VALUES (2,TO_DATE('25/05/2023','dd/mm/yyyy'),TO_DATE('25/05/2023','dd/mm/yyyy'),'La racine');


INSERT INTO Boutique VALUES (1,'Macdo','restaurant',3);
INSERT INTO Boutique VALUES (2,'BK','restaurant',2);
INSERT INTO Boutique VALUES (3,'KFC','restaurant',1);
INSERT INTO Boutique VALUES (4,'Le sculpteur Joe','souvenir',3);
INSERT INTO Boutique VALUES (5,'Le nuage de l amour','souvenir',2);
INSERT INTO Boutique VALUES (6,'Au coeur de l épave','souvenir',1);


INSERT INTO Objet VALUES (1,'Bague',4,4,null,35);
INSERT INTO Objet VALUES (2,'Porte_clef',4,5,null,5);
INSERT INTO Objet VALUES (3,'Cheval en bois',4,7,null,50);
INSERT INTO Objet VALUES (4,'Clef USB',4,2,null,16);
INSERT INTO Objet VALUES (5,'Chouchou',5,1,null,5);
INSERT INTO Objet VALUES (6,'Pomme d amour',5,1,null,3);
INSERT INTO Objet VALUES (7,'Nounours',5,3,null,50);
INSERT INTO Objet VALUES (8,'Pistolet à eau',6,7,null,25);
INSERT INTO Objet VALUES (9,'Dauphin',6,3,null,35);
INSERT INTO Objet VALUES (10,'T-shirt Wave',6,6,null,23);
INSERT INTO Objet VALUES (11,'Orque',6,3,null,35);
INSERT INTO Objet VALUES (12,'Phoque 30 cm',6,3,TO_DATE('22/03/2023','dd/mm/yyyy'),26);
INSERT INTO Objet VALUES (13,'Débardeur Joe',4,6,TO_DATE('12/04/2023','dd/mm/yyyy'),23);
INSERT INTO Objet VALUES (14,'Boite de chocolat',5,1,TO_DATE('15/02/2023','dd/mm/yyyy'),8);


INSERT INTO PiecesDetachees VALUES (14189639,'Roue',4,1);
INSERT INTO PiecesDetachees VALUES (61231584,'Moteur',1,2);
INSERT INTO PiecesDetachees VALUES (34578422,'siège',4,null);
INSERT INTO PiecesDetachees VALUES (54236789,'Engrenage',4,null);
INSERT INTO PiecesDetachees VALUES (72435685,'wagon',2,null);
INSERT INTO PiecesDetachees VALUES (19626463,'auto',3,null);
INSERT INTO PiecesDetachees VALUES (52910329,'Moteur',4,null);
INSERT INTO PiecesDetachees VALUES (91025273,'chaise',2,null);
INSERT INTO PiecesDetachees VALUES (79193025,'Roue',1,null);
INSERT INTO PiecesDetachees VALUES (16718152,'Moteur',3,null);
INSERT INTO PiecesDetachees VALUES (87654327,'wagon',4,null);


INSERT INTO Personnel VALUES (393874739983721,'Jack','Laproie',TO_DATE('04/12/1959','dd/mm/yyyy'),standard_hash('Monpass0','MD5'),'Directeur',null,null,0,null,0);
INSERT INTO Personnel VALUES (269019550295812,'Ansel','Narcisse',TO_DATE('03/01/1969','dd/mm/yyyy'),standard_hash('Monpass1','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (184010670392524,'Guay','Christien',TO_DATE('16/01/1984','dd/mm/yyyy'),standard_hash('Monpass3','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (273129489402427,'Fontaine','Charlotte',TO_DATE('05/12/1973','dd/mm/yyyy'),standard_hash('Monpass2','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (160120623950185,'Harbin','Langlois',TO_DATE('30/12/1960','dd/mm/yyyy'),standard_hash('Monpass5','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (259057174363269,'Galarneau','Diane',TO_DATE('08/05/1959','dd/mm/yyyy'),standard_hash('Monpass4','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (177094416301428,'Beaulieu','Felicien',TO_DATE('23/09/1977','dd/mm/yyyy'),standard_hash('Monpass6','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (192080610253029,'Tanguay','Felix',TO_DATE('22/08/1992','dd/mm/yyyy'),standard_hash('Monpass7','MD5'),'Chargé de manège',null,null,0,null,0);
INSERT INTO Personnel VALUES (262017839201528,'Plouffe','Élodie',TO_DATE('03/06/1962','dd/mm/yyyy'),standard_hash('Monpass12','MD5'),'Vendeur',null,null,0,4,1);
INSERT INTO Personnel VALUES (170055426428642,'Lotye','Alexandre',TO_DATE('29/05/1970','dd/mm/yyyy'),standard_hash('Monpass13','MD5'),'Vendeur',null,null,0,4,0);
INSERT INTO Personnel VALUES (186119185783610,'Roch','Bernard',TO_DATE('21/11/1986','dd/mm/yyyy'),standard_hash('Monpass14','MD5'),'Vendeur',null,null,0,5,1);
INSERT INTO Personnel VALUES (285041689753759,'Breton','Fayme',TO_DATE('15/05/1985','dd/mm/yyyy'),standard_hash('Monpass15','MD5'),'Vendeur',null,null,0,5,0);
INSERT INTO Personnel VALUES (269054528453129,'Allard','Dominique',TO_DATE('17/05/1969','dd/mm/yyyy'),standard_hash('Monpass16','MD5'),'Vendeur',null,null,0,6,1);
INSERT INTO Personnel VALUES (199027268902305,'Lejeune','Daniel',TO_DATE('06/02/1999','dd/mm/yyyy'),standard_hash('Monpass8','MD5'),'Serveur',null,null,1,1,1);
INSERT INTO Personnel VALUES (280061676520542,'Meilleur','Valérie',TO_DATE('13/06/1980','dd/mm/yyyy'),standard_hash('Monpass9','MD5'),'Serveur',null,null,0,1,0);
INSERT INTO Personnel VALUES (192121367804307,'Mousseau','Geoffrey',TO_DATE('01/12/1992','dd/mm/yyyy'),standard_hash('Monpass10','MD5'),'Serveur',null,null,0,2,1);
INSERT INTO Personnel VALUES (159119710789325,'Labonté','Robert',TO_DATE('14/11/1959','dd/mm/yyyy'),standard_hash('Monpass11','MD5'),'Serveur',null,null,0,3,1);
INSERT INTO Personnel VALUES (189027865394675,'Jolicoeur','joel',TO_DATE('27/02/1989','dd/mm/yyyy'),standard_hash('Monpass17','MD5'),'Technicien',null,1,1,null,0);
INSERT INTO Personnel VALUES (188109516634135,'Landers','Roger',TO_DATE('14/10/1988','dd/mm/yyyy'),standard_hash('Monpass18','MD5'),'Technicien',null,2,1,null,0);
INSERT INTO Personnel VALUES (285062730491825,'Méthoir','Carole',TO_DATE('27/06/1985','dd/mm/yyyy'),standard_hash('Monpass19','MD5'),'Technicien',null,3,1,null,0);
INSERT INTO Personnel VALUES (183125910395284,'Lagrange','Arnaud',TO_DATE('05/12/1983','dd/mm/yyyy'),standard_hash('Monpass20','MD5'),'Technicien',null,4,1,null,0);


INSERT INTO Competences VALUES (269019550295812,1);
INSERT INTO Competences VALUES (269019550295812,3);
INSERT INTO Competences VALUES (273129489402427,2);
INSERT INTO Competences VALUES (273129489402427,4);
INSERT INTO Competences VALUES (273129489402427,5);
INSERT INTO Competences VALUES (184010670392524,6);
INSERT INTO Competences VALUES (184010670392524,7);
INSERT INTO Competences VALUES (184010670392524,3);
INSERT INTO Competences VALUES (160120623950185,1);
INSERT INTO Competences VALUES (160120623950185,4);
INSERT INTO Competences VALUES (160120623950185,5);
INSERT INTO Competences VALUES (160120623950185,7);
INSERT INTO Competences VALUES (259057174363269,4);
INSERT INTO Competences VALUES (259057174363269,5);
INSERT INTO Competences VALUES (177094416301428,6);
INSERT INTO Competences VALUES (177094416301428,7);
INSERT INTO Competences VALUES (192080610253029,1);
INSERT INTO Competences VALUES (192080610253029,2);
INSERT INTO Competences VALUES (192080610253029,3);
INSERT INTO Competences VALUES (192080610253029,4);
INSERT INTO Competences VALUES (262017839201528,4);
INSERT INTO Competences VALUES (170055426428642,3);
INSERT INTO Competences VALUES (170055426428642,1);
INSERT INTO Competences VALUES (186119185783610,1);


INSERT INTO Equipe VALUES (199027268902305,1);
INSERT INTO Equipe VALUES (199027268902305,2);
INSERT INTO Equipe VALUES (280061676520542,1);
INSERT INTO Equipe VALUES (192121367804307,2);
INSERT INTO Equipe VALUES (159119710789325,2);


INSERT INTO Bilan VALUES ('Wave',269019550295812,TO_DATE('14/03/2023','dd/mm/yyyy'),564,'AM');
INSERT INTO Bilan VALUES ('Wave',259057174363269,TO_DATE('14/03/2023','dd/mm/yyyy'),612,'PM');
INSERT INTO Bilan VALUES ('La danse des dauphins',259057174363269,TO_DATE('14/03/2023','dd/mm/yyyy'),478,'AM');
INSERT INTO Bilan VALUES ('La danse des dauphins',273129489402427,TO_DATE('14/03/2023','dd/mm/yyyy'),514,'PM');
INSERT INTO Bilan VALUES ('Buffalo',177094416301428,TO_DATE('14/03/2023','dd/mm/yyyy'),264,'AM');
INSERT INTO Bilan VALUES ('Buffalo',184010670392524,TO_DATE('14/03/2023','dd/mm/yyyy'),352,'PM');
INSERT INTO Bilan VALUES ('Mille-Patte',184010670392524,TO_DATE('14/03/2023','dd/mm/yyyy'),421,'AM');
INSERT INTO Bilan VALUES ('Mille-Patte',269019550295812,TO_DATE('14/03/2023','dd/mm/yyyy'),354,'PM');
INSERT INTO Bilan VALUES ('La racine',262017839201528,TO_DATE('14/03/2023','dd/mm/yyyy'),512,'AM');
INSERT INTO Bilan VALUES ('La racine',259057174363269,TO_DATE('14/03/2023','dd/mm/yyyy'),580,'PM');
INSERT INTO Bilan VALUES ('L oeil',160120623950185,TO_DATE('14/03/2023','dd/mm/yyyy'),315,'AM');
INSERT INTO Bilan VALUES ('L oeil',177094416301428,TO_DATE('14/03/2023','dd/mm/yyyy'),315,'PM');
INSERT INTO Bilan VALUES ('L envol des troglodytes',170055426428642,TO_DATE('14/03/2023','dd/mm/yyyy'),230,'AM');
INSERT INTO Bilan VALUES ('L envol des troglodytes',170055426428642,TO_DATE('14/03/2023','dd/mm/yyyy'),299,'PM');
INSERT INTO Bilan VALUES ('La chute d Icare',192080610253029,TO_DATE('14/03/2023','dd/mm/yyyy'),480,'AM');
INSERT INTO Bilan VALUES ('La chute d Icare',160120623950185,TO_DATE('14/03/2023','dd/mm/yyyy'),512,'PM');
INSERT INTO Bilan VALUES ('L hirrondelle',273129489402427,TO_DATE('14/03/2023','dd/mm/yyyy'),360,'AM');
INSERT INTO Bilan VALUES ('L hirrondelle',192080610253029,TO_DATE('14/03/2023','dd/mm/yyyy'),452,'PM');
INSERT INTO Bilan VALUES ('Balade des hypocampes',186119185783610,TO_DATE('14/03/2023','dd/mm/yyyy'),350,'AM');
INSERT INTO Bilan VALUES ('Balade des hypocampes',186119185783610,TO_DATE('14/03/2023','dd/mm/yyyy'),280,'PM');