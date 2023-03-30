<!DOCTYPE HTML>
<?PHP
session_start();

if (isset($_SESSION['metier'])){
include("../Parametres/connex.inc.php");
$idcom=connex("myparam");
$id=$_SESSION['numss'];
$metier=$_SESSION['metier'];
?>
<html>
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

<!-- FORM CACHER POUR AJOUTER UN MANEGE -->
<div id='ajoutManege' style='display:none;' class='bloc'>
    <div class='group'>AJOUT D'UN MANEGE :</div>
    <form action='Modif/insertion.php' method='POST'>
    <input type='hidden' name='tb' value='Manege'></input>
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
        <input type='hidden' name='tb' value='Boutique'></input>
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
            <select name='resp'>
            <?PHP
                $requete="select NumSS,UPPER(nomP),prenomP,Metier from Personnel where (Metier='Vendeur' OR Metier='Serveur') AND IdB IS NULL";
                $res=mysqli_query($idcom,$requete);
                if ($res){
                    while($row=mysqli_fetch_array($res)){
                        echo "<option value='$row[0]'>$row[3] : $row[1] $row[2]</option>";
                    }
                }else{
                    echo "Problème pour Responsable";
                }
            ?>
            </select>
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
        <input type='hidden' name='tb' value='Atelier'></input>
        <div>Nom de l'atelier <input type='text' name='nomA'></div>
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


<div class='bloc1' >
	<div class='bloc'>
		<div class='group'>Manège
            <button onclick=aff("ajoutManege")><span>Ajouter</span></button>
		</div>
		<?PHP
			$req="SELECT nomM FROM Manege";
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
	<div class='bloc'>
		<div class='group'>Boutique
            <button onclick=aff("ajoutBoutique")><span>Ajouter</span></button>
		</div>
		<?PHP
			$req="SELECT IdB,nomB FROM Boutique";
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
	<div class='bloc'>
		<div class='group'>Atelier
            <button onclick=aff("ajoutAtelier")><span>Ajouter</span></button>
		</div>
		<?PHP
			$req="SELECT IdA,nomA FROM Atelier";
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
</div>



</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='../index.php'>log in </a>";
}
?>
