<?php

	$titre = 'Details des Spectacles';
	include('entete.php');

	// construction de la requete
	$requete = ("
		select S.nomS, S.noSpec,to_char(R.daterep,'Day, DD-Month-YYYY HH:MI'),count(T.noPlace) as NbPlaces from theatre.LesSpectacles S left join theatre.LesRepresentations R  on (S.noSpec=R.noSpec) left join theatre.LesTickets T on (T.dateRep=R.dateRep)
    group by S.noSpec, R.dateRep, S.nomS
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
			echo "<table><tr><th>nomS</th><th>noSpec</th><th>dateRep</th><th>NbPlaces</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {
       
        $nomS = oci_result($curseur,1); 
				$noSpec = oci_result($curseur,2) ;
        $dateRep = oci_result($curseur,3) ;
        $NbPlaces = oci_result($curseur,4) ;
        
				echo "<tr><td>".$nomS."</td><td>".$noSpec."</td><td>".$dateRep."</td><td>".$NbPlaces."</td></tr>";

			} while (oci_fetch ($curseur)); 

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
