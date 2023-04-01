<!DOCTYPE HTML>
<html lang="fr">
<?PHP
    session_start();
    /* Vérification des droits et vérification que la table où on doit insérer quelque chose est renseignée */
    if (isset($_SESSION['metier'])&&($_SESSION['droit']>0)&&(isset($_POST['tb']))){
        /* On initialise l'adresse de retour */
        $retour="../gestion.php";
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        /* Si la table d'insertion concerne les manèges */
        if($_POST['tb']=="Manege"){
            /* On vérifie que les variables sont initialisées */
            if(!empty($_POST['nomM'])&&(!empty($_POST['libelleF']))&&(!empty($_POST['nomZ']))){
                $nomM=$_POST['nomM'];
                $nomZ=$_POST['nomZ'];
                $libF=$_POST['libelleF'];
                $req="SELECT IdZ FROM Zone WHERE nomZ='$nomZ'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdZ=$res[0];
                }
                $req="SELECT IdF FROM Famille WHERE libelleF='$libF'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdF=$res[0];
                }
                $tailleMin=0;
                $description="";
                if(!empty($_POST['tailleMin'])){
                    $val=$_POST['tailleMin'];
                    if(preg_match("/^[0-9]+$/",$val)){
                        $tailleMin=$val;
                    }
                }
                if(!empty($_POST['description'])){
                    $description=$_POST['description'];
                }
                $requete="INSERT INTO Manege VALUES ('$nomM','$tailleMin','$description','$IdF','$IdZ')";
            }
        }
        /* Si la table d'insertion concerne les boutiques */
        elseif($_POST['tb']=="Boutique"){
             /* On vérifie que les variables sont initialisées */
            if(!empty($_POST['nomB'])&&(!empty($_POST['nomZ']))&&(!empty($_POST['typeB']))&&(!empty($_POST['resp']))){
                $nomB=$_POST['nomB'];
                $nomZ=$_POST['nomZ'];
                $typeB=$_POST['typeB'];
                $resp=$_POST['resp'];
                $req="SELECT IdZ FROM Zone WHERE nomZ='$nomZ'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdZ=$res[0];
                }
                /* On vérifie que les responsable selectionné est cohérent avec le type de boutique */
                $req="SELECT Metier FROM Personnel WHERE NumSS='$resp'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $metier=$res[0];
                }
                if((($metier!="Serveur")&&(($typeB=="Souvenir")||($typeB=="souvenir")))||(($metier!="Vendeur")&&(($typeB=="Restaurant")||($typeB=="restaurant")))){
                    $req="SELECT MAX(IdB) FROM Boutique";
                    $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                    $IdB=$res[0]+1;
                    $requete="INSERT INTO Boutique VALUES ('$IdB','$nomB','$typeB','$IdZ')";
                    $result=mysqli_query($idcom,$requete); 
                    /* On affecte le responsable */
                    $requete1="UPDATE Personnel SET responsable=1, IdB=$IdB WHERE NumSS='$resp'";
                    $result1=mysqli_query($idcom,$requete1);   
                    unset($requete);
                }
            }
        }
        /* Si la table d'insertion concerne les ateliers */
        elseif($_POST['tb']=="Atelier"){
            /* On vérifie que les variables sont initialisées */
            if(!empty($_POST['nomA'])&&!empty($_POST['nomZ'])&&(!empty($_POST['chef']))){
                $nomA=$_POST['nomA'];
                $nomZ=$_POST['nomZ'];
                $chef=$_POST['chef'];
                $req="SELECT IdZ FROM Zone WHERE nomZ='$nomZ'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdZ=$res[0];
                }
                $req="SELECT MAX(IdA) FROM Atelier";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdA=$res[0]+1;
                $requete="INSERT INTO Atelier VALUES ('$IdA','$nomA','$IdZ')";
                $result=mysqli_query($idcom,$requete); 
                 /* On affecte le chef */
                $requete1="UPDATE Personnel SET chef=1, IdA=$IdA WHERE NumSS='$chef'";
                $result1=mysqli_query($idcom,$requete1);   
                unset($requete);
            }
        }
        /* Si la table d'insertion concerne les maintenances */
        elseif($_POST['tb']=="Maintenance"){
            /* On vérifie que les variables sont initialisées, les variables DateDeb et nomM l'est forcément */
            if(!empty($_POST['NumSS'])){
                $NomM=$_POST['id'];
                $DateDeb=$_POST['DateDeb'];
                $req="SELECT MAX(IdM) FROM Maintenance";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdM=$res[0]+1;
                $requete="INSERT INTO Maintenance (IdM,DateDeb,NomM) VALUES ($IdM,STR_TO_DATE('$DateDeb','%Y-%m-%d'),'$NomM')";
                $result=mysqli_query($idcom,$requete);
                /* Pour chaque personnel de maintenance ont les affecte à l'équipe de maintenance */
                $tabN=$_POST['NumSS'];
                for($i=0;$i<count($tabN);$i++){
                    $req="INSERT INTO Equipe VALUES ($tabN[$i],$IdM)";
                    $result=mysqli_query($idcom,$req);
                }
                unset($requete);
                /* Mise à jour du retour */
                $retour="../AdminModif/manegeadm.php?NomM=$NomM";
            }
        }
        /* Si la table d'insertion concerne les objets */
        elseif($_POST['tb']=="Objet"){
            /* On vérifie que le nom a été donné, le type a forcément été renseigné puisqu'il est dans un select */
            if(!empty($_POST['nomO'])){
                $IdB=$_POST['id'];
                $nomO=$_POST['nomO'];
                $IdT=$_POST['IdT'];
                $req="SELECT MAX(IdO) FROM Objet";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdO=$res[0]+1;
                $requete="INSERT INTO Objet (IdO,nomO,IdB,IdT) VALUES ($IdO,'$nomO',$IdB,$IdT)";
                $retour="../AdminModif/boutiqueadm.php?IdB=$IdB";
            }
        }
        /* Si la table d'insertion concerne les pièces */
        elseif($_POST['tb']=="Piece"){
            /* On vérifie que le nom a été donné et le numéro de série, l'atelier a forcément été renseigné car passé en input hidden */
            if(!empty($_POST['NumSerie'])&&!empty($_POST['nomPC'])){
                $NumSerie=$_POST['NumSerie'];
                if(preg_match("/^[0-9]{8}$/",$NumSerie)){
                    $nomPC=$_POST['nomPC'];
                    $IdA=$_POST['id'];
                    $requete="INSERT INTO PiecesDetachees (NumSerie,nomPC,IdA) VALUES ($NumSerie,'$nomPC',$IdA)";
                    $retour="../AdminModif/atelieradm.php?IdA=$IdA";
                }
            }
        }
        if(isset($requete)){
            $result=mysqli_query($idcom,$requete);            
        }
        mysqli_close($idcom);
        header("Location: $retour");
    }
    else{
        header('Location: ../../index.php');
    }
?>