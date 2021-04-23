<?php
	session_start();

	$_SESSION['noSpec']=$_POST['noSpec'];
	$noSpec = $_POST['noSpec'];
  $noSerie=$_SESSION['noSerie'];
	$titre = "dates du spectacle ". $noSpec  ;
	include('entete.php');
	

	$requete = ("
		SELECT to_char(dateRep,'Day, DD-Month-YYYY HH:MI') as dateRep from LesSpectacles natural join  LesRepresentations  
		where noSpec=:n order by dateRep
		
	");

	// affichage du formulaire
		$curseur = oci_parse ($lien, $requete) ;
		oci_bind_by_name ($curseur, ':n', $noSpec);
	// execution de la requete

	$ok = @oci_execute ($curseur) ;
	

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>pas de dates disponible pour ce spectacle </b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"modifier_reservation_action2.php\" method=\"post\">
					<label for=\"inp_dateRep\">choisissez une date :</label>
					<select id=\"inp_dateRep\" name=\"dateRep\">
			");

			// création des options
			do {

				$dateRep = oci_result($curseur, 1);
				echo ("<option value=\"$dateRep\">$dateRep</option>");

			} 
      while ($res = oci_fetch ($curseur));

			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
				</form>
			");

		}

	}


	// on libère le curseur
	oci_free_statement($curseur);
	

	
	

	include('pied.php');

?>
