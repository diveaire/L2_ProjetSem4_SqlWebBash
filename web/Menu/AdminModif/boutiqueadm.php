<!DOCTYPE HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])){
    include("../../Parametres/connex.inc.php");
    $idcom=connex("myparam");
    $id=$_SESSION['numss'];
    $metier=$_SESSION['metier'];
    $IdB=$_GET["IdB"];
    if(($_SESSION['droit']==3)||($_SESSION['droit']==4)){
        $req="SELECT IdB FROM Personnel WHERE NumSS='$id'";
        $res=mysqli_query($idcom,$req);
        if($res){
            $val=false;
            while($row=mysqli_fetch_array($res)){
                if($row[0]==$IdB){
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
<html lang="fr">
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
        if ($val&&(($_SESSION['droit']==1)||($_SESSION['droit']==3)||($_SESSION['droit']==4))){
            $requete="SELECT nomB,typeB,nomZ,UPPER(P.nomP),P.prenomP FROM Boutique B, Zone Z, Personnel P WHERE B.IdB=$IdB AND Z.IdZ=B.IdZ AND P.IdB=B.IdB AND P.responsable=1";
            $res=mysqli_query($idcom,$requete);
            $requete1="SELECT COUNT(DateVente),SUM(Prix) FROM Objet WHERE IdB=$IdB AND DateVente IS NOT NULL GROUP BY(IdB)";
            $res1=mysqli_query($idcom,$requete1);
            $requetei="SELECT DISTINCT T.libelleT,O.nomO, O.Prix FROM Objet O, TypeObjet T WHERE O.IdB=$IdB AND O.IdT=T.IdT AND O.DateVente IS NULL";
            $resi=mysqli_query($idcom,$requetei);
            $requetev="SELECT DISTINCT T.libelleT,O.nomO,DATE_FORMAT(O.DateVente,'%Y-%m-%d'),O.Prix FROM Boutique B, Objet O, TypeObjet T WHERE O.IdB=$IdB AND O.IdT=T.IdT AND O.DateVente IS NOT NULL ORDER BY DATE_FORMAT(O.DateVente,'%Y-%m-%d')";
            $resv=mysqli_query($idcom,$requetev);
            $requetep="SELECT P.NumSS,UPPER(P.nomP),P.prenomP FROM Personnel P WHERE P.IdB='$IdB'";
            $resp=mysqli_query($idcom,$requetep);
            if($res){
                $row=mysqli_fetch_array($res);
                echo "<div class='bloc'>";
                echo "<div class='group'> Boutique : ".$row[0]."</div>";
                $nomB=$row[0];
                $typeB=$row[1];
                $nomZ=$row[2];
                $responsable="$row[3] $row[4]";
                if(($res1)){
                    $l=mysqli_num_rows($res1);
                    if($l>0){
                        $row=mysqli_fetch_array($res1);
                        $freq=$row[0];
                        $chaff=$row[1];
                    }
                    else{
                        $freq="Aucune donnée";
                        $chaff="Aucune donnée";
                    }
                }
                echo "<table>";
                echo "<tr><th>Nom Boutique</th><th>Type</th><th>Responsable</th><th>Frequentation totale</th><th>Chiffre d'affaire total</th><th>Zone</th></tr>";
                echo "<tr><td>$nomB</td><td>$typeB</td><td>$responsable</td><td>$freq</td><td>$chaff</td><td>$nomZ</td></tr>"; 
                echo "</table>";
                echo "<div><button onclick=aff('modBou')><span>Renommer</span></button></div>";
                if(($_SESSION['droit']==1)){
                    echo "<div><button onclick=aff('delBou')><span>Supprimer</span></button></div>";
                }
                echo "</div>";
    ?>
        <div class='bloc' id="modBou" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                <?PHP
                    echo "<input type='hidden' name='id' value='$IdB'>";
                    echo "<input type='hidden' name='tb' value='Boutique'>";
                ?>
                Nom de la boutique :
                <input type="text" name="val">
                <input type="submit" name="modify" value="Confirmer">
            </form>
        </div>
    <?php
    if(($_SESSION['droit']==1)){
    ?>
    <div class='bloc' id="delBou" style='display:none;'>
        <form method='POST' action='../Modif/delete.php'>
                <?PHP
                    echo "<input type='hidden' name='id' value='$IdB'>";
                    echo "<input type='hidden' name='tb' value='Boutique'>";
                ?>
            <input type="submit" name="delete" value="Confirmer">
        </form>
    </div>
    <?PHP
    }
            }
            if($resp){
                $l=mysqli_num_rows($resp);
                echo "<div class='bloc'>";
                echo "<div class='group'>Personnel : </div>";
                echo "<table>";
                echo "<tr><th>Numéro de sécurité social</th><th>Nom</th><th>Prénom</th></tr>";
                if($l>0){
                    while($row=mysqli_fetch_array($resp)){
                        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td></tr>";
                    }
                } 
                else{
                    echo "<tr><td>Aucun personnel</td><td>Aucun personnel</td><td>Aucun personnel</td></tr>";
                }
                echo "</table>";
                if(($_SESSION['droit']==1)){
                    echo "<div><button onclick=aff('modBouP')><span>Modifier</span></button></div>";
                    echo "<div><button onclick=aff('delBouP')><span>Supprimer</span></button></div>";
                }
                echo "</div>";
    if(($_SESSION['droit']==1)){
    ?>
        <div class='bloc' id="modBouP" style='display:none;'>
                <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Personnel_Boutique'>";
                    ?>
                    Ajouter un personnel :
                    <?php
                        if($typeB=='Restaurant'||$typeB=='restaurant'){
                             $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.Metier='Serveur' AND P.IdB IS NULL";
                        }
                        else{
                            $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.Metier='Vendeur' AND P.IdB IS NULL";
                        }
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='NumSS'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo " Pas de personnel disponible ";
                            }
                        }
                        
                        
                    ?>
                     <input type="submit" name="addP" value="Ajouter">

                    Changez de responsable :
                    <?PHP
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdB=$IdB AND responsable=0";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='newresp'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo " Aucun employé à nommer responsable ";
                            }
                            
                        }
                    ?>
                    <?PHP 
                        $req1="SELECT P.NumSS FROM Personnel P WHERE P.IdB=$IdB AND responsable=1";
                        $res1=mysqli_query($idcom,$req1);
                        $row1=mysqli_fetch_array($res1);
                        echo "<input type='hidden' name='resp' value='$row1[0]'>";
                    ?>

                    <input type="submit" name="modR" value="Modifier">
                </form>
            </div>
        <div class='bloc' id="delBouP" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Personnel_Boutique'>";
                    ?>
                    Supprimer le personnel :
                    <?PHP
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdB=$IdB AND responsable=0";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='NumSS'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo " Aucun employé à supprimer ";
                            }
                        }
                    ?>
                <input type="submit" name="delete" value="Confirmer">
            </form>
        </div>
        <?PHP
        }
                }
        ?>
            <div class='bloc'>
            <div class='group'>Inventaire : </div>
            <table>
            <?php
            if($resi){
                $l=mysqli_num_rows($resi);
                echo "<tr><th>Type d'objet</th><th>Nom du produit</th></tr>";
                if($l>0){
                    while($row=mysqli_fetch_array($resi)){
                        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
                    }
                } 
                else{
                    echo "<tr><td>Stock vide</td><td>Stock vide</td></tr>";
                }
            ?>
            </table>
                <div><button onclick=aff('addObj')><span>Ajouter</span></button></div>
                <div><button onclick=aff('supObj')><span>Supprimer</span></button></div>
            </div>
        <div class='bloc' id="addObj" style='display:none;'>
            <form method='POST' action='../Modif/insertion.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Objet'>";
                    ?>
                    Type d'objet
                    <select name="IdT">
                    <?PHP
                        if($typeB=="restaurant"||$typeB=="Restaurant"){
                            $req="SELECT IdT,libelleT FROM TypeObjet WHERE libelleT LIKE '%Nourriture%' OR libelleT LIKE '%Boisson%'";
                        }
                        else{
                            $req="SELECT IdT,libelleT FROM TypeObjet";
                        }
                    $res=mysqli_query($idcom,$req);
                    while($row=mysqli_fetch_array($res)){
                            echo "<option value=".$row[0].">".$row[1]."</option>";
                        }
                    ?>
                    <input type="text" name="nomO" placeholder="Nom de l'objet">
                    </select>
                <input type="submit" name="add" value="Ajouter">
            </form>
        </div>
        <div class='bloc' id="supObj" style='display:none;'>
            <form method='POST' action='../Modif/delete.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Objet'>";
                    ?>
                    Supprimer le produit :
                    <?PHP
                        $req="SELECT T.libelleT,O.nomO,O.IdO FROM TypeObjet T, Objet O WHERE O.IdT=T.IdT AND O.IdB=$IdB AND O.DateVente IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='IdP'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[2]'>".$row[0]." - ".$row[1]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de produit à supprimer";
                            }
                        }
                    ?>
                <input type="submit" name="delete" value="Confirmer">
            </form>
        </div>
    <?PHP
        }
            if($resv){
                $l=mysqli_num_rows($resv);
                echo "<div class='bloc'>";
                echo "<div class='group'>Vente : </div>";
                echo "<table>";
                echo "<tr><th>Type d'objet</th><th>Nom de l'objet</th><th>Date de vente</th><th>Prix</th></tr>";
                if($l>0){
                    while($row=mysqli_fetch_array($resv)){
                        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td></tr>";
                    }
                } 
                else{
                    echo "<tr><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td></tr>";
                }
                echo "</table>";
                echo "<div><button onclick=aff('addVen')><span>Ajouter une vente</span></button></div>";
                echo "<div><button onclick=aff('rmvVen')><span>Annuler la vente</span></button></div>";
                echo "</div>";
            
    ?>
        <div class='bloc' id="addVen" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Objet'>";
                    ?>
                    Objet :
                    <?PHP
                        $req="SELECT T.libelleT,O.nomO,O.IdO FROM TypeObjet T, Objet O WHERE O.IdT=T.IdT AND O.IdB=$IdB AND O.DateVente IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='IdP'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[2]'>".$row[0]." - ".$row[1]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas d'objet à vendre";
                            }
                        }
                    ?>
                    <input type="date" name='DateVente' required pattern="\d{2}-\d{2}-\d{4}">
                    <input type="text" name="Prix" placeholder="prix" pattern="[0-9]+" value="0.00">
                <input type="submit" name="add" value="Ajouter">
            </form>
        </div>
        <div class='bloc' id="rmvVen" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdB'>";
                        echo "<input type='hidden' name='tb' value='Objet'>";
                    ?>
                    Annuler la vente :
                    <?PHP
                        $req="SELECT T.libelleT,O.nomO,O.IdO,DATE_FORMAT(O.DateVente,'%Y-%m-%d') FROM TypeObjet T, Objet O WHERE O.IdT=T.IdT AND O.IdB=$IdB AND O.DateVente IS NOT NULL ORDER BY DATE_FORMAT(O.DateVente,'%Y-%m-%d')";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='IdP'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[2]'>".$row[3]." - ".$row[0]." - ".$row[1]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas d'objet vendu";
                            }
                        }
                    ?>
                <input type="submit" name="delete" value="Confirmer">
            </form>
        </div>
    <?PHP 
            }
            mysqli_close($idcom);
        }elseif(isset($_SESSION['metier'])){
            header('Location : ../gestion.php');
        }else{
            echo "Merci de vous connecter <a href='../../index.php'>log in </a>";
        }
    ?> 
</html>