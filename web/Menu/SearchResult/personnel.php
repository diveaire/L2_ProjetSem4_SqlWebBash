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
        $NumSS=$_GET["NumSS"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        $requete="SELECT nomP,prenomP,DATE_FORMAT(date_naissance,'%d/%m/%Y'),Metier,remplace,chef,Responsable FROM Personnel WHERE NumSS='$NumSS'";
        $res=mysqli_query($idcom,$requete);
        if($res){
            $row=mysqli_fetch_array($res);
            echo "<div class='bloc'>";
            echo "<div class='group'> Personnel : ".$row[0]." ".$row[1]."</div>";
            $nomP=$row[0];
            $prenomP=$row[1];
            $date_naissance=$row[2];
            $Metier=$row[3];
            $remplace=$row[4];
            $chef=$row[5];
            $responsable=$row[6];
            echo "<table>";
            echo "<tr><th>Nom</th><th>Prénom</th><th>date de naissance</th><th>Métier</th><th>Chef/Responsable</th>";
            if (!is_null($remplace)){
                echo "<th>Remplaçant</th>";
            }
            echo "</tr>";
            //AFFICHAGE NOM;PRENOM;DATE NAISSANCE;METIER
            echo "<tr><td>$nomP</td><td>$prenomP</td><td>$date_naissance</td><td>$Metier</td>";
            if ($chef==1 || $responsable){
                echo "<td>Oui</td></tr>";
            }else{
                echo "<td>Non</td>";
            }
            //AFFICHAGE REMPLACANT
            if (!is_null($remplace)){
                $requeteRemp="SELECT nomP,prenomP FROM Personnel WHERE NumSS='$remplace'";
                $resRemp=mysqli_query($idcom,$requeteRemp);
                $rowRemp=mysqli_fetch_array($resRemp);
                echo "<td>$rowRemp[0] $rowRemp[1]</td>";
            }
            echo "</tr></table></div>";
            //AFFICHAGE CARACTERISTIQUES METIER
            if ($Metier=="Chargé de manège"){
                $requeteCM="SELECT libelleF FROM Famille F, Competences C, Personnel P WHERE P.NumSS=C.NumSS AND F.IdF=C.IdF AND P.NumSS='$NumSS'";
                $resCM=mysqli_query($idcom,$requeteCM);
                if($resCM) {
                    echo "<div class='bloc'><div class='group'>Compétences</div><div class='group1'>";
                    echo "<table><tr><th>S'occupe de </th></tr>";
                    while($row=mysqli_fetch_array($resCM)){
                        echo "<tr><td>".$row[0]."</td></tr>";
                    }
                    echo "</table></div>";
                }
            }
            elseif ($Metier=="Vendeur" || $Metier=="Serveur"){
                $requeteCM="SELECT nomB FROM Boutique B, Personnel P WHERE P.IdB=B.IdB AND P.NumSS='$NumSS'";
                $resCM=mysqli_query($idcom,$requeteCM);
                if($resCM) {
                    echo "<div class='bloc'><div class='group'>Boutique</div><div class='group1'>";
                    echo "<table><tr><th>travail dans </th></tr>";
                    while($row=mysqli_fetch_array($resCM)){
                        echo "<tr><td>".$row[0]."</td></tr>";
                    }
                    echo "</table></div>";
                }
            }
            elseif ($Metier=="Technicien"){
                $requeteAtl="SELECT nomA FROM Atelier A, Personnel P WHERE P.IdA=A.IdA AND P.NumSS='$NumSS'";
                $resAtl=mysqli_query($idcom,$requeteAtl);
                if($resAtl) {
                    echo "<div class='bloc'><div class='group'>Atelier</div><div class='group1'>";
                    echo "<table><tr><th>travail dans </th></tr>";
                    while($row=mysqli_fetch_array($resAtl)){
                        echo "<tr><td>".$row[0]."</td></tr>";
                    }
                    echo "</table></div>";
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
