<!DOCTYPE HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])){
?>
<html>
<head>
    <title>page de Modification</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../../Style/menu.css">
    <link rel="stylesheet" href="../../Style/styleProfil.css">
    <script src="../../Script/script.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="../accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="../profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="../recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="../gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="../logout.php">Log out</a></li>
</ul>
<?PHP
    $NomM=$_GET["NomM"];
    include("../../Parametres/connex.inc.php");
    $idcom=connex("myparam");
    $requete="SELECT tailleMin,description,libelleF,nomZ FROM Manege M, Zone Z, Famille F WHERE NomM='$NomM' AND Z.IdZ=M.IdZ AND F.IdF=M.IdF";
    $res=mysqli_query($idcom,$requete);
    $requete1="SELECT DATE_FORMAT(B.DateB,'%d/%m/%Y'),demi_journee,UPPER(P.nomP),P.prenomP,frequentation FROM Bilan B, Personnel P WHERE P.NumSS=B.NumSS AND B.NomM='$NomM' ORDER BY B.DateB DESC, demi_journee DESC ";
    $res1=mysqli_query($idcom,$requete1);
    $requete2="SELECT E.IdM,DATE_FORMAT(M.DateDeb,'%d/%m/%Y'),DATE_FORMAT(M.DateFin,'%d/%m/%Y'),COUNT(E.NumSS) FROM Maintenance M, Equipe E WHERE M.NomM='$NomM' AND E.IdM=M.IdM GROUP BY (E.IdM)";
    $res2=mysqli_query($idcom,$requete2);
    if($res){
        $row=mysqli_fetch_array($res);
        echo "<div class='bloc'>";
        echo "<div class='group'> Manege : ".$_GET["NomM"]."</div>";
        $tailleMin=$row[0];
        $description=$row[1];
        $nomF=$row[2];
        $nomZ=$row[3];
        echo "<table border=2px>";
        echo "<tr><th>Nom Manège</th><th>Taille Minimale</th><th>Description</th><th>Famille de manège</th><th>Zone</th></tr>";
        echo "<tr><td>$NomM</td><td>$tailleMin</td><td>$description</td><td>$nomF</td><td>$nomZ</td></tr>"; 
        echo "</table>";
        echo "<div><button onclick=aff('modMan')>Modifier</button></div>";
        echo "<div><button onclick=aff('delMan')>Supprimer</button></div>";
        echo "</div>";
    }
?>
    <div class='bloc' id="modMan" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Manege'></input>";
                    ?>
                    <select name="att">
                        <option value="nomM">Nom du Manège</option>
                        <option value="tailleMin">Taille Minimale</option>
                        <option value="description">Description</option>
                        <option value="zone">Zone</option>
                    </select>
                    <input type="text" name="val"></input>
                    <input type="submit" name="modify" value="Confirmer">
            </form>
    </div>
    <div class='bloc' id="delMan" style='display:none;'>
            <form method='POST' action='../Modif/delete.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Manege'></input>";
                    ?>
                    <input type="submit" name="delete" value="Confirmer">
            </form>
    </div>
<?PHP
    if($res1){
        echo "<div class='bloc'>";
        echo "<div class='group'>Bilan : ".$_GET["NomM"]."</div>";
        echo "<table border=2px>";
        echo "<tr><th>Date</th><th>AM/PM</th><th>Chargé de Manège</th><th>Fréquentation</th></tr>";
        $l=mysqli_num_rows($res1);
        if($l>0){
            while($row=mysqli_fetch_array($res1)){
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
        echo "<div><button onclick=aff('adBil')>Modifier</button></div>";
        echo "<div><button onclick=aff('delBil')>Supprimer</button></div>";
        echo "</div>";
    }
?>
 <div class='bloc' id="adBil" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Bilan'></input>";
                    ?>
                    Date :
                    <input type="date"></input>
                    <select name="ap">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                    Chargé de manège :
                    <select name="ns">
                    <?PHP
                        $req="SELECT NumSS, UPPER(nomP), prenomP FROM Personnel WHERE Metier='Chargé de manège'";
                        $res=mysqli_query($idcom,$req);
                        while($row=mysqli_fetch_array($res)){
                            echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                        }
                    ?>
                    </select>
                    <input type="submit" name="modify" value="Confirmer">
            </form>
    </div>
    <div class='bloc' id="delBil" style='display:none;'>
            <form method='POST' action='../Modif/delete.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Bilan'></input>";
                    ?>
                    Date :
                    <input type="date"></input>
                    <select name="ap">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                    <input type="submit" name="delete" value="Confirmer">
            </form>
    </div>
<?PHP
    if($res2){
        echo "<div class='bloc'>";
        echo "<div class='group'>Maintenances : ".$_GET["NomM"]."</div>";
        echo "<table border=2px>";
        echo "<tr><th>Nom de l'Atelier</th><th>Date de début</th><th>Date de fin</th><th>Nombre de personnel</th></tr>";
        $l=mysqli_num_rows($res2);
        if($l>0){
            while($row=mysqli_fetch_array($res2)){
                $IdM=$row[0];
                $DateB=$row[1];
                $DateF=$row[2];
                $NbP=$row[3];
                $requete11="SELECT A.nomA FROM Atelier A WHERE A.IdA IN (SELECT P.IdA FROM Personnel P, Equipe E, Maintenance M WHERE P.NumSS=E.NumSS AND E.IdM=M.IdM)";
                $resA=mysqli_query($idcom,$requete11);
                if($resA){
                    $nomA=mysqli_fetch_array($resA);
                    echo "<tr><td>$nomA[0]</td><td>$DateB</td><td>$DateF</td><td>$NbP</td></tr>"; 
                }
                else{
                     echo "<tr><td>Aucun Atelier</td><td>$DateB</td><td>$DateF</td><td>$NbP</td></tr>"; 
                }
            }
        }
        else{
            echo "<tr><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td></tr>"; 
        }
        echo "</table>";
        echo "</div>";
    }
    mysqli_close($idcom);
    }
    else{
        header('Location: ../../index.php');
    }
?>
</html>