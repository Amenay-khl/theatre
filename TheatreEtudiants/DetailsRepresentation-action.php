<?php
	$nomS = $_POST['nomS']; // on recup�re le nom du spectacle
	$titre = 'dates du spectacle'." ".$nomS;
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT noSpec,nomS,to_char(daterep,'Day, DD-Month-YYYY HH:MI') as daterep
		FROM theatre.LesRepresentations natural join theatre.LesSpectacles
		WHERE lower(nomS) = lower(:n)
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	$spectacle = "$nomS";
	oci_bind_by_name ($curseur,':n', $spectacle);

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

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>nomS</th><th>noSpec</th><th>Dates du spectacle</th></tr>" ;

			// on affiche un r�sultat et on passe au suivant s'il existe
			do {

			
        $nomS = oci_result($curseur,1) ;
        $noSpec = oci_result($curseur,2) ;
       	$dateRep = oci_result($curseur,3) ;
				echo "<tr><td>".$nomS."</td><td>".$noSpec."</td><td>".$dateRep."</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on lib�re le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
