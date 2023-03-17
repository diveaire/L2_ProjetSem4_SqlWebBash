SELECT P.NomP, P.PrenomP FROM Personnel P WHERE P.NumSS in (SELECT E.NumSS FROM Equipe E WHERE E.IdM in (SELECT M.IdM FROM Maintenance M WHERE DateDeb=TO_DATE('12/03/2022','dd/mm/yyyy') AND NomM='Splash'));

SELECT P.nomP, P.prenomP FROM Personnel P, Competences C, Manege M WHERE P.Metier='Chargé de manège' AND M.NomM='Big Noise' AND P.NumSS=C.NumSS AND M.IdF=C.IdF AND NOT EXISTS( SELECT B.NomM FROM Bilan B WHERE B.NumSS=P.NumSS AND B.DateB=TO_DATE('11/11/2023','dd/mm/yyyy'));

SELECT T.libelleT, TO_CHAR(O.DateVente,'MONTH') Mois, SUM(O.prix) Revenus FROM Objet O, TypeObjet T WHERE T.IdT=O.IdT AND O.DateVente IS NOT NULL GROUP BY T.libelleT, TO_CHAR(O.DateVente,'MONTH');

SELECT P.nomPc FROM PiecesDetachees P, Maintenance M WHERE P.IdM=M.IdM AND M.NomM='High-Speed' AND M.DateFin >=(SELECT MAX(M1.DateFin) FROM Maintenance M1 WHERE M1.NomM='High-Speed' );

SELECT T.libelleT FROM TypeObjet T WHERE NOT EXISTS(
    SELECT B.IdB FROM Boutique B WHERE NOT EXISTS(
        SELECT * FROM Objet O WHERE O.IdT=T.IdT AND B.IdB=O.IdB
    )
);

SELECT DISTINCT M1.NomM FROM Maintenance M1 WHERE M1.IdM IN(SELECT M.IdM FROM Maintenance M, Equipe E WHERE M.IdM=E.IdM GROUP BY(M.IdM) HAVING(COUNT(DISTINCT E.NumSS)>=3));

SELECT Z.nomZ FROM Zone Z, Manege M WHERE M.IdZ=Z.IdZ GROUP BY(Z.nomZ) HAVING COUNT(DISTINCT M.IdF)>=(SELECT COUNT(F.IdF) FROM Famille F);

SELECT P.nomP, P.prenomP FROM Personnel P, Maintenance M, Equipe E WHERE M.IdM=E.IdM AND E.NumSS=P.NumSS GROUP BY(P.nomP, P.prenomP,P.NumSS) HAVING(COUNT(DISTINCT M.IdM)>2);

SELECT P.nomP,P.prenomP FROM Personnel P WHERE NOT EXISTS((SELECT F.IdF FROM Famille F)MINUS(SELECT C.IdF FROM Competences C WHERE P.NumSS=C.NumSS));

SELECT M.IdM, M.NomM, COUNT(E.NumSS) 'Effectif' FROM Maintenance M, Equipe E WHERE M.IdM=E.IdM GROUP BY (M.IdM,M.NomM) HAVING (COUNT(E.NumSS)>= ALL(SELECT COUNT(E1.NumSS) FROM Equipe E1 GROUP BY(E1.IdM)));

SELECT B.DateB FROM Bilan B WHERE B.NomM="Buffalo" AND B.frequentation=(SELECT MAX(B1.frequentation) FROM Bilan B1 WHERE B1.NomM="Buffalo");

SELECT DISTINCT O.nomO FROM Objet O, Boutique B WHERE O.DateVente>=TO_DATE('01/12/2022','DD/MM/YYYY') AND O.DateVente<=STR_TO_DATE('15/12/2022','DD/MM/YYYY') AND B.nomB="Le sculpteur Joe" AND B.IdB=O.IdB;

SELECT P.nomP, P.prenomP FROM Personnel P WHERE P.Metier="Chargé de manège" AND NOT EXISTS(SELECT * FROM Bilan B WHERE B.NumSS=P.NumSS);

SELECT F.libelleF FROM Famille F, Manege M WHERE F.IdF=M.IdF GROUP BY (F.libelleF,F.IdF) HAVING COUNT(M.NomM)>=ALL(SELECT COUNT(M2.NomM) FROM Manege M2, Famille F2 WHERE F2.IdF=M2.IdF GROUP BY(F2.IdF));

SELECT nomP, prenomP FROM Personnel P WHERE chef=1 OR responsable=1;

SELECT libelleT, AVG(prix) "Moyenne" FROM TypeObjet T,Objet O WHERE T.IdT=O.IdT GROUP BY (libelleT,O.IdT);

SELECT nomP, prenomP FROM Personnel WHERE upper(prenomP) like 'N%' OR prenomP like 'J%';

(SELECT NomM,tailleMin from Manege M,Famille F WHERE M.IdF=F.IdF AND (libelleF='Grand-huit' OR libelleF='Train') AND tailleMin<=150)
UNION
(SELECT NomM, 'Trop Petit' FROM Manege M,Famille F WHERE M.IdF=F.IdF AND (libelleF='Grand-huit' OR libelleF='Train') AND  tailleMin>150);

SELECT sum(prix) FROM Objet O, Boutique B WHERE O.IdB=B.IdB AND O.DateVente>=STR_TO_DATE('01/02/2023','DD/MM/YYYY') AND O.DateVente<=TO_DATE('31/02/2023','DD/MM/YYYY');
