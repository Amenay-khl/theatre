<?php
session_start();
	$titre = 'MODIFICATION DES RESERVATIONS';
	include('entete.php');
	
 	// construction de la requete du 2eme formulaire
	$requete = ("
		SELECT noSerie
		FROM LesTickets order by noSerie
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
			echo "<p class=\"erreur\"><b> spectacle inconnu</b></p>" ;

		}
		else {
 
			// on affiche le formulaire de sélection des dossiers
			echo ("
				<form action=\"modifier_reservation_action.php\" method=\"POST\">
			  <label for=\"inp_noSpec\">selectionnez votre Ticket :</label>
					<select id=\"inp_noSPec\" name=\"noSerie1\">
			");
 
			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
				echo ("<option value=\"$noSerie \">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select>"); 
			
      // on valide le formulaire
      echo ("	 
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
 
 