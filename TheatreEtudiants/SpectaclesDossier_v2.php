<?php

	$titre = 'Liste des places associees au dossier 11 pour une categorie donnee';
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT nomC
		FROM theatre.LesCategories
		ORDER BY nomC
	");

	// analyse de la requete et association au curseur
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

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b> categorie inconnu</b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"SpectaclesDossier_v2_action.php\" method=\"post\">
					<label for=\"inp_categorie\">Selectionnez une categorie :</label>
					<select id=\"inp_categorie\" name=\"nomC\">
			");

			// création des options
			do {

				$nomC = oci_result($curseur, 1);
				echo ("<option value=\"$nomC\">$nomC</option>");

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
