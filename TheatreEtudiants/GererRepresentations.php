<?php
	session_start();
	$login = $_SESSION['login'];
	$motdepasse = $_SESSION['motdepasse'];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>
   <title>Gestion du Théâtre : Menu </title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="style.css" rel="stylesheet" media="all" type="text/css">
</head>

<!-- procedures et fonctions pour les mises a jour du Théâtre
	 MC Fauvet, Mars 2015 -->
<body>

<?php require_once ("utils.php");

// si l'une des variables globales est sans valeur, cela signifie
// que le navigateur n'accepte pas les cookies. Inutile de continuer
if (!isset ($login) or !isset ($motdepasse)) {
	$codeerreur = "problemevariables" ;
	echo LeMessage ($codeerreur) ;
}
else {
   include_once("navigation.php");
?>

<h1> GESTION DE VOS REPRESENTATIONS </h1>


      <h2> CHOISISSEZ UNE ACTION </h2>
      <ul class="menu">
	      <li><a href="consulter_representation.php">consulter les representation</a> </li>
	      <li><a href="ajouter_representation.php"> ajouter une representation  </a></li>
        <li><a href="modifier_representation.php"> modifier une representation  </a></li>
	      <li><a href="Annuler_representation.php"> annuler une representation  </a> </li>
      </ul>
<?php } ?>
