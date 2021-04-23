<?php
session_start(); //on demarre une session pour pouvoir stocker des variables de sessions qu'on poura utiliser dans la page suivante
$_SESSION['noDossier']=$_POST["noDossier"];
?>

<?php
  $noDossier = $_POST['noDossier'];
	$titre = 'Liste des categories';
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT distinct nomC
		FROM theatre.LesCategories natural join theatre.LesPlaces natural join theatre.LesZones natural join theatre.LesTickets
    where noDossier = $noDossier
     
		
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
			echo "<p class=\"erreur\"><b> il n'y a pas de categorie pour le dossier selectionne</b></p>" ;

		}
		else {
 
			// on affiche le formulaire de s�lection
			echo ("
				<form action=\"SpectaclesDossier_v3_action.php\" method=\"post\">
					<label for=\"inp_nomC\">Selectionnez une categorie :</label>
					<select id=\"inp_nomC\" name=\"nomC\">
			");

			// cr�ation des options
			do {

				$nomC = oci_result($curseur, 1);
				echo ("<option value=\"$nomC\">$nomC</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on lib�re le curseur
	oci_free_statement($curseur);


  // travail à réaliser
	

	include('pied.php');

?>
