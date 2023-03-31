<?php
    session_start();
    if (isset($_SESSION['metier'])&&($_SESSION['droit']>0)&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        $ok=true;
        $retour='../gestion.php';
        if($tb=="Manege"){
            if(isset($_POST["att"])&&(!empty($_POST["val"]))){
                $att=$_POST["att"];
                $val=$_POST["val"];
                $requete="UPDATE Manege SET";
                if($att=="nomM"){
                    $requete="$requete nomM='$val'";
                    $retour="../AdminModif/manegeadm.php?NomM=$val";
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
                    if($retour=="../gestion.php"){
                        $retour="../AdminModif/manegeadm.php?NomM=$id";
                    }
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
            $retour="../AdminModif/manegeadm.php?NomM=$id";
        }
        elseif($tb=="Maintenance"){
            if(isset($_POST["DateFin"])){
                $DateFin=$_POST["DateFin"];
                $requete="UPDATE Maintenance SET DateFin=STR_TO_DATE('$DateFin','%Y-%m-%d') WHERE IdM=$id";
                $req="SELECT NomM FROM Maintenance WHERE IdM=$id";
                $res=mysqli_query($idcom,$req);
                $val=mysqli_fetch_array($res);
                $NomM=$val[0];
                $retour="../AdminModif/manegeadm.php?NomM=$NomM";
            }
            else{
                $date=date('Y-m-d');
                $requete="SELECT DATE_FORMAT(DateDeb,'%Y-%m-%d') FROM Maintenance WHERE IdM=$id";
                $res=mysqli_query($idcom,$requete);
                if($res){
                    $DateDeb=mysqli_fetch_array($res);
                    $DateDeb=$DateDeb[0];
                    if($DateDeb<=$date){
                        $requete="UPDATE Maintenance SET DateFin=STR_TO_DATE('$date','%Y-%m-%d') WHERE IdM=$id";
                    }
                    else{
                        $requete="DELETE FROM Maintenance WHERE IdM=$id";
                    }
                }
                else{
                    $ok=false;
                }
                $req="SELECT P.IdA FROM Maintenance M, Personnel P, Equipe E WHERE M.IdM=$id AND M.IdM=E.IdM AND E.NumSS=P.NumSS";
                $res=mysqli_query($idcom,$req);
                if($res){
                    $row=mysqli_fetch_array($res);
                    $IdA=$row[0];
                    $retour="../AdminModif/atelieradm.php?IdA=$IdA";
                }
            }
        }
        elseif($tb=="Boutique"){
            $NomB=$_POST["val"];
            $requete="UPDATE Boutique SET NomB='$NomB' WHERE IdB=$id";
            $retour="../AdminModif/boutiqueadm.php?IdB=$id";
        }
        elseif($tb=="Personnel_Boutique"){
            if(!empty($_POST['addP'])&&(!empty($_POST["NumSS"]))){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdB=$id WHERE NumSS='$NumSS'";
            }
            elseif(!empty($_POST['modR'])&&!empty($_POST["newresp"])){
                $NumSS=$_POST['newresp'];
                $Resp=$_POST['resp'];
                echo $Resp;
                echo "  ".$NumSS;
                $requete="UPDATE Personnel SET responsable=1 WHERE NumSS='$NumSS'";
                $res=mysqli_query($idcom,$requete);
                $requete="UPDATE Personnel SET responsable=0 WHERE NumSS='$Resp'";
            }
            elseif(!empty($_POST['delete'])&&!empty($_POST["NumSS"])){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdB=NULL WHERE NumSS='$NumSS'";
            }
            else{
                $ok=false;
            }
            $retour="../AdminModif/boutiqueadm.php?IdB=$id";
        }
        elseif($tb=="Objet"){
            if(!empty($_POST['add'])&&(!empty($_POST['IdP']))&&(!empty($_POST['Prix']))){
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
            elseif(!empty($_POST['delete'])&&(!empty($_POST['IdP']))){
                $IdO=$_POST['IdP'];
                $requete="UPDATE Objet SET Prix=NULL, DateVente=NULL WHERE IdO=$IdO";
            }
            else{
                $ok=false;
            }
            $retour="../AdminModif/boutiqueadm.php?IdB=$id";
        }
        elseif($tb=="Atelier"){
            $NomA=$_POST["val"];
            $requete="UPDATE Atelier SET nomA='$NomA' WHERE IdA=$id";
            $retour="../AdminModif/atelieradm.php?IdA=$id";
        }
        elseif($tb=="Personnel_Atelier"){
            if(!empty($_POST['addP'])&&(!empty($_POST["NumSS"]))){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdA=$id WHERE NumSS='$NumSS'";
            }
            elseif(!empty($_POST['modC'])&&(!empty($_POST["newchef"]))){
                $NumSS=$_POST['newchef'];
                $chef=$_POST['chef'];
                echo $chef;
                echo "  ".$NumSS;
                $requete="UPDATE Personnel SET chef=1 WHERE NumSS='$NumSS'";
                $res=mysqli_query($idcom,$requete);
                $requete="UPDATE Personnel SET chef=0 WHERE NumSS='$chef'";
            }
            elseif(!empty($_POST['delete'])&&(!empty($_POST["NumSS"]))){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdA=NULL WHERE NumSS='$NumSS'";
            }
            else{
                $ok=false;
            }
            $retour="../AdminModif/atelieradm.php?IdA=$id";
        }
        elseif($tb=="Piece"){
            if(!empty($_POST['NumSerie'])&&(!empty($_POST["IdM"]))){
                $NumSerie=$_POST['NumSerie'];
                $IdM=$_POST["IdM"];
                $requete="UPDATE PiecesDetachees SET IdM=$IdM WHERE NumSerie='$NumSerie'";
            }
            elseif(!empty($_POST['Fournie'])){
                $NumSerie=$_POST['Fournie'];
                $requete="UPDATE PiecesDetachees SET IdM=NULL WHERE NumSerie='$NumSerie'";
            }
            else{
                $ok=false;
            }
            $retour="../AdminModif/atelieradm.php?IdA=$id";
        }
        if($ok){
            echo $requete;
            $res=mysqli_query($idcom,$requete);
        }
        mysqli_close($idcom);
        header("Location: $retour");
    }
    else{
        header('Location: ../../index.php');
    }
?>
