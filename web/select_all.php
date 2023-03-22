<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lecture de la table article</title>
<style type="text/css" >
table {border-style:double;border-width: 3px;border-color: red;background-color: yellow;}
</style>
</head>
<body>
<?php
include("connex.inc.php");
$idcom=connex("nicolasauvray","myparam");
$requete="SELECT * FROM modele";
$result=@mysqli_query($idcom,$requete);
if(!$result)
{
	echo "Lecture impossible";
}
else
{
	$nbart=mysqli_num_rows($result);
	echo "<h4> Il y a $nbart lignes dans la table modele </h4>";
}
mysqli_free_result($result);
?>
</body>
</html>

