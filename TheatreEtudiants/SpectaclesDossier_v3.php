<?php
	$titre = 'Liste des dossiers';
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT distinct noDossier
		FROM theatre.LesTickets
		ORDER BY noDossier
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
			echo "<p class=\"erreur\"><b> dossier inconnu</b></p>" ;

		}
		else {

			// on affiche le formulaire de s�lection
			echo ("
				<form action=\"SpectaclesDossier_v3_action_0.php\" method=\"post\">
					<label for=\"inp_Dossier\">Selectionnez un numero de dossier :</label>
					<select id=\"inp_Dossier\" name=\"noDossier\">
			");

			// cr�ation des options
			do {

				$noDossier = oci_result($curseur, 1);
				echo ("<option value=\"$noDossier\">$noDossier</option>");

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


  // travail à réaliser


	include('pied.php');

?>
