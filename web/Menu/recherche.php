<!DOCTYPE HTML>
<!--

    Page Moteur de Recherche
        Recherche       Restriction     éléments de recherche
       -> Manège        (All)           Zone|Famille|Taille
       -> Boutique      (ALL)           Zone|type de boutique
       -> Personnel     (Directeur)     type de recherche|responsable/chef|Date de naissance|boutique|Atelier|Metier
       -> Vente         (Directeur)     Boutique|Type objet|Prix|Date de vente
       -> inventaire    (Directeur)     Boutique|Atelier|Type Objet|Prix|Vendu ou non

-->
<?PHP
session_start();

if (isset($_SESSION['metier'])){
    include("../Parametres/connex.inc.php");
    $idcom=connex("myparam");
    $id=$_SESSION['numss'];
    $metier=$_SESSION['metier'];
    $choix="";
    if (isset($_POST['mb'])){
        $choix=$_POST['mb'];
    }
    if(empty($_SESSION['recherche'])||$choix=="Manege"){
        $_SESSION['recherche']='Manege';
    }
    elseif($choix=="Boutique"){
        $_SESSION['recherche']='Boutique';
    }
    elseif($choix=="Personnel"){
        $_SESSION['recherche']='Personnel';
    }
    elseif($choix=="Vente"){
        $_SESSION['recherche']='Vente';
    }
    elseif($choix=="Inventaire"){
        $_SESSION['recherche']='Inventaire';
    }
?>
<html lang="fr">
<head>
    <title>Recherche</title>
    <meta charset='UTF-8'>
    <link rel="stylesheet" href="../Style/menu.css">
    <link rel="stylesheet" href="../Style/styleRecherche.css">
    <script src="../Script/script.js"></script>
</head>
<body>
<ul id="menu">
    <li class="menu_elm"><a class="menuLink" href="accueil.php">Accueil</a></li>
    <li class="menu_elm"><a class="menuLink" href="profil.php">Profil</a></li>
    <li class="menu_elm"><a class="menuLink" href="recherche.php">Recherche</a></li>
    <li class="menu_elm"><a class="menuLink" href="gestion.php">Gestion Administrative</a></li>
    <li id="logout" ><a class="menuLink" href="logout.php">Log out</a></li>
</ul>
<form action="recherche.php" method="post">
    <div class="bloc">
        <div class="group">
            Entrez les informations de votre recherche
        </div>
        <div class="group1">
            <input type="submit" name='mb' value='Manege'><br />
            <input type="submit" name='mb' value='Boutique'><br />
            <?PHP if ($metier=="Directeur"){ //affichage des options suplémentaires (recherche) pour le directeur?>
                <input type="submit" name='mb' value='Personnel'><br />
                <input type="submit" name='mb' value='Vente'><br />
                <input type="submit" name='mb' value='Inventaire'><br />
            <?PHP } ?>
        </div>
        <div class="group2">
            <input id="recherche" type="text" placeholder="Recherche" name="Nom">
        </div>
            <?PHP
            if(isset($_SESSION['recherche'])){
                //CHOIX RECHERCHE PERSONNEL -- Recherche : NumSS/nom/prenom -- Champs : date_naissance(<,>,=)/responsable/Metier -- RESTRICT DIRECTEUR
                if($_SESSION['recherche']=='Personnel'){
                    echo "<div class='group3'>";
                        echo "<fieldset><legend>type de recherche :</legend>";
                        echo "<select name='typeR'>";
                            echo "<option value='NumSS'>NumSS</option>";
                            echo "<option value='Nom'>Nom</option>";
                            echo "<option value='Prenom'>Prenom</option>";
                        echo "</select></fieldset>";
                        echo "<fieldset><legend>Responsable/Chef :</legend><input type='checkbox' name='Resp' value='Resp'></fieldset>";
                        echo "<fieldset><legend>Date de naissance :</legend><select name='signe' style='margin-right:3px;'><option value='='>=</option><option value='<'>&lt;</option><option value='>'>&gt;</option></select><input type=date name='date'></fieldset>";
                    echo "</div>";
                    echo "<div class='group4'>";
                    $requeteI="select nomB from Boutique";
                    $resI=mysqli_query($idcom,$requeteI);
                    if ($resI){
                        echo "<fieldset><legend>Boutique : </legend>";
                        while($row=mysqli_fetch_array($resI)){
                            echo "$row[0] :<input type='checkbox' name='Boutique[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    }
                    else{
                        echo "Problème pour Boutique";
                    }
                    $requeteI2="select nomA from Atelier";
                    $resI2=mysqli_query($idcom,$requeteI2);
                    if ($resI2){
                        echo "<fieldset><legend>Atelier : </legend>";
                        while($row=mysqli_fetch_array($resI2)){
                            echo "$row[0] :<input type='checkbox' name='Atelier[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    }
                    else{
                        echo "Problème pour Boutique";
                    }
                    echo "</div>";
                    echo "<div class='group5'>";
                        $requetep="select Metier from Metier";
                        $resp=mysqli_query($idcom,$requetep);
                        if ($resp){
                            echo "<fieldset><legend>Metier : </legend>";
                            while($row=mysqli_fetch_array($resp)){
                                echo "$row[0] :<input type='checkbox' name='Job[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour Personnel (Métier)";
                        }
                    echo "</div>";
                }
                //CHOIX RECHERCHE VENTE -- Recherche : nomO -- Champs : Prix(range),Boutique,type,dateVente -- RESTRICT DIRECTEUR
                elseif ($_SESSION['recherche']=='Vente'){
                    echo "<div class='group3'>";
                        $requeteV="select nomB from Boutique";
                        $resV=mysqli_query($idcom,$requeteV);
                        if ($resV){
                            echo "<fieldset><legend>Boutique : </legend>";
                            while($row=mysqli_fetch_array($resV)){
                                echo "$row[0] :<input type='checkbox' name='Boutique[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour Boutique";
                        }

                    echo "</div>";
                    echo "<div class='group4'>";
                        $requeteV2="select libelleT from TypeObjet";
                        $resV2=mysqli_query($idcom,$requeteV2);
                        if ($resV2){
                            echo "<fieldset><legend>Type Objet : </legend>";
                            while($row=mysqli_fetch_array($resV2)){
                                echo "$row[0] :<input type='checkbox' name='TpObj[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour TypeObjet";
                        }
                    echo "</div>";
                    echo "<div class='group5'>";
                        echo "<fieldset><legend>Date de Vente :</legend><select name='signe' style='margin-right:3px;'>
                                    <option value='='>=</option><option value='<'>&lt;</option><option value='>'>&gt;</option>
                               </select><input type=date name='date'></fieldset>";
                        echo "<fieldset><legend>Prix entre :</legend><input class='petitChamp' pattern='[0-9]+' type='text' placeholder='Prix Min (€)' name='Prix1'> 
                                <br>et <br><input class='petitChamp' type='text' pattern='[0-9]+' placeholder='Prix Max (€)' name='Prix2'></fieldset>";
                    echo "</div>";
                }
                //CHOIX RECHERCHE Inventaire -- TABLE Objet/PiecesDetachées -- Recherche : nomO,nomPc -- Champs : Prix(range),Boutique,type,Atelier -- RESTRICT DIRECTEUR
                elseif ($_SESSION['recherche']=='Inventaire'){
                    echo "<div class='group3'>";
                        $requeteI="select nomB from Boutique";
                        $resI=mysqli_query($idcom,$requeteI);
                        if ($resI){
                            echo "<fieldset><legend>Boutique : </legend>";
                            while($row=mysqli_fetch_array($resI)){
                                echo "$row[0] :<input type='checkbox' name='Boutique[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour Boutique";
                        }
                        echo "<select name='table'><option value='bout'>&uarr;</option><option value='both' selected>&amp;</option><option value='atel'>&darr;</option></select>";
                        $requeteI2="select nomA from Atelier";
                        $resI2=mysqli_query($idcom,$requeteI2);
                        if ($resI2){
                            echo "<fieldset><legend>Atelier : </legend>";
                            while($row=mysqli_fetch_array($resI2)){
                                echo "$row[0] :<input type='checkbox' name='Atelier[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour Boutique";
                        }
                    echo "</div>";
                    echo "<div class='group4'>";
                        $requeteV2="select libelleT from TypeObjet";
                        $resV2=mysqli_query($idcom,$requeteV2);
                        if ($resV2){
                            echo "<fieldset><legend>Type Objet : </legend>";
                            while($row=mysqli_fetch_array($resV2)){
                                echo "$row[0] :<input type='checkbox' name='TpObj[]' value='$row[0]'>";
                                echo "<br />";
                            }
                            echo "</fieldset>";
                        }
                        else{
                            echo "Problème pour TypeObjet";
                        }
                    echo "</div>";
                    echo "<div class='group5'>";
                        echo "<fieldset><legend>Prix entre :</legend><input class='petitChamp' type='text' pattern='[0-9]+' placeholder='Prix Min (€)' name='Prix1'> 
                                <br>et <br><input class='petitChamp' type='text' pattern='[0-9]+' placeholder='Prix Max (€)' name='Prix2'></fieldset>";
                        echo "<fieldset><legend>Vendu </legend>";
                        echo "Oui<input type='radio' name='vente' value='oui'>";
                        echo "Non<input type='radio' name='vente' value='non'></fieldset>";
                    echo "</div>";
                }
                //CHOIX RECHERCHE MANEGE -- Recherche : nomM -- Champs : taille(range),zone,famille -- RESTRICT ALL
                elseif ($_SESSION['recherche']=='Manege'){
                    echo "<div class='group5'>";
                    echo "<fieldset><legend>Taille entre :</legend><input class='petitChamp' type='text' pattern='[0-9]+' placeholder='TailleMin (cm)' name='Taille1'> 
                            <br>et <br><input class='petitChamp' type='text' placeholder='TailleMax (cm)' pattern='[0-9]+' name='Taille2'></fieldset>";
                    echo "</div>";
                    echo "<div class='group4'>";
                    $requetef="select libelleF from Famille";
                    $resf=mysqli_query($idcom,$requetef);

                    if ($resf){
                        echo "<fieldset><legend>Famille : </legend>";
                        while($row=mysqli_fetch_array($resf)){
                            echo "$row[0] :<input type='checkbox' name='Famille[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    }
                    else{
                        echo "Problème pour Famille";
                    }
                    echo "</div>";
                    echo "<div class='group3'>";
                    $requetez="select nomZ from Zone";
                    $resz=mysqli_query($idcom,$requetez);
                    if ($resz){
                        echo "<fieldset><legend>Zone : </legend>";
                        while($row=mysqli_fetch_array($resz)){
                            echo "$row[0] :<input type='checkbox' name='Zone[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    }
                    else{
                        echo "Problème pour Zone";
                    }
                    echo "</div>";
                }
                //CHOIX RECHERCHE MANEGE -- Recherche : nomB -- Champs : type,zone -- RESTRICT ALL
                elseif ($_SESSION['recherche']=='Boutique'){
                    echo "<div class='group4'>";
                    $requetet = "select distinct typeB from Boutique";
                    $rest = mysqli_query($idcom, $requetet);
                    if ($rest) {
                        echo "<fieldset><legend>Type de boutique : </legend>";
                        while($row=mysqli_fetch_array($rest)){
                            echo "$row[0] :<input type='checkbox' name='Type[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    } else {
                        echo "Problème pour Type de Boutique";
                    }
                    echo "</div>";
                    echo "<div class='group3'>";
                    $requetez="select nomZ from Zone";
                    $resz=mysqli_query($idcom,$requetez);
                    if ($resz){
                        echo "<fieldset><legend>Zone : </legend>";
                        while($row=mysqli_fetch_array($resz)){
                            echo "$row[0] :<input type='checkbox' name='Zone[]' value='$row[0]'>";
                            echo "<br />";
                        }
                        echo "</fieldset>";
                    }
                    else{
                        echo "Problème pour Zone";
                    }
                    echo "</div>";
                }
            }

            ?>
        <div class="group6" >
            <input type="submit" name='submit' id="submit" value="Rechercher">
        </div>
    </div>
</form>
<script>
    let input = document.getElementById("recherche");
    input.addEventListener('keydown', (event) => {
        if (event.code === 'Enter') {
            event.preventDefault();
            document.getElementById("submit").click();
        }
    });
</script>
    <?PHP
    //AFFICHAGE DES RESULTATS DE LA RECHERCHE APRES REQUETE SQL
    if(!empty($_POST['submit'])){
        echo "<div class='bloc'>";
        echo "<div class='group'>Résultat de la recherche</div>";
        echo "<div id='grouptab'><table style='border:solid;'>";

            /* RESULTAT POUR PERSONNEL */
            if($_SESSION['recherche']=='Personnel'){
                echo "<th>NumSS</th><th>Nom</th><th>Prénom</th>";
                $requete="SELECT P.NumSS, P.nomP, P.prenomP FROM Personnel P,Metier M WHERE P.Metier=M.Metier";
                if($_POST['typeR'] == "NumSS" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND P.NumSS LIKE '$val%'";
                }
                elseif ($_POST['typeR'] == "Nom" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND P.nomP LIKE '%$val%'";
                }
                elseif ($_POST['typeR'] == "Prenom" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND P.prenomP LIKE '%$val%'";
                }
                if(!empty($_POST['Resp'])){
                    $val=$_POST['Resp'];
                    $requete=$requete." AND (P.chef=1 OR P.responsable=1)";
                }
                if(!empty($_POST['Job'])){
                    $var=$_POST['Job'];
                    $requete=$requete." AND (P.Metier = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR P.Metier = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if((!empty($_POST['signe']))&&(!empty($_POST['date']))){
                    $val=$_POST['date'];
                    if ($_POST['signe'] == "=") {
                        $requete = $requete." AND date_naissance=str_to_date('$val','%Y-%m-%d')";
                    }
                    elseif ($_POST['signe'] == "<") {
                        $requete = $requete." AND date_naissance<str_to_date('$val','%Y-%m-%d')";
                    }else{
                        $requete = $requete." AND date_naissance>str_to_date('$val','%Y-%m-%d')";
                    }
                }
                if(!empty($_POST['Boutique'])){
                    $var=$_POST['Boutique'];
                    $requete=$requete." AND IdB in (SELECT IdB FROM Boutique WHERE nomB = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR nomB = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if(!empty($_POST['Atelier'])){
                    $var=$_POST['Atelier'];
                    $requete=$requete." AND IdA in (SELECT IdA FROM Atelier WHERE nomA = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR nomA = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
            }

            /* RECHERCHE POUR VENTE */
            elseif ($_SESSION['recherche']=='Vente'){
                echo "<th>Nom Objet</th>";
                $requete="SELECT O.nomO, O.IdO FROM Objet O,TypeObjet T,Boutique B WHERE O.IdB=B.IdB AND O.IdT=T.IdT AND O.DateVente IS NOT NULL";
                if(!empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND O.NomO LIKE '%$val%'";
                }
                if(!empty($_POST['Boutique'])){
                    $var=$_POST['Boutique'];
                    $requete=$requete." AND (B.nomB = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR B.nomB = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if(!empty($_POST['TpObj'])){
                    $var=$_POST['TpObj'];
                    $requete=$requete." AND (T.libelleT = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR T.libelleT = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if((!empty($_POST['Prix1']))&&(!empty($_POST['Prix2']))){
                    $val1=min($_POST['Prix1'],$_POST['Prix2']);
                    $val2=max($_POST['Prix1'],$_POST['Prix2']);
                    $requete=$requete." AND O.Prix BETWEEN $val1 AND $val2";
                }
                if((!empty($_POST['signe']))&&(!empty($_POST['date']))){
                    $val=$_POST['date'];
                    if ($_POST['signe'] == "=") {
                        $requete = $requete." AND O.DateVente=str_to_date('$val','%Y-%m-%d')";
                    }
                    elseif ($_POST['signe'] == "<") {
                        $requete = $requete." AND O.DateVente<str_to_date('$val','%Y-%m-%d')";
                    }else{
                        $requete = $requete." AND O.DateVente>str_to_date('$val','%Y-%m-%d')";
                    }
                }
            }
/* RESULTAT POUR Inventaire */
            elseif ($_SESSION['recherche']=='Inventaire'){
                echo "<th>Nom de l'Objet/Pièce détachée</th>";
                $requete1="SELECT O.nomO,O.IdO FROM Objet O,Boutique B, TypeObjet T WHERE O.IdB=B.IdB AND O.IdT=T.IdT";
                $requete2="SELECT PC.nomPC, PC.NumSerie FROM PiecesDetachees PC, Atelier A WHERE PC.IdA=A.IdA ";
                if($_POST['table'] == "bout" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete1=$requete1." AND O.nomO LIKE '%$val%'";
                }
                elseif ($_POST['table'] == "atel" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete2=$requete2." AND PC.nomPC LIKE '%$val%'";
                }
                elseif ($_POST['table'] == "both" && !empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete1=$requete1." AND O.nomO LIKE '%$val%'";
                    $requete2=$requete2." AND PC.nomPC LIKE '%$val%'";
                }
                if((!empty($_POST['Prix1']))&&(!empty($_POST['Prix2']))){
                    $val1=min($_POST['Prix1'],$_POST['Prix2']);
                    $val2=max($_POST['Prix1'],$_POST['Prix2']);
                    $requete1=$requete1." AND O.Prix BETWEEN $val1 AND $val2";
                }
                if(!empty($_POST['vente'])){
                    $var=$_POST['vente'];
                    if($var=='oui'){
                        $requete1=$requete1." AND O.DateVente IS NOT NULL";
                    }elseif ($var=='non'){
                        $requete1=$requete1." AND O.DateVente IS NULL";
                    }
                }
                if(!empty($_POST['Boutique'])){
                    $var=$_POST['Boutique'];
                    $requete1=$requete1." AND (B.nomB = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete1=$requete1." OR B.nomB = '$var[$i]'";
                    }
                    $requete1=$requete1.")";
                }
                if(!empty($_POST['TpObj'])){
                    $var=$_POST['TpObj'];
                    $requete1=$requete1." AND (T.libelleT = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete1=$requete1." OR T.libelleT = '$var[$i]'";
                    }
                    $requete1=$requete1.")";
                }
                if(!empty($_POST['Atelier'])){
                    $var=$_POST['Atelier'];
                    $requete2=$requete2." AND (A.nomA = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete2=$requete2." OR A.nomA = '$var[$i]'";
                    }
                    $requete2=$requete2.")";
                }
                if ($_POST['table']=="bout"){
                    $requete=$requete1;
                    $get="IdO=";
                }elseif ($_POST['table']=="atel"){
                    $requete=$requete2;
                    $get="";
                }else{
                    $requete="$requete1 UNION $requete2";
                    $get="";
                }
            }
            /* RESULTAT POUR Manege */
            elseif ($_SESSION['recherche']=='Manege'){
                echo "<th>Nom du Manege</th>";
                $requete="SELECT DISTINCT M.NomM FROM Manege M, Famille F, Zone Z WHERE Z.IdZ=M.IdZ AND M.IdF=F.IdF";
                if(!empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND M.NomM LIKE '%$val%'";
                }
                if((!empty($_POST['Taille1']))&&(!empty($_POST['Taille2']))){
                    $val1=min($_POST['Taille1'],$_POST['Taille2']);
                    $val2=max($_POST['Taille1'],$_POST['Taille2']);
                    $requete=$requete." AND M.tailleMin BETWEEN $val1 AND $val2";
                }
                if(!empty($_POST['Famille'])){
                    $var=$_POST['Famille'];
                    $requete=$requete." AND (F.libelleF = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR F.libelleF = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if(!empty($_POST['Zone'])){
                    $var=$_POST['Zone'];
                    $requete=$requete." AND (Z.nomZ = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR Z.nomZ = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
            }

            /* RESULTAT POUR BOUTIQUE */
            else{
                $requete="SELECT DISTINCT B.NomB,B.IdB FROM Boutique B, Zone Z WHERE Z.IdZ=B.IdZ";
                echo "<th>Nom de la boutique</th>";
                if(!empty($_POST['Nom'])){
                    $val=$_POST['Nom'];
                    $requete=$requete." AND B.NomB LIKE '%$val%'";
                }
                if(!empty($_POST['Type'])){
                    $var=$_POST['Type'];
                    $requete=$requete." AND (B.typeB = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR B.typeB = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
                if(!empty($_POST['Zone'])){
                    $var=$_POST['Zone'];
                    $requete=$requete." AND (Z.nomZ = '$var[0]'";
                    for($i=1;$i<count($var);$i++){
                        $requete=$requete." OR Z.nomZ = '$var[$i]'";
                    }
                    $requete=$requete.")";
                }
            }
        $result=mysqli_query($idcom,$requete);
        if ($result){
            echo "<br>";
            while($row=mysqli_fetch_array($result)){
                if($_SESSION['recherche']=="Personnel"){
                    echo "<tr>  <td>"."<a href='SearchResult/personnel.php?NumSS=".$row[0]."' target='_blank'>".$row[0]."</a></td>
                                <td>"."<a href='SearchResult/personnel.php?NumSS=".$row[0]."' target='_blank'>".$row[1]."</a></td>
                                <td>"."<a href='SearchResult/personnel.php?NumSS=".$row[0]."' target='_blank'>".$row[2]."</a></td>
                          </tr>";
                }
                elseif($_SESSION['recherche']=="Vente"){
                    echo "<tr><td>"."<a href='SearchResult/vente.php?IdO=".$row[1]."' target='_blank'>".$row[0]."</a>"."</td></tr>";
                }
                elseif($_SESSION['recherche']=="Inventaire"){
                    echo "<tr><td>"."<a href='SearchResult/inventaire.php?Id=".$row[1]."' target='_blank'>".$row[0]."</a>"."</td></tr>";
                }
                elseif($_SESSION['recherche']=="Manege"){
                    echo "<tr><td>"."<a href='SearchResult/manege.php?NomM=".$row[0]."' target='_blank'>".$row[0]."</a>"."</td></tr>";
                }
                else{//Boutique
                    echo "<tr><td>"."<a href='SearchResult/boutique.php?IdB=".$row[1]."' target='_blank' >".$row[0]."</a>"."</td></tr>";
                }
            }
        }
        else
        {
            echo "PB";
        }
        echo "</table></div>";
    }
    ?>
        </div>
</body>
</html>
<?PHP
mysqli_close($idcom);
}else{
	echo "Merci de vous connecter <a href='../index.php'>log in </a>";
}
?>