<!DOCTYPE HTML>
<?PHP
session_start();

if (isset($_SESSION['metier'])){
    include("../Parametres/connex.inc.php");
    $idcom=connex("myparam");
    $id=$_SESSION['numss'];
    $metier=$_SESSION['metier'];
    $choix="";
    if (isset($_POST['mb'])){
        $choix=$_POST['mb'];
    }
    if(empty($_SESSION['recherche'])||$choix=="Manege"){
        $_SESSION['recherche']='Manege';
    }
    elseif($choix=="Boutique"){
        $_SESSION['recherche']='Boutique';
    }
?>
<html lang="fr">
<head>
    <title>Recherche</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../Style/menu.css">
    <link rel="stylesheet" href="../Style/styleRecherche.css">
    <script src="Script/script.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>
    <form method='post' action='recherche.php'>
        <div class="bloc">
            <div class="group">
                Entrez les informations de votre recherche
            </div>
            <div class="group1">
                <input type="submit" name='mb' value='Manege'><br>
                <input type="submit" name='mb' value='Boutique'>
            </div>
            <div class="group2">
                <input id="recherche" type="text" placeholder="Recherche" name="Nom">
            </div>
                <?PHP
                if(isset($_SESSION['recherche'])){
                    if($_SESSION['recherche']=='Manege'){
                        echo "<br />";
                        echo "<div class='group5'>";
                        echo "Taille entre : <br><input class='taille' type='text' placeholder='TailleMin' name='Taille1'> <br>et <br><input class='taille' type='text' placeholder='TailleMax' name='Taille2'>";
                        echo "</div>";
                        echo "<div class='group4'>";
                        $requetef="select libelleF from Famille";
                        $resf=mysqli_query($idcom,$requetef);

                        if ($resf){
                            echo "Famille : <br>";
                            while($row=mysqli_fetch_array($resf)){
                                echo "$row[0] :<input type='checkbox' name='Famille[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "<br />";
                        }
                        else{
                            echo "Problème pour Famille";
                        }
                    }
                    else {
                        echo "<div class='group4'>";
                        $requetet = "select distinct typeB from Boutique";
                        $rest = mysqli_query($idcom, $requetet);
                        if ($rest) {
                            echo "Type de boutique : <br>";
                            while($row=mysqli_fetch_array($rest)){
                                echo "$row[0] :<input type='checkbox' name='Type[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "<br />";
                        } else {
                            echo "Problème pour Type de Boutique";
                        }
                    }
                }
                echo "</div>";
                echo "<div class='group3'>";
                $requetez="select nomZ from Zone";
                $resz=mysqli_query($idcom,$requetez);
                if ($resz){
                    echo "Zone : <br>";
                    while($row=mysqli_fetch_array($resz)){
                        echo "$row[0] :<input type='checkbox' name='Zone[]' value='$row[0]'>";
                        echo "<br />";
                    }
                }
                else{
                    echo "Problème pour Zone";
                }
                echo "</div>";
                ?>
            <div class="group6">
                <input type="submit" name='submit' value="Rechercher">
            </div>
        </div>
    </form>
                    <?PHP
                    if(!empty($_POST['submit'])){
                        echo "<div class='bloc'>";
                        echo "<div class='group'>Résultat de la recherche</div>";
                        echo "<div id='grouptab'><table style='border:solid;''>";
                        if($_SESSION['recherche']=='Manege'){
                            echo "<th>Nom du Manege</th>";
                            $requete="SELECT DISTINCT M.NomM FROM Manege M, Famille F, Zone Z WHERE Z.IdZ=M.IdZ AND M.IdF=F.IdF";
                            if(!empty($_POST['Nom'])){
                                $val=$_POST['Nom'];
                                $requete=$requete." AND M.NomM LIKE '%$val%'";
                            }
                            if((!empty($_POST['Taille1']))&&(!empty($_POST['Taille2']))){
                                $val1=min($_POST['Taille1'],$_POST['Taille2']);
                                $val2=max($_POST['Taille1'],$_POST['Taille2']);
                                $requete=$requete." AND M.tailleMin BETWEEN $val1 AND $val2";
                            }
                            if(!empty($_POST['Famille'])){
                                $var=$_POST['Famille'];
                                $requete=$requete." AND (F.libelleF = '$var[0]'";
                                for($i=1;$i<count($var);$i++){
                                    $requete=$requete." OR F.libelleF = '$var[$i]'";
                                }
                                $requete=$requete.")"; 
                            }
                            if(!empty($_POST['Zone'])){
                                $var=$_POST['Zone'];
                                $requete=$requete." AND (Z.nomZ = '$var[0]'";
                                for($i=1;$i<count($var);$i++){
                                    $requete=$requete." OR Z.nomZ = '$var[$i]'";
                                }   
                                $requete=$requete.")";
                            }
                        }
                        else{
                            $requete="SELECT DISTINCT B.NomB,B.IdB FROM Boutique B, Zone Z WHERE Z.IdZ=B.IdZ";
                            echo "<th>Nom de la boutique</th>";
                            if(!empty($_POST['Nom'])){
                                $val=$_POST['Nom'];
                                $requete=$requete." AND B.NomM LIKE '%$val%'";
                            }
                            if(!empty($_POST['Type'])){
                                $var=$_POST['Type'];
                                $requete=$requete." AND (B.typeB = '$var[0]'";
                                for($i=1;$i<count($var);$i++){
                                    $requete=$requete." OR B.typeB = '$var[$i]'";
                                }  
                                $requete=$requete.")";
                            }
                            if(!empty($_POST['Zone'])){
                                $var=$_POST['Zone'];
                                $requete=$requete." AND (Z.nomZ = '$var[0]'";
                                for($i=1;$i<count($var);$i++){
                                    $requete=$requete." OR Z.nomZ = '$var[$i]'";
                                }   
                                $requete=$requete.")";
                            }
                        }
                        $result=mysqli_query($idcom,$requete);
                        if ($result){
                            echo "<br>";
                            while($row=mysqli_fetch_array($result)){
                                if($_SESSION['recherche']=="Manege"){
                                    echo "<tr><td>"."<a href='manege.php?NomM=".$row[0]."' target='_blank'>".$row[0]."</a>"."</td></tr>";
                                }
                                else{
                                    echo "<tr><td>"."<a href='boutique.php?IdB=".$row[1]."' target='_blank' >".$row[0]."</a>"."</td></tr>";
                                }
                            }
                        }
                        else
                        {
                            echo "PB";
                        }
                        echo "</table></div>";
                    }
                    ?>
        </div>
</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='index.php'>log in </a>";
}
?>