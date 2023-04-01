<!DOCTYPE HTML>
<!--
    Page de Gestion Administrative
    -> Gestion des manèges (Directeur + CM)
    -> Gestion des Boutique (Directeur +Responsable Boutique)
    -> Gestion des Ateliers (Directeur + Chef Atelier)
    -> Les CM/CHEF/RESPONSABLES On uniquement accès aux MANEGE/ATELIER/BOUTIQUE dont-il s'occupent
-->
<?PHP
session_start();
if (isset($_SESSION['metier'])){
    include("../Parametres/connex.inc.php");
    $idcom=connex("myparam");
    $id=$_SESSION['numss'];
    $metier=$_SESSION['metier'];
?>
<html lang="fr">
<head>
    <title>page de Modification</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../Style/menu.css">
    <link rel="stylesheet" href="../Style/styleGestion.css">
    <script src="../Script/script.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>

<?PHP
    if($_SESSION['droit']>0){
        if($_SESSION['droit']==1){
        
?>

<!-- FORM CACHER POUR AJOUTER UN MANEGE -->
<div id='ajoutManege' style='display:none;'>
    <form action='Modif/insertion.php' method='POST'>
    <div class="bloc">
        <div class='group'>AJOUT D'UN MANEGE :</div>
        <input type='hidden' name='tb' value='Manege'>
        <div class='group1'>
            <fieldset><legend>Nom du Manège : </legend><input class='petitChamp' type='text' name='nomM'><br /></fieldset>
            <fieldset><legend>Taille Minimale :</legend><div class='slider'><input type='range' min='0' max='200' value='100' name='tailleMin' oninput='rangeValue.innerText = this.value'><p id='rangeValue'>100</p></div></fieldset>
        </div>
        <div class="group2">
            <fieldset><legend>Description </legend><input class='petitChamp' type='text' name='description'></fieldset>
            <fieldset>
                <legend>Famille de manège </legend>
                <select name='libelleF'>
            <?PHP
               $requete="select libelleF from Famille";
               $res=mysqli_query($idcom,$requete);
               if($res){
                    while($row=mysqli_fetch_array($res)){
                        echo "<option value='$row[0]'>$row[0]</option>";
                    }
                }else{
                   echo "Problème pour Famille";
                }
            ?>
                </select>
            </fieldset>
        </div>
        <div class="group3">
            <fieldset>
                <legend>Zone du manège </legend>
                <select name='nomZ'>
                <?PHP
                    $requete="select nomZ from Zone";
                    $res=mysqli_query($idcom,$requete);
                    if ($res){
                        while($row=mysqli_fetch_array($res)){
                            echo "<option value='$row[0]'>$row[0]</option>";
                        }
                    }else{
                        echo "Problème pour Zone";
                    }
                ?>
                </select>
            </fieldset>
        </div>
        
        <div><input type='submit' name='inser' value='Ajouter'></div>
    </form>
    </div>
</div>
<!-- FORM CACHER POUR AJOUTER UNE BOUTIQUE -->

<div id='ajoutBoutique' style='display:none;'>
    <form action='Modif/insertion.php' method='POST'>
    <div class="bloc">
        <div class='group'>AJOUT D'UNE BOUTIQUE :</div>
        <input type='hidden' name='tb' value='Boutique'>
        <div class="group1">
            <fieldset><legend>Nom de la boutique </legend><input type='text' class='petitChamp' name='nomB'></fieldset>
            <fieldset><legend>Type de la boutique</legend>
                <select name='typeB'>
                <?PHP
                    $requete="select distinct typeB from Boutique ";
                    $res=mysqli_query($idcom,$requete);
                    if ($res){
                        while($row=mysqli_fetch_array($res)){
                            echo "<option value='$row[0]'>$row[0]</option>";
                        }
                    }else{
                        echo "Problème pour typeB";
                    }
                ?>
                </select>
            </fieldset>
        </div>
        <div class="group2">
            <fieldset>
                <legend>Responsable</legend>
                <?PHP
                    $requete="select NumSS,UPPER(nomP),prenomP,Metier from Personnel where (Metier='Vendeur' OR Metier='Serveur') AND IdB IS NULL";
                    $res=mysqli_query($idcom,$requete);
                    if ($res){
                        $l=mysqli_num_rows($res);
                        if($l>0){
                            echo "<select name='resp'>";
                            while($row=mysqli_fetch_array($res)){
                                echo "<option value='$row[0]'>$row[3] : $row[1] $row[2]</option>";
                            }
                            echo "</select>";
                            }
                        else{
                                echo "Aucun Responsable disponible";
                            }
                    }
                ?>
            </fieldset>
        </div>
        <div class="group3">
            <fieldset>
                <legend>Zone de la boutique</legend>
                <select name='nomZ'>
                <?PHP
                    $requete="select nomZ from Zone";
                    $res=mysqli_query($idcom,$requete);
                    if ($res){
                        while($row=mysqli_fetch_array($res)){
                            echo "<option value='$row[0]'>$row[0]</option>";
                        }
                    }else{
                        echo "Problème pour Zone";
                    }
                ?>
                </select>
            </fieldset>
        </div>
        <div><input type='submit' name='inser' value='Ajouter'></div>
    </form>
    </div>
</div>
<!-- FORM CACHER POUR AJOUTER UN ATELIER -->
<div id='ajoutAtelier' style='display:none;'>
    <form action='Modif/insertion.php' method='POST'>
    <div class="bloc">
    <div class='group'>AJOUT D'UN ATELIER :</div>
        <input type='hidden' name='tb' value='Atelier'>
        <div class="group1">
            <fieldset><legend>Nom de l'atelier </legend><input class='petitChamp' type='text' name='nomA'></fieldset>
        </div>
        <div class="group2">
            <fieldset><legend>Chef</legend>
                <?PHP
                    $requete="select NumSS,UPPER(nomP),prenomP from Personnel where Metier='Technicien' AND IdA IS NULL";
                    $res=mysqli_query($idcom,$requete);
                    if($res){
                        $l=mysqli_num_rows($res);
                        if($l>0){
                            echo "<select name='chef'>";
                            while($row=mysqli_fetch_array($res)){
                                echo "<option value='$row[0]'>$row[1] $row[2]</option>";
                            }
                            echo "</select>";
                        }
                        else{
                            echo ": Aucun technicien disponible";
                        }
                    }
                ?>
                </select>
            </fieldset>
        </div>
        <div class="group3">
            <fieldset>
                <legend>Zone de l'atelier </legend>
                <select name='nomZ'>
                <?PHP
                    $requete="select nomZ from Zone";
                    $res=mysqli_query($idcom,$requete);
                    if ($res){
                        while($row=mysqli_fetch_array($res)){
                            echo "<option value='$row[0]'>$row[0]</option>";
                        }
                    }else{
                        echo "Problème pour Zone";
                    }
                ?>
                </select>
            </fieldset>
        </div>
        <div><input type='submit' name='inser' value='Ajouter'></div>
    </form>
    </div>
</div>

<?PHP
            }
?>

<?php if(($_SESSION['droit']==1)||$_SESSION['droit']==2){
?>
<div class='bloc1' >
	<div class='bloc'>
		<div class='group'>Manège
            <?PHP if($_SESSION['droit']==1){
            ?>
                <button onclick=aff("ajoutManege")><span>Ajouter</span></button>
            <?PHP
            }?>
		</div>
		<?PHP
            if($_SESSION['droit']==1){
                $req="SELECT nomM FROM Manege";    
            }
            else{
                $req="SELECT B.nomM FROM Bilan B, Personnel P WHERE P.NumSS='".$_SESSION['numss']."' AND P.NumSS=B.NumSS AND DateB>=(SELECT MAX(B1.DateB) FROM Bilan B1 WHERE B1.nomM=B.nomM)";
            }
			$res=mysqli_query($idcom,$req);
			if($res){
                echo "<div class='group1b'>";
				echo "<table>";
                echo "<tr><th>Nom Manege</th>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td><a href='AdminModif/manegeadm.php?NomM=$row[0]'>$row[0]</a></td></tr>";
				}
				echo "</table>";
                echo "</div>";
			}
		?>
	</div>
<?php
}if(($_SESSION['droit']==1)||($_SESSION['droit']==3)||($_SESSION['droit']==4)){
?>
	<div class='bloc'>
		<div class='group'>Boutique
            <?PHP if($_SESSION['droit']==1){
            ?>
                <button onclick=aff("ajoutBoutique")><span>Ajouter</span></button>
            <?PHP
            }?>
		</div>
		<?PHP
            if($_SESSION['droit']==1){
                $req="SELECT IdB,nomB FROM Boutique";   
            }
            else{
                $req="SELECT B.IdB,B.nomB FROM Boutique B, Personnel P WHERE B.IdB=P.IdB AND P.NumSS='".$_SESSION['numss']."'";
            }
			
			$res=mysqli_query($idcom,$req);
			if($res){
                echo "<div class='group1b'>";
				echo "<table>";
                echo "<tr><th>Id Boutique</th><th>Nom Boutique</th>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='AdminModif/boutiqueadm.php?IdB=$row[0]'>$row[1]</a></td></tr>";
				}
				echo "</table>";
                echo "</div>";
			}
		?>
	</div>
<?php
}if(($_SESSION['droit']==1)||($_SESSION['droit']==5)){
?>
	<div class='bloc'>
		<div class='group'>Atelier
            <?PHP if($_SESSION['droit']==1){
            ?>
                <button onclick=aff("ajoutAtelier")><span>Ajouter</span></button>
            <?PHP
            }?>
		</div>
		<?PHP
            if($_SESSION['droit']==1){
                $req="SELECT IdA,nomA FROM Atelier"; 
            }
            else{
                $req="SELECT A.IdA,A.nomA FROM Atelier A, Personnel P WHERE A.IdA=P.IdA AND P.NumSS='".$_SESSION['numss']."'"; 
            }
			$res=mysqli_query($idcom,$req);
			if($res){
                echo "<div class='group1b'>";
				echo "<table>";
                echo "<tr><th>Id Atelier</th><th>Nom Atelier</th>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='AdminModif/atelieradm.php?IdA=$row[0]'>$row[1]</a></td></tr>";
				}
				echo "</table>";
                echo "</div>";
			}
		?>
	</div>
<?php
}
?>
</div>



</body>
</html>
<?PHP
}
    else
    {
        echo "Vous n'êtes pas autorisé à consulter cette partie du site";
    }   
    mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='../index.php'>log in </a>";
}
?>
