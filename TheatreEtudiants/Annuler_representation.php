<?php
	
  $titre = 'Annuler une representation';
	include('entete.php');
	
 	// construction de la requete du 2eme formulaire
	$requete = ("
		SELECT to_char(dateRep,'Day, DD-Month-YYYY HH24:MI') as dateRep
		FROM LesRepresentations order by dateRep 
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
			echo "<p class=\"erreur\"><b> Representation inconnu</b></p>" ;

		}
		else {
 
			// on affiche le formulaire de s�lection des dossiers
			echo ("
				<form action=\"Annuler_representation_action.php\" method=\"POST\">
			  <label for=\"inp_dateRep\">selectionnez une date :</label>
					<select id=\"inp_dateRep\" name=\"dateRep\">
			");
 
			// cr�ation des options
			do {

				$dateRep = oci_result($curseur, 1);
				echo ("<option value=\"$dateRep \">$dateRep</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select> <br></br><br></br>
          <input type=\"submit\" value=\"Supprimer\" />
          </form>");
      
      

		}

	}
 	// on lib�re le curseur
	oci_free_statement($curseur);


	include('pied.php');
 ?>
 
 