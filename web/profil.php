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
	<script src="script.js"></script>
</head>
<body>
	 <ul>
	 	<li><a href="accueil.php">Accueil</a></li>
  		<li><a href="profil.php">Profil</a></li>
  		<li><a href="recherche.php">Recherche</a></li>
  		<li><a href="gestion.php">Gestion Administrative</a></li>
  		<li id="logout" ><a href="logout.php">Log out</a></li>
	</ul>
	<hr>
	<div class="bloc">
<?PHP // Si le formulaire modif a été envoyer, fait les modifications sql
if (isset($_POST['nom'])){
	$nom=$_POST['nom'];
	$requete="update Personnel SET nomP='$nom'where NumSS='$id'";
	$ret=mysqli_query($idcom,$requete);
	if ($ret){
		echo "mise à jour du nom réussie<br/>";
	}else{
		echo "essaye encore";
	}
}
if (isset($_POST['prénom'])){
	$prenom=$_POST['prénom'];
	$requete="update Personnel SET prenomP='$prenom'where NumSS='$id'";
	$ret=mysqli_query($idcom,$requete);
	if ($ret){
		echo "mise à jour du prénom réussie <br/>";
	}else{
		echo "essaye encore";
	}
}
if (isset($_POST['password'])&&(isset($_POST['password1']))){
	$password=$_POST['password'];
	$password1=$_POST['password1'];
}


?>
	<h2>Coordonnées</h2>
		<form method='post' action='profil.php'>
		<input type="text" placeholder="nom" name="nom"><br>
		<input type="text" placeholder="prénom" name="prénom"><br>
		<input type="password" id="password" placeholder="mot de passe" name="password"><br>
		<input type="password" id="password1" placeholder="confirmer le mot de passe" name="password1"><br>
		<input type="submit" name="submit" value="Modifier">
	</form>
	</div>
	<hr>
</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>





<!--
	page1--bloc1 	information personnel 	(--ALL)
	page2--bloc2 	Moteur de recherche	(--ALL) -> retour de la recherche = tableau sous forme de lien cliquable
	page3--bloc3	Gestion Administrative (Directeur) -> ajouter/supprimer/modifier(manège/boutique et personnel affiliés) + recherche plus poussée que 2 + 					fonctionnalités --bloc1
	page3--bloc4	Gestion Administrative (CM/responsable Atelier || boutique) -> modification administratif sur leurs cadre de travail (manèges || boutique || atelier)
				pas de modifications sur personnel ; pas de gestions des supervision <--(directeur)
	page3--bloc5	Gestion Administrative (CM) manège en maintenance = CM/directeur
	pagen--bloc6
	-->
