<?php
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        if($tb=="Manege"){
            $requete="DELETE FROM Manege WHERE nomM='$id'";
        }
        elseif($tb=="Bilan"){
            if(!empty($_POST["ap"])&&(!empty($_POST["date"]))){
                $ap=$_POST["ap"];
                $date=$_POST["date"];
                $requete="DELETE FROM Bilan WHERE nomM='$id' AND demi_journee='$ap' AND DateB=STR_TO_DATE('$date','%Y-%m-%d')";
            }
        }
        elseif($tb=="Maintenance"){
            $IdM=$_POST['id'];
            $requete="DELETE FROM Maintenance WHERE IdM=$IdM";
        }
        elseif($tb=="Boutique"){
            $req="UPDATE Personnel SET responsable=0 WHERE responsable=1 AND IdB=$id";
            $res=mysqli_query($idcom,$req);
            $requete="DELETE FROM Boutique WHERE IdB='$id'";
        }
        elseif($tb=="Objet"){
            $IdO=$_POST["IdP"];
            $requete="DELETE FROM Objet WHERE IdO='$IdO'";
        }
        if(isset($requete)){
            $res=mysqli_query($idcom,$requete);
        }
        mysqli_close($idcom);
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>
