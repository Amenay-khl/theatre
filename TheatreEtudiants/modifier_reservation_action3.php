<?php

	session_start();
	$_SESSION['noPlace']=$_POST['noPlace'];
	$noPlace=$_POST['noPlace'];
  $dateRep=$_SESSION['dateRep'];
  $noSpec = $_SESSION['noSpec'];
	$titre = "Rang associes a la place choisi ";
	include('entete.php');
	

	$requete = ("
		select distinct noRang from LesPlaces where noRang not in(select distinct noRang from LesTickets where noSpec=:n  and dateRep=to_date(:v,'Day, DD-Month-YYYY HH:MI') and noPlace=:w) order by noRang
		
	");

	// affichage du formulaire
		$curseur = oci_parse ($lien, $requete) ;
		oci_bind_by_name ($curseur, ':n', $noSpec);
		oci_bind_by_name ($curseur, ':v', $dateRep);
		oci_bind_by_name ($curseur, ':w', $noPlace);
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
			echo "<p class=\"erreur\"><b> pas de places disponible</b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"modifier_reservation_action4.php\" method=\"post\">
					<label for=\"sel_nomS\">choisissez un rang un rang  :</label>
					<select id=\"sel_nomS\" name=\"noRang\">
			");

			// création des options
			do {

				$noRang = oci_result($curseur, 1);
				echo ("<option value=\"$noRang\">$noRang</option>");

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

	
	

	include('pied.php');

?>
