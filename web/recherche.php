<!DOCTYPE HTML>
<?PHP
session_start();

if (isset($_SESSION['metier'])){
	include("connex.inc.php");
	include("myparam.inc.php");
	$idcom=connex(MYBASE,"myparam");
	$id=$_SESSION['numss'];
	$metier=$_SESSION['metier'];
	if(empty($_POST['mb'])||$_POST['mb']=="Manege"){
		$_SESSION['recherche']='Manege';
	}
	elseif($_POST['mb']=="Boutique"){
		$_SESSION['recherche']='Boutique';
	}
?>
<html>
<head>
	<title>page de Modification</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="styleMain.css">
</head>
<body>
	 <ul>
	 	<li><a href="accueil.php">Accueil</a></li>
  		<li><a href="profil.php">Profil</a></li>
  		<li><a href="recherche.php">Recherche</a></li>
  		<li><a href="gestion.php">Gestion Administrative</a></li>
  		<li id="logout" ><a href="logout.php">Log out</a></li>
	</ul>

	<h2>Entrez les informations de votre recherche</h2>
		<form method='post' action='recherche.php'>
		<input type="submit" name='mb' value='Manege'>
		<input type="submit" name='mb' value='Boutique'><br>
		<input type="text" placeholder="Recherche" name="Nom">
		<?PHP
			if($_SESSION['recherche']=='Manege'){
				echo "<input type='text' placeholder='Taille' name='Taille'>";
				$requetef="select libelleF from Famille";
				$resf=mysqli_query($idcom,$requetef);
					if ($resf){
						echo "<select name='Famille' id='Famille'>";
						echo "<option value='nonef'>Toutes</option>";
						while($row=mysqli_fetch_array($resf)){
							echo "<option value=".$row[0]."'>".$row[0]."</option>";
						}
						echo "</select>";
					}
					else{
						echo "Problème pour Famille";
					}
			}
			else{
				$requetet="select distinct typeB from Boutique";
				$rest=mysqli_query($idcom,$requetet);
					if ($rest){
						echo "<select name='Famille' id='Famille'>";
						echo "<option value='nonef'>Toutes</option>";
						while($row=mysqli_fetch_array($rest)){
							echo "<option value=".$row[0]."'>".$row[0]."</option>";
						}
						echo "</select>";
					}
					else{
						echo "Problème pour Famille";
					}
			}
			$requetez="select nomZ from Zone";
			$resz=mysqli_query($idcom,$requetez);
			if ($resz){
				echo "<select name='Zone' id='Zone'>";
				echo "<option value='nonez'>Toutes</option>";
				while($row=mysqli_fetch_array($resz)){
					echo "<option value=".$row[0]."'>".$row[0]."</option>";
				}
				echo "</select>";
			}
			else{
				echo "Problème pour Zone";
			}
		?>
		<br><input type="submit" name='submit' value="Rechercher">
	</form>

</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>
