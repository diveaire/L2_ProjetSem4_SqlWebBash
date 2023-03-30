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
        elseif($tb=="Bilan"){
            if(isset($_POST["DateB"])&&(!empty($_POST["ap"]))&&(!empty($_POST["ns"]))){
                $NomM=$id;
                $DateB=$_POST["DateB"];
                $ap=$_POST["ap"];
                $ns=$_POST["ns"];
                $req="SELECT * FROM Bilan WHERE DateB=STR_TO_DATE('$DateB','%Y-%m-%d') AND demi_journee='$ap' AND NomM='$NomM'";
                $res=mysqli_query($idcom,$req);
                if(0<mysqli_num_rows($res)){
                    if(!empty($_POST['frequentation'])&&(preg_match("/^[0-9]+$/",$_POST['frequentation']))){
                        $freq=$_POST['frequentation'];
                        $requete="UPDATE Bilan SET NumSS=$ns,frequentation=$freq  WHERE DateB=STR_TO_DATE('$DateB','%Y-%m-%d') AND demi_journee='$ap' AND NomM='$NomM'";
                    }
                    else{
                        $requete="UPDATE Bilan SET NumSS=$ns WHERE DateB=STR_TO_DATE('$DateB','%Y-%m-%d') AND demi_journee='$ap' AND NomM='$NomM'";
                    }
                }
                else{
                    if(!empty($_POST['frequentation'])&&(preg_match("/^[0-9]+$/",$_POST['frequentation']))){
                        $freq=$_POST['frequentation'];
                        $requete="INSERT INTO Bilan VALUES ('$NomM','$ns',STR_TO_DATE('$DateB','%Y-%m-%d'),$freq,'$ap')";    
                    }
                    else{
                        $requete="INSERT INTO Bilan VALUES ('$NomM','$ns',STR_TO_DATE('$DateB','%Y-%m-%d'),0,'$ap')";     
                    }
                }
            }
            else{
                $ok=false;
            }
        }
        elseif($tb=="Maintenance"){
            $DateFin=$_POST["DateFin"];
            $requete="UPDATE Maintenance SET DateFin=STR_TO_DATE('$DateFin','%Y-%m-%d') WHERE IdM=$id";
        }
        elseif($tb=="Boutique"){
            $NomB=$_POST["val"];
            $requete="UPDATE Boutique SET NomB='$NomB' WHERE IdB=$id";
        }
        elseif($tb=="Personnel_Boutique"){
            if(!empty($_POST['addP'])){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdB=$id WHERE NumSS='$NumSS'";
            }
            elseif(!empty($_POST['modR'])){
                $NumSS=$_POST['newresp'];
                $Resp=$_POST['resp'];
                echo $Resp;
                echo "  ".$NumSS;
                $requete="UPDATE Personnel SET responsable=1 WHERE NumSS='$NumSS'";
                $res=mysqli_query($idcom,$requete);
                $requete="UPDATE Personnel SET responsable=0 WHERE NumSS='$Resp'";
            }
            elseif(!empty($_POST['delete'])){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdB=NULL WHERE NumSS='$NumSS'";
            }
            else{
                $ok=false;
            }
        }
        elseif($tb=="Objet"){
            if(!empty($_POST['add'])&&(!empty($_POST['Prix']))){
                $IdO=$_POST['IdP'];
                $Prix=$_POST['Prix'];
                $DateVente=$_POST['DateVente'];
                if(preg_match("/^[0-9]+\.[0-9]{2}$/",$Prix)){
                    $requete="UPDATE Objet SET Prix=$Prix, DateVente=STR_TO_DATE('$DateVente','%Y-%m-%d') WHERE IdO=$IdO";
                }
                else{
                    $ok=false;
                }
            }
            elseif(!empty($_POST['delete'])){
                $IdO=$_POST['IdP'];
                $requete="UPDATE Objet SET Prix=NULL, DateVente=NULL WHERE IdO=$IdO";
            }
            else{
                $ok=false;
            }
        }
        if($ok){
            echo $requete;
            $res=mysqli_query($idcom,$requete);
        }
        mysqli_close($idcom);
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>