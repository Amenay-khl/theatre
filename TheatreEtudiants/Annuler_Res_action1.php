<?php
session_start();
$noSerie=$_SESSION['noSerie'];

include('entete.php');

	// construction de la requete
	$requete = ("
		delete from  LesTickets where noSerie=:n
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur, ':n', $noSerie);
	
	

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {echo "<b>votre reservation a ete annulee avec succes</b>";}
	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
