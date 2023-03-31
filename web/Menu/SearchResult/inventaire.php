<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Boutique</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../../Style/styleSearch.css">
</head>
<body>
<?PHP
session_start();
if (isset($_SESSION['metier'])){
    if ($_SESSION['metier']=="Directeur"){
        $Id=$_GET["Id"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        $requete="SELECT O.nomO, O.Prix, T.libelleT, B.nomB, DATE_FORMAT(O.DateVente,'%d/%m/%Y') FROM Objet O,TypeObjet T, Boutique B WHERE B.IdB=O.IdB AND T.IdT=O.IdT AND IdO='$Id'";
        $res=mysqli_query($idcom,$requete);
        if($res){
            $row=mysqli_fetch_array($res);
            //CAS OU L'OBJET PROVIENT D'UNE BOUTIQUE
            if (!empty($row[0])){
                echo "<div class='bloc'>";
                echo "<div class='group'> Objet : ".$row[0]."</div>";
                $nomO=$row[0];
                $Prix=$row[1];
                $libelleT=$row[2];
                $nomB=$row[3];
                $dateVente=$row[4];
                echo "<table>";
                echo "<tr><th>Nom Objet</th><th>Prix</th><th>Type Objet</th><th>Nom Boutique</th>";
                if (!is_null($dateVente)){
                    echo "<th>Date de Vente</th>";
                }
                echo "</tr>";
                //AFFICHAGE NOM;PRENOM;DATE NAISSANCE;METIER
                echo "<tr><td>$nomO</td><td>$Prix</td><td>$libelleT</td><td>$nomB</td>";
                if (!is_null($dateVente)){
                    echo "<td>$dateVente</td>";
                }
                echo "</tr></table></div>";
            }else{//CAS OU L'OBJET PROVIENT D'UN ATELIER
                $requete="SELECT P.nomPC, P.NumSerie,A.nomA,P.IdM  FROM PiecesDetachees P,Atelier A WHERE P.IdA=A.IdA AND P.NumSerie='$Id'";
                $res=mysqli_query($idcom,$requete);
                if($res){
                    $row=mysqli_fetch_array($res);
                    echo "<div class='bloc'>";
                    echo "<div class='group'> Piece détachée : ".$row[0]."</div>";
                    $nomPC=$row[0];
                    $NumSerie=$row[1];
                    $nomA=$row[2];
                    $IdM=$row[3];
                    echo "<table>";
                    echo "<tr><th>Nom Pièce</th><th>Numéro de série</th><th>Stocké dans</th></tr>";
                    //AFFICHAGE NOMPC;NUMSERIE;NOMA
                    echo "<tr><td>$nomPC</td><td>$NumSerie</td><td>$nomA</td></tr></table></div>";
                    if (!is_null($IdM)){
                        echo "<div class='bloc'>";
                        echo "<div class='group'> Maintenance : ".$row[0]."</div>";
                        $requeteMain="SELECT IdM,DateDeb,DateFin,NomM FROM Maintenance WHERE IdM='$IdM'";
                        $resMain=mysqli_query($idcom,$requeteMain);
                        if($resMain){
                            $rowMain=mysqli_fetch_array($resMain);
                            echo "<table>";
                            echo "<tr><th>Identifiant</th><th>Date Début</th><th>Date Fin</th><th>Nom Manège</th></tr>";
                            //AFFICHAGE DETAILS MAINTENANCE
                            echo "<tr><td>$rowMain[0]</td><td>$rowMain[1]</td><td>$rowMain[2]</td><td>$rowMain[3]</td></tr></table></div>";
                        }
                    }
                    echo "</tr></table></div>";
                }
            }
        }
    }
    echo "<br><a href='javascript:window.close();'>Fermer la fenêtre</a> ";
    mysqli_close($idcom);
}else{
    echo "Merci de vous connecter <a href='../../index.php'>log in </a>";
}
?>
</body>
</html>
