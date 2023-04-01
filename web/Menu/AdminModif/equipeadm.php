<!DOCTYPE HTML>
<?PHP
    session_start();
    /*Ouverture de la session et vérification qu'il s'agit bien d'un membre du personnel qui s'est connecté*/
    if (isset($_SESSION['metier'])&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        /*Récupération de tous les paramètres en vue de les transmettre ensuite à insertion.php*/
        $IdM=$_POST['id'];
        $tb=$_POST['tb'];
        $DateDeb=$_POST['DateDeb'];
        $IdA=$_POST['IdA'];
?>
<html lang="fr">
<head>
    <title>page de Modification</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../../Style/menu.css">
    <link rel="stylesheet" href="../../Style/styleProfil.css">
    <script src="../../Script/script.js"></script>
    <script src="../../Script/date.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="../accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="../profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="../recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="../gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="../logout.php">Log out</a></li>
</ul>
<?PHP
    include("../../Parametres/connex.inc.php");
    $idcom=connex("myparam");
?>
<!-- Section permettant d'afficher le formulaires de constitution d'une equipe pour la maintenance-->
<div class='bloc'>
    <form method='POST' action='../Modif/insertion.php'>
    Choisissez les techniciens :
        <?PHP
            /*On passe tous les paramètres renseignés à insertion.php*/
            echo "<input type='hidden' name='id' value='$IdM'>";
            echo "<input type='hidden' name='tb' value='$tb'>";
            echo "<input type='hidden' name='DateDeb' value='$DateDeb'>";
        ?>
            <?PHP
                /* Choix des personnels disponibles */
                $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdA=$IdA";
                $res=mysqli_query($idcom,$req);
                while($row=mysqli_fetch_array($res)){
                    echo "$row[1] $row[2]:<input type='checkbox' name='NumSS[]' value='$row[0]'>";
                }
            ?>
            <input type='submit' name='confirmer' value='Valider'>
    </form>
</div>
<?PHP
    mysqli_close($idcom);
    }
    else{
        header('Location: ../../index.php');
    }
?>
</html>