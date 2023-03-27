<!DOCTYPE HTML>
<?PHP
session_start();

if (isset($_SESSION['metier'])){
include("connex.inc.php");
$idcom=connex("myparam");
$id=$_SESSION['numss'];
$metier=$_SESSION['metier'];
?>
<html>
<head>
    <title>page de Modification</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="styleProfil.css">
    <script src="script.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>

<div class='bloc'>
	<div class='group'>Recherche</div>
</div>
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
					echo "<tr><td><a href='manegeadm.php?$row[0]'>$row[0]</a></td></tr>";
				}
				echo "</table>";
			}
		?>
	</div>
	<div class='bloc'>
		<div class='group'>Boutique
			<input class='modif' type='submit' name='manege' value='Modifier'>
		</div>
		<?PHP
			$req="SELECT IdB,nomB FROM Boutique";
			$res=mysqli_query($idcom,$req);
			if($res){
				echo "<table border=2px>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='boutiqueadm.php?$row[0]'>$row[1]</a></td></tr>";
				}
				echo "</table>";
			}
		?>
	</div>
	<div class='bloc'>
		<div class='group'>Atelier
			<input class='modif' type='submit' name='manege' value='Modifier'>
		</div>
		<?PHP
			$req="SELECT IdA,nomA FROM Atelier";
			$res=mysqli_query($idcom,$req);
			if($res){
				echo "<table border=2px>";
				while($row=mysqli_fetch_array($res)){
					echo "<tr><td>$row[0]</td><td><a href='atelieradm.php?$row[0]'>$row[1]</a></td></tr>";
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
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>
