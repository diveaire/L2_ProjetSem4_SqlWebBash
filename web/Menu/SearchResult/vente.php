<!DOCTYPE HTML>
<html>
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
        $IdO=$_GET["IdO"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        $requete="SELECT O.nomO, O.Prix, T.libelleT, B.nomB, DATE_FORMAT(O.DateVente,'%d/%m/%Y') FROM Objet O,TypeObjet T, Boutique B WHERE B.IdB=O.IdB AND T.IdT=O.IdT AND IdO='$IdO'";
        $res=mysqli_query($idcom,$requete);
        if($res){
            $row=mysqli_fetch_array($res);
            echo "<div class='bloc'>";
            echo "<div class='group'> Objet : ".$row[0]."</div>";
            $nomO=$row[0];
            $Prix=$row[1];
            $libelleT=$row[2];
            $nomB=$row[3];
            $dateVente=$row[4];
            echo "<table>";
            echo "<tr><th>Nom Objet</th><th>Prix</th><th>type Objet</th><th>Boutique</th>";
            if (!is_null($dateVente)){
                echo "<th>Date de Vente</th>";
            }
            echo "</tr>";
            //AFFICHAGE NOM;PRENOM;DATE NAISSANCE;METIER
            echo "<tr><td>$nomO</td><td>$Prix €</td><td>$libelleT</td><td>$nomB</td>";
            if (!is_null($dateVente)){
                echo "<td>$dateVente</td>";
            }
            echo "</tr></table>";
        }
        echo "</div>";
    }
    echo "<br><a href='javascript:window.close();'>Fermer la fenêtre</a> ";
    mysqli_close($idcom);
}else{
    echo "Merci de vous connecter <a href='../../index.php'>log in </a>";
}
?>
</body>
</html>
