<?php
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        $ok=true;
        if($tb=="Manege"){
            if(isset($_POST["att"])&&(!empty($_POST["val"]))){
                $att=$_POST["att"];
                $val=$_POST["val"];
                $requete="UPDATE Manege SET";
                if($att=="nomM"){
                    $requete="$requete nomM='$val'";
                }
                else if($att=="tailleMin"){
                    if(preg_match("/^[0-9]+$/",$val)){
                        $requete="$requete tailleMin='$val'";
                    }
                    else{
                        $ok=false;
                    }
                }
                else if($att=="description"){
                    $requete="$requete description='$val'";
                }
                else{
                    $req="SELECT IdZ FROM Zone WHERE nomZ LIKE '%$val%'"; 
                    $res=mysqli_query($idcom,$req);
                    $l=mysqli_num_rows($res);
                    if($l>0){
                        $x=mysqli_fetch_array($res);
                        $requete="$requete IdZ='$x[0]'";
                    }
                    else{
                        $ok=false;
                    }
                }
                if($ok){
                    echo $requete;
                    $requete="$requete WHERE nomM='$id'";
                }
            }
        }
        if($ok){
            $res=mysqli_query($idcom,$requete);
        }
        mysqli_close($idcom);
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>