<?php

	session_start();
	$_SESSION['dateRep']=$_POST['dateRep'];
	$dateRep=$_POST['dateRep'];
  $noSpec = $_SESSION['noSpec'];
  
	
	$titre = "Places disponibles pour le spectacle ";
	include('entete.php');
	

	$requete = ("
		select distinct noPlace from LesPlaces where noPlace not in(select noPlace from LesTickets where noSpec=:n  and dateRep=to_date(:v,'Day, DD-Month-YYYY HH:MI'))order by noPlace
		
	");

	// affichage du formulaire
		$curseur = oci_parse ($lien, $requete) ;
		oci_bind_by_name ($curseur, ':n',$noSpec);
		oci_bind_by_name ($curseur, ':v',$dateRep);
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
			echo "<p class=\"erreur\"><b>Aucun place dispo pour se spectacle </b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"modifier_reservation_action3.php\" method=\"post\">
					<label for=\"sel_nomS\">Sélectionnez une place :</label>
					<select id=\"sel_nomS\" name=\"noPlace\">
			");

			// création des options
			do {

				$noPlace = oci_result($curseur, 1);
				echo ("<option value=\"$noPlace\">$noPlace</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	
	

	include('pied.php');

?>
