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
    <link rel="stylesheet" href="../Style/styleAccueil.css">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">
    <script src="../Script/script.js"></script>
    <script src="../Script/calendar.js"></script>
</head>
<body onLoad="Defaults()">
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>
<div class="bloc">
    <div class="group">BIENVENUE</div>
    <div class="group1">
        Nicolas AUVRAY<br /><br />
        &<br /><br />
        Johann THOMAS
    </div>
    <div class="group2">
        <div id=Calendar style="position:relative;width:238px;top:-2px;" align="left"></div>
        <div id=NavBar style="position:relative;width:286px;top:5px;" align="left">
            <form name="when">
                <table>
                    <tr>
                        <td><input type="button" value="<-- Last" onClick="Skip('-')"></td>
                        <td> </td>
                        <td><select name="Mois" onChange="On_Month()">

                                <script language="JavaScript1.2">
                                    if (ie4||ns6){
                                        for (j=0;j<Nom_Mois.length;j++) {
                                            document.writeln('<option value=' + j + '>' + Nom_Mois[j]);
                                        }
                                    }
                                </script>

                            </select>
                        </td>
                        <td><input type="text" name="Annee" size=4 maxlength=4 onKeyPress="return Check_Nums()" onKeyUp="On_Year()"></td>
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
<div class="bloc">
    <div class="group">description du projet</div>
    <div class="group4">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus sapien nec arcu vehicula ullamcorper.
        Mauris augue leo, lobortis at est ut, tempus tempor tellus. Nullam tempor mollis lectus, eu ultricies
        libero tincidunt eget. Nulla gravida elit eu iaculis lobortis. Morbi ac quam eget dolor tristique
        Vivamus ac mi sed felis viverra pretium a a metus. Nullam neque odio, commodo a tempor non, mattis nec diam.
        Sed a hendrerit felis, vitae tempus nisi. Vestibulum vulputate gravida nisl consectetur finibus. Fusce
        gravida massa sit amet metus volutpat, id pellentesque neque ornare. Sed eleifend consectetur mauris nec
        ultricies. Nulla vehicula, neque et efficitur tincidunt, velit nibh imperdiet ex, eget interdum leo massa.
    </div>
    <div class="group5">
        <video controls >
            <source width="50" src="../Fichiers/Video/video.mp4" type="video/mp4">
            Download the
            <a href="../Fichiers/Video/video.mp4">MP4</a>
            video.
        </video>

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
