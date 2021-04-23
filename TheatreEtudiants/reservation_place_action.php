<?php
	session_start();

	$_SESSION['nomS']=$_POST['nomS'];
	$nomS = $_POST['nomS'];
	$titre = "dates du spectacle ". $nomS  ;
	include('entete.php');
	

	$requete = ("
		SELECT to_char(dateRep,'Day, DD-Month-YYYY HH:MI') as dateRep from LesSpectacles natural join  LesRepresentations  
		where nomS=:n order by dateRep
		
	");

	// affichage du formulaire
		$curseur = oci_parse ($lien, $requete) ;
		oci_bind_by_name ($curseur, ':n', $nomS);
	// execution de la requete

	$ok = @oci_execute ($curseur) ;
	

	$requete1 = ("
		SELECT  noSpec from LesSpectacles S
		where nomS=:v
		
	");

	// affichage du formulaire
		$curseur1 = oci_parse ($lien, $requete1) ;
		oci_bind_by_name ($curseur1, ':v', $nomS);
	// execution de la requete

	  $ok1 = @oci_execute ($curseur1) ;
	
	
	do {

				
		$noSpec = oci_result($curseur1, 1);
			} 
      
   while (oci_fetch ($curseur1));
    	$_SESSION['noSpec']=$noSpec;
    	echo $noSpec;

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
			echo "<p class=\"erreur\"><b>pas de dates disponible pour ce spectacle </b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"reservation_place_action1.php\" method=\"post\">
					<label for=\"inp_dateRep\">choisissez une date :</label>
					<select id=\"inp_dateRep\" name=\"dateRep\">
			");

			// création des options
			do {

				$dateRep = oci_result($curseur, 1);
				echo ("<option value=\"$dateRep\">$dateRep</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
				</form>
			");

		}

	}


	// on libère le curseur
	oci_free_statement($curseur);
	oci_free_statement($curseur1);

	
	

	include('pied.php');

?>
