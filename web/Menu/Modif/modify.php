<?php
    session_start();
     /* Vérification des droits et vérification que la table où on doit modifier quelque chose est renseignée */
    if (isset($_SESSION['metier'])&&($_SESSION['droit']>0)&&(isset($_POST['id']))&&(isset($_POST['tb']))){
        $id=$_POST["id"];
        $tb=$_POST["tb"];
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        /* On initialise la variable contrôlant la validité des requêtes */
        $ok=true;
        /* On initialise l'addresse de retour */
        $retour='../gestion.php';
        /* Si la modification concerne les manèges */
        if($tb=="Manege"){
            /* Si l'attribut à modifier et la valeur sont renseignées on construit la requête en fonction de ces derniers */
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
                /* Si la requête n'a pas été invalidé on peut la compléter et créer l'adresse */
                if($ok){
                    echo $requete;
                    $requete="$requete WHERE nomM='$id'";
                    if($retour=="../gestion.php"){
                        $retour="../AdminModif/manegeadm.php?NomM=$id";
                    }
                }
            }
        }
        /* Si on doit modifier bilan */
        elseif($tb=="Bilan"){
            /* On vérifie que tous les paramètres sont initialisés */
            if(isset($_POST["DateB"])&&(!empty($_POST["ap"]))&&(!empty($_POST["ns"]))){
                $NomM=$id;
                $DateB=$_POST["DateB"];
                $ap=$_POST["ap"];
                $ns=$_POST["ns"];
                /* On regarde si le bilan a déjà été entré, si c'est le cas on le modifie sinon on l'ajoute */
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
        /* Si la modification concerne les maintenances*/
        elseif($tb=="Maintenance"){
            /* Si la date de fin est données, on achève la maintenance et on retourne sur la page du manège puisque seul le directeur à partir de cette page donne une date de fin*/
            if(isset($_POST["DateFin"])){
                $DateFin=$_POST["DateFin"];
                $requete="UPDATE Maintenance SET DateFin=STR_TO_DATE('$DateFin','%Y-%m-%d') WHERE IdM=$id";
                $req="SELECT NomM FROM Maintenance WHERE IdM=$id";
                $res=mysqli_query($idcom,$req);
                $val=mysqli_fetch_array($res);
                $NomM=$val[0];
                $retour="../AdminModif/manegeadm.php?NomM=$NomM";
            }
            /* Sinon la fin de maintenance est initiée par le responsable d'atelier, la date de fin correspond à celle d'aujourd'hui si la maintenance à commencée et elle est annulée dans le cas contraire*/
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
        /* Mise à jour du nom de la boutique */
        elseif($tb=="Boutique"){
            $NomB=$_POST["val"];
            $requete="UPDATE Boutique SET NomB='$NomB' WHERE IdB=$id";
            $retour="../AdminModif/boutiqueadm.php?IdB=$id";
        }
        /* Insertion, changement de responsable ou suppression du personnel d'une boutique */
        elseif($tb=="Personnel_Boutique"){
            if(!empty($_POST['addP'])&&(!empty($_POST["NumSS"]))){
                $NumSS=$_POST['NumSS'];
                $requete="UPDATE Personnel SET IdB=$id WHERE NumSS='$NumSS'";
            }
            elseif(!empty($_POST['modR'])&&!empty($_POST["newresp"])){
                $NumSS=$_POST['newresp'];
                $Resp=$_POST['resp'];
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
        /* Insertion ou suppression des objets d'une vente */
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
        /* Mise à jour du nom d'un atelier */
        elseif($tb=="Atelier"){
            $NomA=$_POST["val"];
            $requete="UPDATE Atelier SET nomA='$NomA' WHERE IdA=$id";
            $retour="../AdminModif/atelieradm.php?IdA=$id";
        }
        /* Insertion, changement de chef ou suppression du personnel d'un atelier */
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
         /* Ajout ou suppression des pièces d'une maintenance en cour */
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
