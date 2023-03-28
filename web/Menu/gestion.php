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


<?PHP
    if(!empty($_POST['manege'])){
        echo "<div class='bloc'>";
        echo "<div class='group'>AJOUT D'UN MANEGE :</div>";
        echo "<form action='../insertion.php' method='POST'>";
        echo "<div class='group1'> Nom du Manège <input type='text' name='nomM'></div>";
        echo "Taille Minimale<div class='slider'> <input type='range' min='0' max='200' value='100' name='tailleMin' oninput='rangeValue.innerText = this.value'><p id='rangeValue'>100</p></div>";
        echo "<br>Description <input type='text' name='description'>";
        echo "<br>Famille de manège <select name='libelleF'>";
        $requete="select libelleF from Famille";
        $res=mysqli_query($idcom,$requete);
        if($res){
            while($row=mysqli_fetch_array($res)){
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        }
        else{
            echo "Problème pour Famille";
        }
        echo "</select>";
        echo "<br>Zone du manège <select name='nomZ'>";
        $requete="select nomZ from Zone";
        $res=mysqli_query($idcom,$requete);
        if ($res){
            while($row=mysqli_fetch_array($res)){
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        }
        else{
            echo "Problème pour Zone";
        }
        echo "</select>";
        echo "<br><input type='submit' name='inser' value='Ajouter'>";
        echo "</form>";
        echo "</div>";
    }
    elseif(!empty($_POST['boutique'])){
        echo "<div class='bloc'>";
        echo "<div class='group'>AJOUT D'UNE BOUTIQUE :</div>";
        echo "<br><form action='../insertion.php' method='POST'>";
        echo "<br>Nom de la boutique <input type='text' name='nomB'>";
        echo "<br>Type de la boutique<input type='text' name='typeB'>";
        echo "<br>Zone de la boutique <select name='nomZ'>";
        $requete="select nomZ from Zone";
        $res=mysqli_query($idcom,$requete);
        if ($res){
            while($row=mysqli_fetch_array($res)){
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        }
        else{
            echo "Problème pour Zone";
        }
        echo "</select>";
        echo "<br><input type='submit' name='inser' value='Ajouter'>";
        echo "</form>";
        echo "</div>";
    }
    elseif(!empty($_POST['atelier'])){
        echo "<div class='bloc'>";
        echo "<div class='group'>AJOUT D'UN ATELIER :</div>";
        echo "<form action='../insertion.php' method='POST'>";
        echo "<br>Nom de l'atelier <input type='text' name='nomA'>";
        echo "<br>Zone de l'atelier <select name='nomZ'>";
        $requete="select nomZ from Zone";
        $res=mysqli_query($idcom,$requete);
        if ($res){
            while($row=mysqli_fetch_array($res)){
                echo "<option value='$row[0]'>$row[0]</option>";
            }
        }
        else{
            echo "Problème pour Zone";
        }
        echo "</select>";
        echo "<br><input type='submit' name='inser' value='Ajouter'>";
        echo "</form>";
        echo "</div>";
    }
?>




<div class='bloc'>
	<form action='gestion.php' method='POST'>
	<div class='bloc'>
		<div class='group'>Manège
			<input class='modif' type='submit' name='manege' value='Modifier'>
		</div>
		<?PHP
			$req="SELECT nomM FROM Manege";
			$res=mysqli_query($idcom,$req);
			if($res){
				echo "<table border=2px>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td><a href='manegeadm.php?NomM=$row[0]'>$row[0]</a></td></tr>";
				}
				echo "</table>";
			}
		?>
	</div>
	<div class='bloc'>
		<div class='group'>Boutique
			<input class='modif' type='submit' name='boutique' value='Modifier'>
		</div>
		<?PHP
			$req="SELECT IdB,nomB FROM Boutique";
			$res=mysqli_query($idcom,$req);
			if($res){
				echo "<table border=2px>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='boutiqueadm.php?IdB=$row[0]'>$row[1]</a></td></tr>";
				}
				echo "</table>";
			}
		?>
	</div>
	<div class='bloc'>
		<div class='group'>Atelier
			<input class='modif' type='submit' name='atelier' value='Modifier'>
		</div>
		<?PHP
			$req="SELECT IdA,nomA FROM Atelier";
			$res=mysqli_query($idcom,$req);
			if($res){
				echo "<table border=2px>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='atelieradm.php?IdA=$row[0]'>$row[1]</a></td></tr>";
				}
				echo "</table>";
			}
		?>
	</div>
	</form>
</div>



</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='../index.php'>log in </a>";
}
?>
