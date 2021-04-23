<?php

	$titre = 'representations sans places reservees';
	include('entete.php');

	// construction de la requete
	$requete = ("
		select to_char(dateRep,'Day, DD-Month-YYYY HH:MI'),noSpec from theatre.LesRepresentations 
    where (dateRep,noSpec) not in (select distinct dateRep,noSpec from theatre.LesTickets)
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
			echo "<p class=\"erreur\"><b> Spectacle inconnu </b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>Dates des spectacles sans reservations</th><th>noSpec</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$dateRep = oci_result($curseur,1) ;
        $noSpec = oci_result($curseur,2) ;
				echo "<tr><td>".$dateRep."</td><td>".$noSpec."</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
