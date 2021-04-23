<?php
session_start();
$_SESSION['noSerie']=$_POST['noSerie'];
$noSerie=$_POST['noSerie'];

include('entete.php');


	// construction de la requete
	$requete = ("
		delete from  LesTickets where noSerie=:n
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// affectation de la variable
	oci_bind_by_name ($curseur, ':n', $noSerie);
	
	

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passÃ©
	if (!$ok) {

		// oci_execute a Ã©chouÃ©, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {
     $res = oci_fetch ($curseur);
  
  	
  echo "<b>votre 1ere reseravation a ete annulee avec succes</b>";
    
      }
	
 	// construction de la requete de la nouvelle reservation
	$requete = ("
		SELECT noSpec
		FROM LesSpectacles order by noSpec
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
				<form action=\"modifier_reservation_action1.php\" method=\"POST\">
			  <label for=\"inp_noSpec\">choisissez un autre spectacle :</label>
					<select id=\"inp_noSPec\" name=\"noSpec\">
			");
 
			// création des options
			do {

				$noSpec = oci_result($curseur, 1);
				echo ("<option value=\"$noSpec\">$noSpec</option>");

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
 ?>
 
<div align = "center">  <h3> Voici le nom des spectacles </h3></div>

<?php
//2eme partie qui donne Le nom des spectacles associé à leur numeros
   $requete2 = ("
		SELECT noSpec,nomS
		FROM LesSpectacles 
		order by noSPec
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete2) ;

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passÃ©
	if (!$ok) {

		// oci_execute a Ã©chouÃ©, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a rÃ©ussi, on fetch sur le premier rÃ©sultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun rÃ©sultat
			echo "<p class=\"erreur\"><b> Spectacle inconnu </b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>noSpec</th><th>nomS</th></tr>" ;

			// on affiche un rÃ©sultat et on passe au suivant s'il existe
			do {

				$noSPec = oci_result($curseur,1) ;
        $nomS = oci_result($curseur,2) ;
				echo "<tr><td>".$noSPec."</td><td>".$nomS."</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);


	include('pied.php');

?>
 
