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

    <?PHP // Si le formulaire modif a été envoyer, fait les modifications sql
    if (isset($_POST['nom'])){
        $nom=$_POST['nom'];
        $requete="update Personnel SET nomP='$nom'where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<script>showModif();</script>";
        }else{
            echo "essaye encore";
        }
    }
    if (isset($_POST['prénom'])){
        $prenom=$_POST['prénom'];
        $requete="update Personnel SET prenomP='$prenom'where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<script>alert(mise à jour du prénom réussie);</script>";
        }else{
            echo "essaye encore";
        }
    }
    if (isset($_POST['password'])){
        $password=$_POST['password'];
        $requete="update Personnel SET passwd=MD5('$password') where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<alert>mise à jour du mot de passe réussie </alert>";
        }else{
            echo "essaye encore";
        }
    }

    ?>

    <div class="bloc">
        <div class="group"><b>Coordonnées</b></div>
        <div class="group1">
            Nom : <?PHP
                $requete="select nomP, prenomP from Personnel where NumSS='$id'";
                $info=mysqli_fetch_array(mysqli_query($idcom,$requete));
                echo $info[0];
                ?>
            <button onclick=aff("nom")>Modifier</button>
        </div>
        <div class="group2">
            Prenom : <?PHP
                echo $info[1];
                ?>
            <button onclick=aff("prenom")>Modifier</button>
        </div>
        <div class="group3">
            <button onclick=aff("pass")>Modifier Mot de passe</button>
        </div>
        <div id="nom">
            <form method='post' action='profil.php'>
                <input type="text" placeholder="nom" name="nom">
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
        <div id="prenom">
            <form method='post' action='profil.php'>
                <input type="text" placeholder="prénom" name="prénom">
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
        <div id="pass">
            <form method='post' action='profil.php'>
                <input type="password" id="password" placeholder="mot de passe" name="password"><br />
                <input type="password" id="password1" placeholder="confirmer le mot de passe" name="password1">
                <input type="submit" name="submit" onclick=validatePassword() value="valider">
            </form>
        </div>
    </div>
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