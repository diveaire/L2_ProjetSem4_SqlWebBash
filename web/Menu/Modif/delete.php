<?php
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        echo "$id $tb";
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        if($tb=="Manege"){
            $requete="DELETE FROM Manege WHERE nomM='$id'";
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