<!DOCTYPE HTML>
<?PHP
session_start();

if (isset($_SESSION['metier'])){
	include("connex.inc.php");
	$idcom=connex("nicolasauvray","myparam");
	$id=$_SESSION['numss'];
	$metier=$_SESSION['metier'];

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

</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>
