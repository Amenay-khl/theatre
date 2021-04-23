<?php

	$titre = 'nom des spectacles';
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT nomS
		FROM theatre.LesSpectacles
		
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;



	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien pass�
	if (!$ok) {

		// oci_execute a �chou�, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a r�ussi, on fetch sur le premier r�sultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun r�sultat
			echo "<p class=\"erreur\"><b> Spectacle inconnu </b></p>" ;

		}
		else {

		echo ("
				<form action=\"DetailsRepresentation-action.php\" method=\"post\">
					<label>Selectionnez un spectacle :</label>
					<select id=\"sel_nomS\" name=\"nomS\">
			");

			// cr�ation des options
			do {

				$nomS = oci_result($curseur, 1);
				echo ("<option value=\"$nomS\">$nomS</option>");

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

	// on lib�re le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
