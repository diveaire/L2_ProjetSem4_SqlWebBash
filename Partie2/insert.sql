INSERT INTO Metier VALUES ("Directeur");
INSERT INTO Metier VALUES ("Chargé de manège");
INSERT INTO Metier VALUES ("Vendeur");
INSERT INTO Metier VALUES ("Serveur");
INSERT INTO Metier VALUES ("Technicien");


INSERT INTO TypeObjet VALUES (1,"Friandise");
INSERT INTO TypeObjet VALUES (2,"Gadget");
INSERT INTO TypeObjet VALUES (3,"Peluche");
INSERT INTO TypeObjet VALUES (4,"Bijoux");
INSERT INTO TypeObjet VALUES (5,"Souvenir");
INSERT INTO TypeObjet VALUES (6,"Vetement");
INSERT INTO TypeObjet VALUES (7,"Jouet");


INSERT INTO Zone VALUES (1,"Aqualand");
INSERT INTO Zone VALUES (2,"Haute-Voltige");
INSERT INTO Zone VALUES (3,"Lumber-zone");


INSERT INTO Famille VALUES (1,"Carrousel");
INSERT INTO Famille VALUES (2,"Tour");
INSERT INTO Famille VALUES (3,"Chenille");
INSERT INTO Famille VALUES (4,"Grand-huit");
INSERT INTO Famille VALUES (5,"Train");
INSERT INTO Famille VALUES (6,"Auto-tamponeuse");
INSERT INTO Famille VALUES (7,"Roue");


INSERT INTO Manege VALUES ("Balade des hypocampes",125,"carrousel pour enfant immergé dans l'eau",1,1);
INSERT INTO Manege VALUES ("Le moulin",0,"Petit carrousel",1,3);
INSERT INTO Manege VALUES ("L'hirrondelle",145,"Chaises volante ascendante",2,2);
INSERT INTO Manege VALUES ("Mille-Patte",120,"Petit train pour enfant",3,3);
INSERT INTO Manege VALUES ("L'envol des troglodytes",120,"Manège circulaire aérien pour enfant",3,2);
INSERT INTO Manege VALUES ("La danse des dauphins",155,"Attraction à sensation forte",4,1);
INSERT INTO Manege VALUES ("La racine",155,"Attraction à sensation forte",4,3);
INSERT INTO Manege VALUES ("La chute d'Icare",155,"Attraction à sensation forte",4,2);
INSERT INTO Manege VALUES ("Wave",150,"Descente à haute vitesse, avec chute d'eau et cascade",5,1);
INSERT INTO Manege VALUES ("Buffalo",150,"Auto-tamponeuse en forme de buffle",6,3);
INSERT INTO Manege VALUES ("L'oeil",0,"Tour de grande roue",7,2);


INSERT INTO Atelier VALUES (1,"La base sous marine",1);
INSERT INTO Atelier VALUES (2,"La forge des airs",2);
INSERT INTO Atelier VALUES (3,"L'établi",3);
INSERT INTO Atelier VALUES (4,"Entrepôt",3);

INSERT INTO Maintenance VALUES (IdM,DATEDeb,DATEFin,"NomM");
INSERT INTO Maintenance VALUES (1,to_date("dd/mm/yyyy","25/05/2023"),to_date("dd/mm/yyyy","30/05/2023"),"Le moulin");
INSERT INTO Maintenance VALUES (2,to_date("dd/mm/yyyy","25/05/2023"),to_date("dd/mm/yyyy","25/05/2023"),"La racine");


INSERT INTO Boutique VALUES (IdB,"nomB","typeB",IdZ);
INSERT INTO Boutique VALUES (1,"Macdo","restaurant",3);
INSERT INTO Boutique VALUES (2,"BK","restaurant",2);
INSERT INTO Boutique VALUES (3,"KFC","restaurant",1);
INSERT INTO Boutique VALUES (4,"Le sculpteur Joe","souvenir",3);
INSERT INTO Boutique VALUES (5,"Le nuage de l'amour","souvenir",2);
INSERT INTO Boutique VALUES (6,"Au coeur de l'épave","souvenir",1);


INSERT INTO Objet VALUES (IdO,"nomO",IdB,IdT,DATEVente,Prix);
INSERT INTO Objet VALUES (1,"Bague",4,4,null,35);
INSERT INTO Objet VALUES (2,"Porte_clef",4,5,null,5);
INSERT INTO Objet VALUES (3,"Cheval en bois",4,7,null,50);
INSERT INTO Objet VALUES (4,"Clef USB",4,2,null,16);
INSERT INTO Objet VALUES (5,"Chouchou",5,1,null,5);
INSERT INTO Objet VALUES (6,"Pomme d'amour",5,1,null,3);
INSERT INTO Objet VALUES (7,"Nounours",5,3,null,50);
INSERT INTO Objet VALUES (8,"Pistolet à eau",6,7,null,25);
INSERT INTO Objet VALUES (9,"Dauphin",6,3,null,35);
INSERT INTO Objet VALUES (10,"T-shirt Wave",6,6,null,23);
INSERT INTO Objet VALUES (11,"Orque",6,3,null,35);


INSERT INTO PiecesDetachees VALUES (NumSerie,"nomPC",IdA,IdM);
INSERT INTO PiecesDetachees VALUES (14189639,"Roue",4,IdM);
INSERT INTO PiecesDetachees VALUES (61231584,"Moteur",1,IdM);
INSERT INTO PiecesDetachees VALUES (34578422,"siège",4,IdM);
INSERT INTO PiecesDetachees VALUES (54236789,"Engrenage",4,IdM);
INSERT INTO PiecesDetachees VALUES (72435685,"wagon",2,IdM);
INSERT INTO PiecesDetachees VALUES (19626463,"auto",3,IdM);
INSERT INTO PiecesDetachees VALUES (52910329,"Moteur",4,IdM);
INSERT INTO PiecesDetachees VALUES (91025273,"chaise",2,IdM);
INSERT INTO PiecesDetachees VALUES (79193025,"Roue",1,IdM);
INSERT INTO PiecesDetachees VALUES (16718152,"Moteur",3,IdM);
INSERT INTO PiecesDetachees VALUES (87654327,"wagon",4,IdM);


INSERT INTO Personnel VALUES (NumSS,"NOM","prenom",datenaissance,MD5("Monpass"),remplace,IdA,chef,IdB,responsable);
//CM
INSERT INTO Personnel VALUES (269019550295812,"Ansel","Narcisse",to_date("03/01/1969","dd/mm/yyyy"),MD5("Monpass1"),null,null,0,null,0);
INSERT INTO Personnel VALUES (184010670392524,"Guay","Christien",to_date("16/01/1984","dd/mm/yyyy"),MD5("Monpass3"),null,null,0,null,0);
INSERT INTO Personnel VALUES (273129489402427,"Fontaine","Charlotte",to_date("05/12/1973","dd/mm/yyyy"),MD5("Monpass2"),null,null,0,null,0);
INSERT INTO Personnel VALUES (160120623950185,"Harbin","Langlois",to_date("30/12/1960","dd/mm/yyyy"),MD5("Monpass5"),null,null,0,null,0);
INSERT INTO Personnel VALUES (259057174363269,"Galarneau","Diane",to_date("08/05/1959","dd/mm/yyyy"),MD5("Monpass4"),null,null,0,null,0);
INSERT INTO Personnel VALUES (177094416301428,"Beaulieu","Felicien",to_date("23/09/1977","dd/mm/yyyy"),MD5("Monpass6"),null,null,0,null,0);
INSERT INTO Personnel VALUES (192080610253029,"Tanguay","Felix",to_date("22/08/1992","dd/mm/yyyy"),MD5("Monpass7"),null,null,0,null,0);

INSERT INTO Personnel VALUES (262017839201528,"Plouffe","Élodie",to_date("03/06/1962","dd/mm/yyyy"),MD5("Monpass12"),null,null,0,null,0);
INSERT INTO Personnel VALUES (170055426428642,"Lotye","Alexandre",to_date("29/05/1970","dd/mm/yyyy"),MD5("Monpass13"),null,null,0,null,0);
INSERT INTO Personnel VALUES (186119185783610,"Roch","Bernard",to_date("21/11/1986","dd/mm/yyyy"),MD5("Monpass14"),null,null,0,null,0);
INSERT INTO Personnel VALUES (285041689753759,"Breton","Fayme",to_date("15/05/1985","dd/mm/yyyy"),MD5("Monpass15"),null,null,0,null,0);
INSERT INTO Personnel VALUES (269054528453129,"Allard","Dominique",to_date("17/05/1969","dd/mm/yyyy"),MD5("Monpass16"),null,null,0,null,0);

//TECH
INSERT INTO Personnel VALUES (199027268902305,"Lejeune","Daniel",to_date("06/02/1999","dd/mm/yyyy"),MD5("Monpass8"),null,null,1,null,0);
INSERT INTO Personnel VALUES (280061676520542,"Meilleur","Valérie",to_date("13/06/1980","dd/mm/yyyy"),MD5("Monpass9"),null,null,0,null,0);
INSERT INTO Personnel VALUES (192121367804307,"Mousseau","Geoffrey",to_date("01/12/1992","dd/mm/yyyy"),MD5("Monpass10"),null,null,0,null,0);
INSERT INTO Personnel VALUES (159119710789325,"Labonté","Robert",to_date("14/11/1959","dd/mm/yyyy"),MD5("Monpass11"),null,null,0,null,0);

INSERT INTO Personnel VALUES (189027865394675,"Jolicoeur","joel",to_date("27/02/1989","dd/mm/yyyy"),MD5("Monpass17"),null,null,0,null,0);
INSERT INTO Personnel VALUES (188109516634135,"Landers","Roger",to_date("14/10/1988","dd/mm/yyyy"),MD5("Monpass18"),null,null,0,null,0);
INSERT INTO Personnel VALUES (285062730491825,"Méthoir","Carole",to_date("27/06/1985","dd/mm/yyyy"),MD5("Monpass19"),null,null,0,null,0);
INSERT INTO Personnel VALUES (183125910395284,"Lagrange","Arnaud",to_date("05/12/1983","dd/mm/yyyy"),MD5("Monpass20"),null,null,0,null,0);


AM/PM
INSERT INTO Competences VALUES (269019550295812,1);
INSERT INTO Competences VALUES (269019550295812,3);
AM/PM
INSERT INTO Competences VALUES (273129489402427,2);
INSERT INTO Competences VALUES (273129489402427,4);
INSERT INTO Competences VALUES (273129489402427,5);
AM/PM
INSERT INTO Competences VALUES (184010670392524,6);
INSERT INTO Competences VALUES (184010670392524,7);
INSERT INTO Competences VALUES (184010670392524,3);
AM/PM
INSERT INTO Competences VALUES (160120623950185,1);
INSERT INTO Competences VALUES (160120623950185,4);
INSERT INTO Competences VALUES (160120623950185,5);
INSERT INTO Competences VALUES (160120623950185,7);
AM/PM
INSERT INTO Competences VALUES (259057174363269,4);
INSERT INTO Competences VALUES (259057174363269,5);
AM/PM
INSERT INTO Competences VALUES (177094416301428,6);
INSERT INTO Competences VALUES (177094416301428,7);
AM/PM
INSERT INTO Competences VALUES (192080610253029,1);
INSERT INTO Competences VALUES (192080610253029,2);
INSERT INTO Competences VALUES (192080610253029,3);
INSERT INTO Competences VALUES (192080610253029,4);

AM/
INSERT INTO Competences VALUES (262017839201528,4);
AM/PM
INSERT INTO Competences VALUES (170055426428642,3);
INSERT INTO Competences VALUES (170055426428642,1);
AM/PM
INSERT INTO Competences VALUES (186119185783610,1);



INSERT INTO Equipe VALUES (199027268902305,1);
INSERT INTO Equipe VALUES (199027268902305,2);

INSERT INTO Equipe VALUES (280061676520542,1);

INSERT INTO Equipe VALUES (192121367804307,2);

INSERT INTO Equipe VALUES (159119710789325,2);


INSERT INTO Bilan VALUES ("NomM",NumSS,DateB,frequentation,demi_journee);

INSERT INTO Bilan VALUES ("Wave",269019550295812,to_char("14/03/2023","dd/mm/yyyy"),564,"AM");
INSERT INTO Bilan VALUES ("Wave",259057174363269,to_char("14/03/2023","dd/mm/yyyy"),612,"PM");

INSERT INTO Bilan VALUES ("La danse des dauphins",259057174363269,to_char("14/03/2023","dd/mm/yyyy"),478,"AM");
INSERT INTO Bilan VALUES ("La danse des dauphins",273129489402427,to_char("14/03/2023","dd/mm/yyyy"),514,"PM");

INSERT INTO Bilan VALUES ("Buffalo",177094416301428,to_char("14/03/2023","dd/mm/yyyy"),264,"AM");
INSERT INTO Bilan VALUES ("Buffalo",184010670392524,to_char("14/03/2023","dd/mm/yyyy"),352,"PM"));

INSERT INTO Bilan VALUES ("Mille-Patte",184010670392524,to_char("14/03/2023","dd/mm/yyyy"),421,"AM");
INSERT INTO Bilan VALUES ("Mille-Patte",269019550295812,to_char("14/03/2023","dd/mm/yyyy"),354,"PM"));

INSERT INTO Bilan VALUES ("La racine",262017839201528,to_char("14/03/2023","dd/mm/yyyy"),512,"AM");
INSERT INTO Bilan VALUES ("La racine",259057174363269,to_char("14/03/2023","dd/mm/yyyy"),580,"PM"));

INSERT INTO Bilan VALUES ("L'oeil",160120623950185,to_char("14/03/2023","dd/mm/yyyy"),315,"AM");
INSERT INTO Bilan VALUES ("L'oeil",177094416301428,to_char("14/03/2023","dd/mm/yyyy"),315,"PM"));

INSERT INTO Bilan VALUES ("L'envol des troglodytes",170055426428642,to_char("14/03/2023","dd/mm/yyyy"),230,"AM");
INSERT INTO Bilan VALUES ("L'envol des troglodytes",170055426428642,to_char("14/03/2023","dd/mm/yyyy"),299,"PM"));

INSERT INTO Bilan VALUES ("La chute d'Icare",192080610253029,to_char("14/03/2023","dd/mm/yyyy"),480,"AM");
INSERT INTO Bilan VALUES ("La chute d'Icare",160120623950185,to_char("14/03/2023","dd/mm/yyyy"),512,"PM"));

INSERT INTO Bilan VALUES ("L'hirrondelle",273129489402427,to_char("14/03/2023","dd/mm/yyyy"),360,"AM");
INSERT INTO Bilan VALUES ("L'hirrondelle",192080610253029,to_char("14/03/2023","dd/mm/yyyy"),452,"PM"));

INSERT INTO Bilan VALUES ("Balade des hypocampes",186119185783610,to_char("14/03/2023","dd/mm/yyyy"),350,"AM");
INSERT INTO Bilan VALUES ("Balade des hypocampes",186119185783610,to_char("14/03/2023","dd/mm/yyyy"),280,"PM"));





