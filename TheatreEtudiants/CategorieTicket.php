<?php

	$titre = 'Liste des places associees au dossier et a la categorie choisies';
	include('entete.php');
	
 	// construction de la requete du 2eme formulaire
	$requete = ("
		SELECT distinct nomC
		FROM theatre.LesCategories natural join theatre.LesPlaces natural join theatre.LesZones natural join theatre.LesTickets		
	");
 
 $requete2 = ("
		SELECT distinct noDossier
		FROM theatre.LesCategories natural join theatre.LesPlaces natural join theatre.LesZones natural join theatre.LesTickets
    order by noDossier		
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
 	$curseur2 = oci_parse ($lien, $requete2) ;
	// execution de la requete
	$ok = @oci_execute ($curseur) ;
  $ok2 = @oci_execute ($curseur2) ;
	// on teste $ok pour voir si oci_execute s'est bien passé
	
  if (!$ok or !$ok2) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);
    $res2 = oci_fetch ($curseur2);

		if (!$res or !$res2) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b> pas de categorie pour le dossier selectionne ou dossier inconnu</b></p>" ;

		}
		else {
 
			// on affiche le formulaire de sélection des dossiers
			echo ("
				<form action=\"Categorie-action.php\" method=\"POST\">
			  <label for=\"inp_noDossier\">Selectionnez un dossier :</label>
					<select id=\"inp_noDossier\" name=\"noDossier\">
			");

			// création des options
			do {

				$noDossier = oci_result($curseur2, 1);
				echo ("<option value=\"$noDossier\">$noDossier</option>");

			} while ($res = oci_fetch ($curseur2));

			echo ("
					</select>"); 
			
      // on affiche les cases à cocher des categories
      echo ("	 
          <br /><br />
          
                  <input type=\"radio\" name=\"nomC\" value=\"1er balcon\" checked=\"checked\" /> 1er balcon 
                  <input type=\"radio\" name=\"nomC\" value=\"2nd balcon\" />   2nd balcon 
                  <input type=\"radio\" name=\"nomC\" value=\"orchestre\" /> orchestre 
                  <input type=\"radio\" name=\"nomC\" value=\"poulailler\"  /> poulailler 
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
 