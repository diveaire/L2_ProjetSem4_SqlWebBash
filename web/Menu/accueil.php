<!DOCTYPE HTML>
<!--

    Page de Présentation du projet
       -> Calendrier interactif
       -> Texte d'intro
       -> Vidéo de présentation

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
    <link rel="stylesheet" href="../Style/styleAccueil.css">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">
    <script src="../Script/script.js"></script>
    <script src="../Script/calendar.js"></script>
</head>
<body onLoad="Defaults()"><!-- Chargement du calendrier avec la fonction Defaults() -->
<ul id="menu"><!-- barre de navigation du Menu -->
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>
<div class="bloc"> <!-- 1er bloc de données (calendrier) -->
    <div class="group">BIENVENUE</div>
    <div class="group1">
        Nicolas AUVRAY<br /><br />
        &<br /><br />
        Johann THOMAS
    </div>
    <div class="group2">
        <div id=Calendar style="position:relative;width:238px;top:-2px;"></div>
        <div id=NavBar style="position:relative;width:286px;top:5px;"   >
            <form name="when">
                <table>
                    <tr>
                        <td><input type="button" value="<-- Last" onClick="Skip('-')"></td>
                        <td> </td>
                        <td><select name="Mois" onChange="On_Month()">

                                <script>
                                    if (ie4||ns6){
                                        for (let j=0;j<Nom_Mois.length;j++) {
                                            document.writeln('<option value=' + j + '>' + Nom_Mois[j]);
                                        }
                                    }
                                </script>

                            </select>
                        </td>
                        <td><input type="text" name="Annee" size=4 maxlength=4 onKeyUp="On_Year()"></td>
                        <td> </td>
                        <td><input type="button" value="Next -->" onClick="Skip('+')"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="group3">
        <img src="../Fichiers/Images/UPJV.png" alt="Logo de l'UPJV (bleu)" width="200" height="200">
    </div>
</div>
<div class="bloc"><!-- 2ème bloc de données (intro + vidéo) -->
    <div class="group">description du projet</div>
    <div class="group4">
        Dans le contexte de la situation d’apprentissage et d’évaluation du semestre 4 de la licence d’informatique à l’UPJV,
        nous avons dû réaliser un site web permettant l’interrogation, la gestion et l’administration d’une base de données.
        C’est ainsi que nous avons réalisé ce site web dans le cadre de la mise en pratique des connaissances appliquées aux
        modules de Base de Données et de Programmation Web.<br/>
        Ce site web offre tout d’abord un accès à la base de données plus ou moins avancé en fonction de son niveau de privilèges.
        La première fonctionnalité est de pouvoir se connecter, se déconnecter et modifier ses informations personnelles dans la
        section profil. La deuxième fonctionnalité dans la section recherche concerne la possibilité d’interroger la base de
        manière plus ou moins avancée en fonction du statut de l’utilisateur connecté. Enfin il est possible de gérer
        administrativement le parc dans la section gestion administrative en fonction du statut de l’usager. Il y sera alors
        possible d’ajouter, de modifier ou de supprimer certains ateliers, boutiques ou manège à condition d’avoir un niveau d’accès
        approprié.<br/>
        Une démonstration des différentes fonctionnalités vous est proposée dans la vidéo en page d’accueil.
    </div>
    <div class="group5">
        <iframe width="728" height="455" src="https://www.youtube.com/embed/HIGPNJRzBfg" title="Présentation web" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
