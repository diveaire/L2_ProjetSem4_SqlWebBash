<!DOCTYPE HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $NomM=$_POST['id'];
        $tb=$_POST['tb'];
        $DateDeb=$_POST['DateDeb'];
        $IdA=$_POST['IdA'];
?>
<html>
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
<div class='bloc'>
    <form method='POST' action='../Modif/insertion.php'>
    Choisissez les techniciens :
        <?PHP
            echo "<input type='hidden' name='id' value='$NomM'></input>";
            echo "<input type='hidden' name='tb' value='$tb'></input>";
            echo "<input type='hidden' name='DateDeb' value='$DateDeb'></input>";
        ?>
            <?PHP
                $req="SELECT P.NumSS, UPPER(nomP), prenomP FROM Personnel P WHERE P.IdA=$IdA";
                $res=mysqli_query($idcom,$req);
                while($row=mysqli_fetch_array($res)){
                    echo "$row[1] $row[2]:<input type='checkbox' name='NumSS[]' value='$row[0]'>";
                }
            ?>
            <input type='submit' name='confirmer' value='Valider'></input>
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