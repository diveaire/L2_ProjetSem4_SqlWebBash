<?php
    session_start();
     /* Vérification des droits et vérification que la table où on doit insérer quelque chose est renseignée */
    if (isset($_SESSION['metier'])&&($_SESSION['droit']>0)&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        /* On initialise l'adresse de retour */
        $retour="../gestion.php";
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        /* Suppression d'un manège */
        if($tb=="Manege"){
            $requete="DELETE FROM Manege WHERE nomM='$id'";
        }
        /* Suppression d'une ligne du bilan */
        elseif($tb=="Bilan"){
            if(!empty($_POST["ap"])&&(!empty($_POST["date"]))){
                $ap=$_POST["ap"];
                $date=$_POST["date"];
                $requete="DELETE FROM Bilan WHERE nomM='$id' AND demi_journee='$ap' AND DateB=STR_TO_DATE('$date','%Y-%m-%d')";
            }
            $retour="../AdminModif/manegeadm.php?NomM=$id";
        }
        /* Suppression d'une ligne de maintenance et retour sur le manège en liens avec la suppression*/
        elseif($tb=="Maintenance"){
            $IdM=$_POST['id'];
            $requete="DELETE FROM Maintenance WHERE IdM=$IdM";
            $req="SELECT NomM FROM Maintenance WHERE IdM=$IdM";
            $res=mysqli_query($idcom,$req);
            $NomM=mysqli_fetch_array($res);
            $retour="../AdminModif/manegeadm.php?NomM=$NomM[0]";
        }
         /* Retrait du personnel d'une boutique et suppression de celle-ci*/
        elseif($tb=="Boutique"){
            $req="UPDATE Personnel SET IdB=null,responsable=0 WHERE IdB=$id";
            $res=mysqli_query($idcom,$req);
            $requete="DELETE FROM Boutique WHERE IdB='$id'";
        }
        /* Suppression des objets*/
        elseif($tb=="Objet"){
            $IdO=$_POST["IdP"];
            $requete="DELETE FROM Objet WHERE IdO='$IdO'";
            $retour="../AdminModif/boutiqueadm.php?IdB=$id";
        }
        /* Retrait du personnel d'un atelier et suppression de celui-ci*/
        elseif($tb=="Atelier"){
            $req="UPDATE Personnel SET IdA=null,chef=0 WHERE IdA=$id";
            $res=mysqli_query($idcom,$req);
            $requete="DELETE FROM Atelier WHERE IdA='$id'";
        }
        /* Suppression des pièces*/
        elseif($_POST['tb']=="Piece"){
            $NumSerie=$_POST["NumSerie"];
            $requete="DELETE FROM PiecesDetachees WHERE NumSerie='$NumSerie'";
            $retour="../AdminModif/atelieradm.php?IdA=$id";
        }
        if(isset($requete)){
            $res=mysqli_query($idcom,$requete);
        }
        mysqli_close($idcom);
        header("Location: $retour");
    }
    else{
        header('Location: ../../index.php');
    }
?>