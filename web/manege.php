<!DOCTYPE HTML>
<html>
<head>
    <title>Manege</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet">
</head>
<body>
<?PHP
        session_start();
        if (isset($_SESSION['metier'])){
            $NomM=$_GET["NomM"];
            include("connex.inc.php");
            $idcom=connex("myparam");
            $requete="SELECT tailleMin,description,libelleF,nomZ FROM Manege M, Zone Z, Famille F WHERE NomM='$NomM' AND Z.IdZ=M.IdZ AND F.IdF=M.IdF";
            $res=mysqli_query($idcom,$requete);
            $requete1="SELECT DATE_FORMAT(M.DateDeb,'%d/%m/%Y'),DATE_FORMAT(M.DateFin,'%d/%m/%Y') FROM Maintenance M WHERE M.NomM='$NomM' AND M.DateFin>=ALL(SELECT M1.DateFin FROM Maintenance M1 WHERE M1.NomM='$NomM')";
            $res1=mysqli_query($idcom,$requete1);
            if($res){
                $row=mysqli_fetch_array($res);
                echo "Manege : ".$_GET["NomM"]."<br><br>";
                $tailleMin=$row[0];
                $description=$row[1];
                $nomF=$row[2];
                $nomZ=$row[3];
                if($res1){
                    $row=mysqli_fetch_array($res1);
                    if(!empty($row[0])&&!empty($row[1])){
                        $dateM="Du $row[0] au $row[1]";
                    }
                    else{
                        $dateM="Aucune";
                    }
                }
                else{
                    $dateM="Aucune";
                }
                echo "<table border='2px'>";
                echo "<tr><td>Nom Manège</td><td>Taille Minimale</td><td>Description</td><td>Famille de manège</td><td>Zone</td><td>Dernière Maintenance</td></tr>";
                echo "<tr><td>$NomM</td><td>$tailleMin</td><td>$description</td><td>$nomF</td><td>$nomZ</td><td>$dateM</td></tr>"; 
                echo "</table>";    
            }

            echo "<br><a href='javascript:window.close();'>Fermer la fenêtre</a> ";
        }else{
            echo "Merci de vous connecter <a href='index.php'>log in </a>";
        }
        ?>
</body>
</html>