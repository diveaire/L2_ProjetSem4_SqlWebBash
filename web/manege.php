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
            $requete2="SELECT DATE_FORMAT(B.DateB,'%d/%m/%Y'),demi_journee,UPPER(P.nomP),P.prenomP,frequentation FROM Bilan B, Personnel P WHERE P.NumSS=B.NumSS AND B.NomM='$NomM' ORDER BY B.DateB DESC, demi_journee DESC ";
            $res2=mysqli_query($idcom,$requete2);
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
            if($res2){
                echo "<br>Bilan : ".$_GET["NomM"]."<br><br>";
                echo "<table border='2px'>";
                echo "<tr><td>Date</td><td>AM/PM</td><td>Chargé de Manège</td><td>Fréquentation</td></tr>";
                $l=mysqli_num_rows($res2);
                if($l>0){
                    while($row=mysqli_fetch_array($res2)){
                        $DateB=$row[0];
                        $ap=$row[1];
                        $CM="$row[2] $row[3]";
                        $freq=$row[4];
                        echo "<tr><td>$DateB</td><td>$ap</td><td>$CM</td><td>$freq</td></tr>"; 
                    }
                }
                else{
                    echo "<tr><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td></tr>"; 
                }
                echo "</table>";    
            }

            echo "<br><a href='javascript:window.close();'>Fermer la fenêtre</a> ";
            mysqli_close($idcom);
        }else{
            echo "Merci de vous connecter <a href='index.php'>log in </a>";
        }
        ?>
</body>
</html>