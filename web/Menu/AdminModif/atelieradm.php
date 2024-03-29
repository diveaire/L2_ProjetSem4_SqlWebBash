<!DOCTYPE HTML>
<?PHP
    session_start();
    /*Ouverture de la session et vérification qu'il s'agit bien d'un membre du personnel qui s'est connecté*/
    if (isset($_SESSION['metier'])){
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        /*Récupération des variables*/
        $id=$_SESSION['numss'];
        $metier=$_SESSION['metier'];
        $IdA=$_GET['IdA'];
        /*Vérification que la personne connectée est bien en charge de l'Atelier*/
        if($_SESSION['droit']==5){
            $req="SELECT IdA FROM Personnel WHERE NumSS='$id'";
            $res=mysqli_query($idcom,$req);
            if($res){
                $val=false;
                while($row=mysqli_fetch_array($res)){
                    if($row[0]==$IdA){
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
/*Mise en place de toute les requètes de la base de donnée*/
if($val&&(($_SESSION['droit']==1)||($_SESSION['droit']==5))){
    /* Requete concernant les informations de l'atelier et son responsable */
    $requete="SELECT nomA,nomZ,UPPER(P.nomP),prenomP FROM Atelier A, Zone Z, Personnel P WHERE A.IdA=$IdA AND Z.IdZ=A.IdZ AND P.IdA=A.IdA AND chef=1";
    $res=mysqli_query($idcom,$requete);
    /* Requete concernant les personnels de l'atelier*/
    $requetep="SELECT P.NumSS,UPPER(P.nomP),P.prenomP FROM Personnel P WHERE IdA=$IdA";
    $resp=mysqli_query($idcom,$requetep);
    /* Requete concernant les maintenances de l'atelier */
    $requetem="SELECT E.IdM,DATE_FORMAT(M.DateDeb,'%d/%m/%Y'),DATE_FORMAT(M.DateFin,'%d/%m/%Y'),COUNT(E.NumSS),M.nomM FROM Maintenance M, Equipe E WHERE E.IdM=M.IdM AND E.NumSS IN(SELECT P.NumSS FROM Personnel P WHERE P.IdA=$IdA)GROUP BY (E.IdM)";
    $resm=mysqli_query($idcom,$requetem);
    /* Requete concernant l'inventaire de l'atelier */
    $requetei="SELECT NumSerie,nomPC FROM PiecesDetachees WHERE IdA='$IdA' AND IdM IS NULL";
    $resi=mysqli_query($idcom,$requetei);
    /* Requete concernant les pièces de l'atelier qui ont été livrées*/
    $requetef="SELECT P.NumSerie,P.nomPC,M.nomM FROM PiecesDetachees P, Maintenance M WHERE IdA='$IdA' AND P.IdM IS NOT NULL AND P.IdM=M.IdM";
    $resf=mysqli_query($idcom,$requetef);
    /*Si la requete des informations a aboutie on affiche les données dans un tableau*/
    if($res){
        $row=mysqli_fetch_array($res);
        echo "<div class='bloc'>";
        echo "<div class='group'> Atelier : ".$row[0]."</div>";
        $nomA=$row[0];
        $nomZ=$row[1];
        $chef="$row[2] $row[3]";
        echo "<table>";
        echo "<tr><th>Nom Atelier</th><th>Chef</th><th>Zone</th></tr>";
        echo "<tr><td>$nomA</td><td>$chef</td><td>$nomZ</td></tr>"; 
        echo "</table>";
        echo "<div><button onclick=aff('modAte')><span>Renommer</span></button></div>";
        if($_SESSION['droit']==1){
            echo "<div><button onclick=aff('delAte')><span>Supprimer</span></button></div>";
        }
        echo "</div>";
    }
?>
<!-- Section permettant d'afficher les formulaires de modification générales sur l'atelier-->
    <div class='bloc' id="modAte" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                <?PHP
                    echo "<input type='hidden' name='id' value='$IdA'>";
                    echo "<input type='hidden' name='tb' value='Atelier'>";
                ?>
                Nom de l'Atelier :
                <input class='petitChamp' type="text" name="val">
                <input type="submit" name="modify" value="Confirmer">
            </form>
        </div>
<?PHP
if($_SESSION['droit']==1){
?>
    <div class='bloc' id="delAte" style='display:none;'>
        <form method='POST' action='../Modif/delete.php'>
                <?PHP
                    echo "<input type='hidden' name='id' value='$IdA'>";
                    echo "<input type='hidden' name='tb' value='Atelier'>";
                ?>
            <input type="submit" name="delete" value="Confirmer">
        </form>
    </div>
<?PHP
}
?>
<?php
 /* Récupération des personnel et affichage de ceux-ci dans un tableau*/
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
        if($_SESSION['droit']==1){
            echo "<div><button onclick=aff('modAteP')><span>Modifier</span></button></div>";
            echo "<div><button onclick=aff('delAteP')><span>Supprimer</span></button></div>";
        }
        echo "</div>";
            
    ?>
<?PHP
    if($_SESSION['droit']==1){
?>
<!-- Section permettant d'afficher les formulaires de modification des personnels, accessible uniquement par le directeur-->
        <div class='bloc' id="modAteP" style='display:none;'>
                <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Personnel_Atelier'>";
                    ?>
                    Ajouter un personnel :
                    
                    <?php
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.Metier='Technicien' AND P.IdA IS NULL";
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
                                echo "Pas de personnel disponible";
                            }
                        }
                    ?>
                     <input type="submit" name="addP" value="Ajouter">

                    Changez de Chef :
                    <?PHP
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdA=$IdA AND chef=0";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='newchef'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value=".$row[0].">".$row[1]." ".$row[2]." N° : ".$row[0]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de personnel disponible";
                            }
                        }
                    ?>
                    <?PHP 
                        $req1="SELECT P.NumSS FROM Personnel P WHERE P.IdA=$IdA AND chef=1";
                        $res1=mysqli_query($idcom,$req1);
                        $row1=mysqli_fetch_array($res1);
                        echo "<input type='hidden' name='chef' value='$row1[0]'>";
                    ?>

                    <input type="submit" name="modC" value="Modifier">
                </form>
            </div>
        <div class='bloc' id="delAteP" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Personnel_Atelier'>";
                    ?>
                    Supprimer le personnel :
                    <?PHP
                        $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdA=$IdA AND chef=0";
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
                                echo "Pas de personnel disponible";
                            }
                        }
                    ?>
                <input type="submit" name="delete" value="Confirmer">
            </form>
        </div>
<?PHP
}
?>
    <?php
    }
    /* Récupération des maintenances concernant cet atelier et affichage de ceux-ci dans un tableau*/
    if($resm){
        echo "<div class='bloc'>";
        echo "<div class='group'>Maintenances : </div>";
        echo "<table>";
        echo "<tr><th>Nom du manège</th><th>Date de début</th><th>Date de fin</th><th>Nombre de personnel</th></tr>";
        $l=mysqli_num_rows($resm);
        if($l>0){
            while($row=mysqli_fetch_array($resm)){
                $IdM=$row[0];
                $DateB=$row[1];
                $DateF=$row[2];
                $NbP=$row[3];
                $NomM=$row[4];
                echo "<tr><td>$NomM</td><td>$DateB</td><td>$DateF</td><td>$NbP</td></tr>"; 
            }
        }
        else{
            echo "<tr><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td><td>Aucune donnée</td></tr>"; 
        }
        echo "</table>";
        echo "<div><button onclick=aff('endMai')><span>Fin de la maintenance</span></button></div>";    
        echo "</div>";
?>
<!-- Section permettant de mettre fin à une maintenance, la fin de la maintenance sera actée le jour où le responsable clique sur le bouton Mettre fin à la maintenance-->
        <div class='bloc' id="endMai" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                        <?PHP
                        echo "<input type='hidden' name='tb' value='Maintenance'>";
                        $req="SELECT M.IdM,DATE_FORMAT(M.DateDeb,'%d/%m/%Y'),M.nomM FROM Maintenance M WHERE DateFin IS NULL AND EXISTS(SELECT P.NumSS FROM Personnel P, Equipe E WHERE E.IdM=M.IdM AND P.NumSS=E.NumSS AND P.IdA=$IdA)";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='id'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[0]'> $row[2] : $row[1]</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de maintenance en cours";
                            }
                        }
                        ?>
                        <input type="submit" name="End" value="Confirmer">
            </form>
        </div>

        
    <?php
    }
    /* Récupération des pièces de l'inventaire de cet atelier et affichage de ceux-ci dans un tableau*/
    if($resi){
        $l=mysqli_num_rows($resi);
        echo "<div class='bloc'>";
        echo "<div class='group'>Inventaire : </div>";
        echo "<table>";
        echo "<tr><th>Numéro de série</th><th>Nom de la pièce</th></tr>";
        if($l>0){
            while($row=mysqli_fetch_array($resi)){
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
            }
        } 
        else{
            echo "<tr><td>Aucune pièce</td><td>Aucune pièce</td></tr>";
        }
        echo "</table>";
        echo "<div><button onclick=aff('addPie')><span>Ajouter une pièce</span></button></div>";
        echo "<div><button onclick=aff('rmvPie')><span>Retirer une pièce</span></button></div>";
        echo "</div>";
    ?>

 <!-- Section permettant d'afficher les outils d'ajout et de suppression d'une pièce-->
 <div class='bloc' id="addPie" style='display:none;'>
            <form method='POST' action='../Modif/insertion.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Piece'>";
                    ?>
                        N° Série : <input class='petitChamp' type="text" name="NumSerie" pattern="[0-9]{8}" minlength="8" maxlength="8" placeholder="(8 chiffres)">
                        Nom : <input class='petitChamp' type="text" maxlength="32" name="nomPC" >
                <input type="submit" name="add" value="Ajouter">
            </form>
        </div>
        <div class='bloc' id="rmvPie" style='display:none;'>
            <form method='POST' action='../Modif/delete.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Piece'>";
                    ?>
                    Pièce :
                    <?PHP
                        $req="SELECT NumSerie,nomPC FROM PiecesDetachees WHERE IdA='$IdA' AND IdM IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='NumSerie'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[0]'>".$row[0]." - ".$row[1]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de pièces dans l'inventaire";
                            }
                        }
                    ?>
                        
                <input type="submit" name="add" value="Supprimer">
            </form>
        </div>

    <?PHP
    }
    /* Récupération des résultats concernant les pièces fournies et affichage de celle-ci dans un tableau */
    if($resf){
        $l=mysqli_num_rows($resf);
        echo "<div class='bloc'>";
        echo "<div class='group'>Pièces fournies : </div>";
        echo "<table>";
        echo "<tr><th>Numéro de série</th><th>Nom de la pièce</th><th>Nom du manège</th></tr>";
        if($l>0){
            while($row=mysqli_fetch_array($resf)){
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td></tr>";
            }
        } 
        else{
            echo "<tr><td>Aucune pièce</td><td>Aucune pièce</td><td>Aucune pièce</td></tr>";
        }
        echo "</table>";
        echo "<div><button onclick=aff('furPie')><span>Fournir une pièce</span></button></div>";
        echo "<div><button onclick=aff('delPie')><span>Annuler la livraison</span></button></div>";
        echo "</div>";
        ?>
        <!-- Section permettant d'afficher les outils d'ajout et de suppression d'une pièce à une maintenance en cours-->
        <div class='bloc' id="furPie" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Piece'>";
                    ?>
                    Pièce : 
                    <?PHP
                        $req="SELECT NumSerie,nomPC FROM PiecesDetachees WHERE IdA='$IdA' AND IdM IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='NumSerie'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[0]'>".$row[0]." - ".$row[1]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de pièces dans l'inventaire";
                            }
                        }
                    echo " Maintenance : ";
                        $req="SELECT M.IdM,M.nomM,DATE_FORMAT(M.DateDeb,'%d/%m/%Y') FROM Maintenance M WHERE M.DateFin IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='IdM'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[0]'>".$row[1]." - ".$row[2]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de maintenance en cours";
                            }
                        }
                    ?>
                <input type="submit" name="send" value="Envoyer">
            </form>
        </div>
        <div class='bloc' id="delPie" style='display:none;'>
            <form method='POST' action='../Modif/modify.php'>
                    <?PHP
                        echo "<input type='hidden' name='id' value='$IdA'>";
                        echo "<input type='hidden' name='tb' value='Piece'>";
                    ?>
                    Pièce :
                    <?PHP
                        $req="SELECT M.nomM,NumSerie,nomPC FROM PiecesDetachees P, Maintenance M WHERE P.IdA=$IdA AND P.IdM=M.IdM AND M.DateFin IS NULL";
                        $res=mysqli_query($idcom,$req);
                        if($res){
                            $l=mysqli_num_rows($res);
                            if($l>0){
                                echo "<select name='Fournie'>";
                                while($row=mysqli_fetch_array($res)){
                                    echo "<option value='$row[1]'>".$row[0]." : ".$row[1]." - ".$row[2]."</option>";
                                }
                                echo "</select>";
                            }
                            else{
                                echo "Pas de pièces récupérables";
                            }
                        }
                    ?>
                        
                <input type="submit" name="add" value="Supprimer">
            </form>
        </div>
        <?PHP
        
    }

        mysqli_close($idcom);
    }
    elseif(isset($_SESSION['metier'])){
        mysqli_close($idcom);
        header ('Location : ../gestion.php');
    }
    else{
        echo "Merci de vous connecter <a href='../../index.php'>log in </a>";
    }
?>


</html>