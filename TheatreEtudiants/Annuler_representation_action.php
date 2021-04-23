<?php
session_start();
$_SESSION['dateRep']=$_POST['dateRep'];

	// récupération des variables
	$dateRep = $_POST['dateRep'];

	$titre = "Détails de la representation a suprimer";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT nomS,noSpec, to_char(dateRep,'Day, DD-Month-YYYY HH24:MI')
		FROM LesRepresentations natural join LesSpectacles
		WHERE dateRep = to_date(:n,'Day, DD-Month-YYYY HH24:MI')
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur,':n', $dateRep);

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
			echo "<p class=\"erreur\"><b>representation inconnu</b></p>" ;

		}
		else {
         
			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>nomS</th><th>noSpec</th><th>dateRep</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {
        $nomS = oci_result($curseur, 1) ;
				$noSpec = oci_result($curseur, 2) ;
				$dateRep = oci_result($curseur, 3) ;
				
				echo "<tr><td>$nomS</td><td>$noSpec</td><td>$dateRep</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
       
      echo (" 
		        <form action=\"Annuler_representation_action1.php\" method=\"POST\">
            <label for=\"inp_Ticket\">voullez vous vraiment annuler cette representation? Cliquez sur supprimer pour continuer :</label>
		      	<input type=\"submit\" value=\"Supprimer\" />
		    		</form>
	          ");
		}

	}
 

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
