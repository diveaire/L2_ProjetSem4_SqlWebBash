<HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['tb']))){
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
        if($_POST['tb']=="Manege"){
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
        elseif($_POST['tb']=="Boutique"){
            if(!empty($_POST['nomB'])&&(!empty($_POST['nomZ']))&&(!empty($_POST['typeB']))){
                $nomB=$_POST['nomB'];
                $nomZ=$_POST['nomZ'];
                $typeB=$_POST['typeB'];
                $req="SELECT IdZ FROM Zone WHERE nomZ='$nomZ'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdZ=$res[0];
                }
                $req="SELECT MAX(IdB) FROM Boutique";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdB=$res[0]+1;
                $requete="INSERT INTO Boutique VALUES ('$IdB','$nomB','$typeB','$IdZ')";
            }
        }
        elseif($_POST['tb']=="Atelier"){
            if(!empty($_POST['nomA'])&&!empty($_POST['nomZ'])){
                $nomA=$_POST['nomA'];
                $nomZ=$_POST['nomZ'];
                $req="SELECT IdZ FROM Zone WHERE nomZ='$nomZ'";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                if($res){
                    $IdZ=$res[0];
                }
                $req="SELECT MAX(IdA) FROM Atelier";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdA=$res[0]+1;
                $requete="INSERT INTO Atelier VALUES ('$IdA','$nomA','$IdZ')";
            }
        }
        elseif($_POST['tb']=="Maintenance"){
            if(!empty($_POST['NumSS'])){
                $NomM=$_POST['id'];
                $DateDeb=$_POST['DateDeb'];
                $req="SELECT MAX(IdM) FROM Maintenance";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdM=$res[0]+1;
                $requete="INSERT INTO Maintenance (IdM,DateDeb,NomM) VALUES ($IdM,STR_TO_DATE('$DateDeb','%Y-%m-%d'),'$NomM')";
                echo $requete;
                $result=mysqli_query($idcom,$requete);
                $tabN=$_POST['NumSS'];
                for($i=0;$i<count($tabN);$i++){
                    $req="INSERT INTO Equipe VALUES ($tabN[$i],$IdM)";
                    $result=mysqli_query($idcom,$req);
                }
                unset($requete);
            }
        }
        elseif($_POST['tb']=="Objet"){
            if(!empty($_POST['nomO'])){
                $IdB=$_POST['id'];
                $nomO=$_POST['nomO'];
                $IdT=$_POST['IdT'];
                $req="SELECT MAX(IdO) FROM Objet";
                $res=mysqli_fetch_array(mysqli_query($idcom,$req));
                $IdO=$res[0]+1;
                $requete="INSERT INTO Objet (IdO,nomO,IdB,IdT) VALUES ($IdO,'$nomO',$IdB,$IdT)";
                echo $requete;
            }
        }
        if(isset($requete)){
            $result=mysqli_query($idcom,$requete);            
        }
        mysqli_close($idcom);
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>