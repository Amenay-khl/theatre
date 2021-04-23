<?php

	$titre = 'Liste des spectacles';
	include('entete.php');

	$requete = ("
		SELECT nomS
		FROM lesSpectacles
		
	");

	// affichage du formulaire
		$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	  $ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a reuussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>pas de Spectacle ou Spectacle inconnu </b></p>" ;

		}
		else {

			// on affiche le formulaire de selection
			echo ("
				  <form action=\"reservation_place_action.php\" method=\"post\">
					<label for=\"inp_nomS\">choisissez un spectacle:</label>
					<select id=\"inp_nomS\" name=\"nomS\">
			");

			// creation des options
			do {

				$nomS = oci_result($curseur, 1);
				echo ("<option value=\"$nomS\">$nomS</option>");

			} while ($res = oci_fetch ($curseur));

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
