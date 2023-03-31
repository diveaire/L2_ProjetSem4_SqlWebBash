<!DOCTYPE HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])){
        $NomM=$_GET["NomM"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        if($_SESSION['droit']==2){
            $req="SELECT B.nomM FROM Bilan B, Personnel P WHERE P.NumSS='".$_SESSION['numss']."' AND P.NumSS=B.NumSS AND DateB>=(SELECT MAX(B1.DateB) FROM Bilan B1 WHERE B1.nomM=B.nomM)";
            $res=mysqli_query($idcom,$req);
            if($res){
                $val=false;
                while($row=mysqli_fetch_array($res)){
                    if($row[0]==$NomM){
                        $val=true;
                    }
                }
            }
        }
        elseif($_SESSION['droit']==1){
            $val=true;
        }
    }
?>
<html>
<head>
    <title>page de Modification</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../../Style/menu.css">
    <link rel="stylesheet" href="../../Style/styleProfil.css">
    <script src="../../Script/script.js"></script>
    <script src="../../Script/date.js"></script>
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
    if (($val)&&(isset($_SESSION['metier']))&&(($_SESSION['droit']==1)||($_SESSION['droit']==2))){
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
        echo "<div><button onclick=aff('modMan')><span>Modifier</span></button></div>";
        if($_SESSION['droit']==1){
            echo "<div><button onclick=aff('delMan')><span>Supprimer</span></button></div>";
        }
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
<?PHP
    if($_SESSION['droit']==1){
?>
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
    }
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
        echo "<div><button onclick=aff('addBil')><span>Modifier</span></button></div>";
        if($_SESSION['droit']==1){
            echo "<div><button onclick=aff('delBil')><span>Supprimer</span></button></div>";
        }
        echo "</div>";
    }
?>
 <div class='bloc' id="addBil" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Bilan'></input>";
                    ?>
                    Date :
                    <input type="date" name='DateB' min="2020-01-01" required pattern="\d{2}-\d{2}-\d{4}"></input>
                    <select name="ap">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                    Chargé de manège :
                    <?PHP
                    if($_SESSION['droit']==1){
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P, Competences C WHERE P.Metier='Chargé de manège' AND P.NumSS=C.NumSS AND EXISTS(SELECT * FROM Manege M WHERE M.NomM='$NomM' AND C.IdF=M.IdF)";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='ns'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Aucun chargé de manège n'est disponible";
                            }
                            
                        }
                    }
                    else{
                        $ns=$_SESSION['numss'];
                        $req="SELECT UPPER(nomP), prenomP FROM Personnel WHERE NumSS='$ns'";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $val=mysqli_fetch_array($res);
                            $nomP=$val[0]." ".$val[1];
                        }
                        echo "<select name='ns'>";
                            echo "<option value='$ns'>$nomP</option>";
                        echo "</select>";
                        unset($ns);
                    }
                        
                    ?>
                    <input type="text" name="frequentation" placeholder="Fréquentation"></input>
                    <input type="submit" name="modify" value="Confirmer">
            </form>
    </div>
<?PHP
    if($_SESSION['droit']==1){
?>
    <div class='bloc' id="delBil" style='display:none;'>
            <form method='POST' action='../Modif/delete.php'>
                    <?PHP
                    echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                    echo "<input type='hidden' name='tb' value='Bilan'></input>";
                    ?>
                    Date :
                    <input type="date" name='date' required pattern="\d{2}-\d{2}-\d{4}"></input>
                    <select name="ap">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                    <input type="submit" name="delete" value="Confirmer">
            </form>
    </div>
<?PHP
    }
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
        $req="SELECT IdM FROM Maintenance  WHERE NomM='$NomM' AND DateFin IS NULL";
        $res=mysqli_query($idcom,$req);
        $ligne=mysqli_num_rows($res);
        if($ligne==0){
            echo "<div><button onclick=aff('addMai');setDateD()><span>Mettre en maintenance</span></button></div>";
        }else{
            $val=mysqli_fetch_array($res);
            $val=$val[0];
            if($_SESSION['droit']==1){
                echo "<div><button onclick=aff('addMai')><span>Fin de la maintenance</span></button></div>";
                echo "<div><button onclick=aff('delMai')><span>Annuler</span></button></div>";
            }
        }
        echo "</div>";
?>
        <div class='bloc' id="addMai" style='display:none;'>
        <?PHP
        if($ligne==0){
        ?>
                <form method='POST' action='equipeadm.php'>
                        <?PHP
                        echo "<input type='hidden' name='id' value='".$_GET['NomM']."'></input>";
                        echo "<input type='hidden' name='tb' value='Maintenance'></input>";
                        ?>
                        Début de la maintenance :
                        <input type="date" id="DebMaintenance" name='DateDeb' required pattern="\d{2}-\d{2}-\d{4}"></input>
                        Atelier :
                        <?php
                            $req="SELECT A.IdA, A.nomA FROM Atelier A WHERE A.IdZ=(SELECT M.IdZ FROM Manege M WHERE M.NomM='$NomM')";
                            $res=mysqli_query($idcom,$req);
                        ?>
                        <select name="IdA">
                        <?php
                            while($row=mysqli_fetch_array($res)){
                                echo"<option value='$row[0]'>$row[1]</option>";
                            }
                        ?>
                        </select>
                        <input type="submit" name="Add" value="Confirmer">
                </form>
        <?php
        }else{
            if($_SESSION['droit']==1){
        ?>
            <form method='POST' action='../Modif/modify.php'>
                        <?PHP
                        echo "<input type='hidden' name='id' value='".$val."'></input>";
                        echo "<input type='hidden' name='tb' value='Maintenance'></input>";
                        $req="SELECT DATE_FORMAT(DateDeb,'%Y-%m-%d') FROM Maintenance WHERE IdM=$val";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $row=mysqli_fetch_array($res);
                            echo "Fin de la maintenance :";
                            echo "<input type='date' min='$row[0]' name='DateFin' required pattern='\d{2}-\d{2}-\d{4}'></input>";
                        }
                        ?>
                        <input type="submit" name="End" value="Confirmer">
            </form>
        </div>
        <div class='bloc' id="delMai" style='display:none;'>
                <form method='POST' action='../Modif/delete.php'>
                        <?PHP
                        echo "<input type='hidden' name='id' value='".$val."'></input>";
                        echo "<input type='hidden' name='tb' value='Maintenance'></input>";
                        ?>
                        <input type="submit" name="delete" value="Confirmer">
                </form>
        </div>
        <?php
            }
        }
        ?>
 <?PHP       
    }
    mysqli_close($idcom);
    }
    elseif(isset($_SESSION['metier'])){
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>
</html>