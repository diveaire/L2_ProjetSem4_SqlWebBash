<!DOCTYPE HTML>
<html>
<head>
    <title>Boutique</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet">
</head>
<body>
<?PHP
        session_start();
        if (isset($_SESSION['metier'])){
            $IdB=$_GET["IdB"];
            include("connex.inc.php");
            $idcom=connex("myparam");
            $requete="SELECT nomB,typeB,nomZ FROM Boutique B, Zone Z WHERE B.IdB='$IdB' AND Z.IdZ=B.IdZ";
            $res=mysqli_query($idcom,$requete);
            $requetei="SELECT DISTINCT T.libelleT FROM Boutique B, Objet O, TypeObjet T WHERE B.IdB='$IdB' AND O.IdB=B.IdB AND O.IdT=T.IdT AND O.DateVente IS NULL ";
            $resi=mysqli_query($idcom,$requetei);
            if($res){
                $row=mysqli_fetch_array($res);
                echo "Boutique : ".$row[0]."<br><br>";
                $nomB=$row[0];
                $typeB=$row[1];
                $nomZ=$row[2];
                echo "<table border='2px'>";
                echo "<tr><td>Nom Boutique</td><td>Type</td><td>Zone</td></tr>";
                echo "<tr><td>$nomB</td><td>$typeB</td><td>$nomZ</td></tr>"; 
                echo "</table><br>";    
            }
            if($resi){
                echo "Inventaire : <br><br>";
                echo "<table border='2px'>";
                echo "<tr><td>Type d'objet</td></tr>";
                while($row=mysqli_fetch_array($resi)){
                    echo "<tr><td>".$row[0]."</td></tr>";
                }
                echo "</table>";  
            }

            echo "<br><a href='javascript:window.close();'>Fermer la fenêtre</a> ";
        }else{
            echo "Merci de vous connecter <a href='index.php'>log in </a>";
        }
        ?>
</body>
</html>
