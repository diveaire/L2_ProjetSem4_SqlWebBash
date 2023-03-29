<!DOCTYPE HTML>
<html>
<head>
	<title>SAE</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="Style/styleIndex.css">
</head>
<body>

	<?PHP
	$res=false;
	if (isset($_POST['identifiant']) && isset($_POST['password']) ){

		include("Parametres/connex.inc.php");
		$idcom=connex("myparam");
		if (isset($idcom)){

			$id=$_POST['identifiant'];
			$pass=$_POST['password'];
			$requete="select * from Personnel where NumSS='$id' AND passwd=md5('$pass')";
			$res=mysqli_query($idcom,$requete);

		}else{
			echo "pas de connexion";
		}
	}
	?>
    <div class="bloc">
        <h1>connexion</h1>
        <form method='post' action='index.php'>
            <input class="nom" type="text" placeholder="Identifiant" name="identifiant"><br />
            <input class="pass" type="password" placeholder="Mot de passe" name="password"><br />
            <input class="btn" type="submit" name="submit" value="log in">
        </form>
    

	<?php
	if ($res){
		$rep=mysqli_fetch_array($res);
		if (!empty($rep)){
			$requete="select Metier from Personnel where NumSS='$id'";
			$metier=mysqli_fetch_array(mysqli_query($idcom,$requete));
			session_start();
			$_SESSION['numss']=$id;
			if($metier[1]=="1"){
				$_SESSION['metier']="Chef d'Atelier";
			}
			elseif (($metier[2]=="1")&&($metier[0]=="Serveur")){
				$_SESSION['metier']="Responsable de Restaurant";
			}
			elseif (($metier[2]=="1")&&($metier[0]=="Vendeur")){
				$_SESSION['metier']="Responsable de Boutique";
			}
			else{
				$_SESSION['metier']=$metier[0];
			}
			mysqli_close($idcom);
			header('Location: Menu/accueil.php');
		}else{
			echo "<div class='erreur'>Erreur identifiant ou mot de passe</div>";
		}
	}
	?>
   </div>
</body>
</html>
