<HTML>
<?PHP
    session_start();
    if (isset($_SESSION['metier'])&&(isset($_POST['inser']))){
        include("../../Parametres/connex.inc.php");
        $idcom=connex("myparam");
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
        elseif(!empty($_POST['nomB'])&&(!empty($_POST['nomZ']))&&(!empty($_POST['typeB']))){
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
        elseif(!empty($_POST['nomA'])&&!empty($_POST['nomZ'])){
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
        $result=mysqli_query($idcom,$requete);
        mysqli_close($idcom);
        if ($result){
        	echo "<script>alert('ça marche');</script>";
        }else{
        	echo "<script>alert('ça marche pas');</script>";
        }
        header('Location: ../gestion.php');
    }
    else{
        header('Location: ../../index.php');
    }
?>
</HTML>
