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
    <link rel="stylesheet" href="styleAccueil.css">
    <script src="script.js"></script>
    <script src="calendar.js"></script>
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
</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>
