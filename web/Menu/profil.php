<!DOCTYPE HTML>
<!--
	Page de modification des informations personnelles
	-> Nom
	-> Prénom
	-> Mot de passe
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
    <link rel="stylesheet" href="../Style/styleProfil.css">
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

    <?PHP // Si le formulaire modif a été envoyer, fait les modifications sql
    if (isset($_POST['nom'])){
        $nom=$_POST['nom'];
        $requete="update Personnel SET nomP='$nom'where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<script>alert('mise à jour du nom réussie');</script>";
        }else{
            echo "essaye encore";
        }
    }
    if (isset($_POST['prénom'])){
        $prenom=$_POST['prénom'];
        $requete="update Personnel SET prenomP='$prenom'where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<script>alert('mise à jour du prénom réussie');</script>";
        }else{
            echo "<script>alert('Erreur');</script>";
        }
    }
    if (isset($_POST['password'])){
        $password=$_POST['password'];
        $requete="update Personnel SET passwd=MD5('$password') where NumSS='$id'";
        $ret=mysqli_query($idcom,$requete);
        if ($ret){
            echo "<script>alert('mise à jour du mot de passe réussie');</script>";
        }else{
            echo "<script>alert('Erreur');</script>";
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
            <button onclick=aff("nom")><span>Modifier</span></button><!-- affichage du champ pour modifier le nom -->
        </div>
        <div class="group2">
            Prenom : <?PHP
                echo $info[1];
                ?>
            <button onclick=aff("prenom")><span>Modifier</span></button><!-- affichage du champ pour modifier le prenom -->
        </div>
        <div class="group3">
            <button onclick=aff("pass")><span>Modifier Mot de passe</span></button><!-- affichage du champ pour modifier le password -->
        </div>
        <div id="nom">
            <form method='post' action='profil.php'>
                <input class='petitChamp' type="text" maxlength="32" placeholder="nom" name="nom">
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
        <div id="prenom">
            <form method='post' action='profil.php'>
                <input class='petitChamp' type="text"  maxlength="32" placeholder="prénom" name="prénom">
                <input type="submit" name="submit" value="valider">
            </form>
        </div>
        <div id="pass">
            <form method='post' action='profil.php'>
                <input class='petitChamp' type="password" id="password"  maxlength="32" placeholder="mot de passe" name="password"><br />
                <input class='petitChamp' type="password" id="password1" maxlength="32" placeholder="confirmer le mot de passe" name="password1">
                <input type="submit" name="submit" onclick=validatePassword() value="valider"><!-- vérifie à la validation que les 2 pass correspondent -->
            </form>
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