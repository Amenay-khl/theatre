<?php
	
  $titre = 'DATE DES REPRESENTATIONS';
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
			echo "<p class=\"erreur\"><b> Representation inconnu</b></p>" ;

		}
		else {
 
			// on affiche le formulaire de sélection des dossiers
			echo ("
				<form action=\"modifier_representation_action.php\" method=\"POST\">
			  <label for=\"inp_dateRep1\">selectionnez une date :</label>
					<select id=\"inp_dateRep1\" name=\"dateRep1\">
			");
 
			// création des options
			do {

				$dateRep1 = oci_result($curseur, 1);
				echo ("<option value=\"$dateRep1 \">$dateRep1</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select> <br></br >"); 
			
      // on valide le formulaire
      echo ("	  
          <br></br >
		    	<h4>Veuillez saisir la nouvelle representation (numero-date) </h4> 
		    	<input type=\"number\" name=\"noSpec\" min=\"1\" max =\"3\"  placeholder=\"1,2 ou 3 \"/>
		    	<input type=\"text\" name=\"dateRep2\"  placeholder=\"DD-MM-YYYY HH24:MI \" />
		    	<br /><br />
			    <input type=\"submit\" value=\"modifier\" />
			    <input type=\"reset\" value=\"Annuler\" />
                       
				</form>
			"); 
      
      

		}

	}
 	// on libère le curseur
	oci_free_statement($curseur);


	include('pied.php');
 ?>
 
 