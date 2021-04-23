<?php
	$titre = 'Details des Spectacles';
	include('entete.php');

	// construction de la requete
	$requete = ("
		                    SELECT noSpec, nomS
                    	 	FROM theatre.LesSpectacles 

	");
  $requete1 = ("
                        SELECT noSpec, to_char(daterep,'Day, DD-Month-YYYY HH:MI'), COUNT(noSerie) AS NombrePlacesReservees
                        FROM theatre.LesRepresentations NATURAL LEFT JOIN theatre.LesTickets 
                        WHERE noSpec = :n 
                        GROUP BY noSpec, dateRep  
                        
					"); 



	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable

	// execution de la requete
	$ok = @oci_execute ($curseur);

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
			echo "<p class=\"erreur\"><b>Representation inconnu</b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>noSpec</th><th>nomS</th><th>dateRep</th><th>NombrePlacesReservees</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noSpec = oci_result($curseur, 1) ;
				$nomS = oci_result($curseur, 2);
        
        // analyse de la 2eme requete  et association au curseur2
				$curseur2 = oci_parse ($lien, $requete1) ;
				oci_bind_by_name ($curseur2,':n', $noSpec); // association de la variable noSpec au curseur 2
				$ok2 = @oci_execute ($curseur2);
        
        	if (!$ok2) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur2);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	
				$res2 = oci_fetch ($curseur2);
			
				do{
					$dateRep = oci_result($curseur2, 2) ;
					$NombrePlacesReservees = oci_result($curseur2, 3) ;					 
	        echo "<tr><td>$noSpec</td><td>$nomS</td><td>$dateRep</td><td>$NombrePlacesReservees</td></tr>";					


				} while (oci_fetch($curseur2));
				
			
			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);


	include('pied.php');

?>
