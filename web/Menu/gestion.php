<!DOCTYPE HTML>
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
<div id='ajoutManege' style='display:none;' class='bloc'>
    <div class='group'>AJOUT D'UN MANEGE :</div>
    <form action='Modif/insertion.php' method='POST'>
    <input type='hidden' name='tb' value='Manege'>
        <div class='group1'>
            Nom du Manège <input type='text' name='nomM'>
            Taille Minimale<div class='slider'><input type='range' min='0' max='200' value='100' name='tailleMin' oninput='rangeValue.innerText = this.value'><p id='rangeValue'>100</p></div>
        </div>
        <div>Description <input type='text' name='description'>
            <br />Famille de manège <select name='libelleF'>
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
        </div>
        <div>Zone du manège <select name='nomZ'>
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
        </div>
        
        <div><input type='submit' name='inser' value='Ajouter'></div>
    </form>
</div>

<div id='ajoutBoutique' style='display:none;' class='bloc'>
    <div class='group'>AJOUT D'UNE BOUTIQUE :</div>
        <form action='Modif/insertion.php' method='POST'>
        <input type='hidden' name='tb' value='Boutique'>
        <div>Nom de la boutique <input type='text' name='nomB'><br /></div>
        <div>
            Type de la boutique
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
        </div>
        <div>Responsable
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
        </div>
        <div>Zone de la boutique
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
        </div>
        <div class="groupX"><input type='submit' name='inser' value='Ajouter'></div>
    </form>
</div>

<div id='ajoutAtelier' style='display:none;' class='bloc'>
    <div class='group'>AJOUT D'UN ATELIER :</div>
    <form action='Modif/insertion.php' method='POST'>
        <input type='hidden' name='tb' value='Atelier'>
        <div>Nom de l'atelier <input type='text' name='nomA'></div>
        <div>Chef
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
        </div>
        <div>Zone de l'atelier <select name='nomZ'>
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
        </div>
        <div class="groupX"><input type='submit' name='inser' value='Ajouter'></div>
    </form>
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
                echo "<div class='group1'>";
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
                echo "<div class='group1'>";
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
                echo "<div class='group1'>";
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
