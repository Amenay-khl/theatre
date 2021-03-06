<?php
  $noSpec = $_POST['noSpec'];
  $dateRep1 = $_POST['dateRep1'];
  $dateRep2 = $_POST['dateRep2'];
  

	$titre = 'Les dates du spectacle Les enfoirés';
	include('entete.php');
 

	// construction des requêtes
	$requete1 = "DELETE FROM LesRepresentations where dateRep=to_date(:n,'Day, DD-Month-YYYY HH24:MI')";
 
	

	// analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete1) ;
   oci_bind_by_name ($curseur, ':n', $dateRep1);

	// execution de la requete
	$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		echo LeMessage ("majRejetee") ;
		$e = oci_error ($curseur);
		echo LeMessageOracle ($e['code'], $e['message']) ;

		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
  $requete2 = ("insert into LesRepresentations values (to_date(:z ,'DD-MM-YYYY HH24:MI'),:v)");

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;
     oci_bind_by_name ($curseur, ':v', $noSpec);
     oci_bind_by_name ($curseur, ':z', $dateRep2);
     

		// execution de la requete
		$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {

			echo LeMessage ("majRejetee") ;
			$e = oci_error ($curseur);
			echo LeMessageOracle ($e['code'], $e['message']) ;

			// terminaison de la transaction : annulation
			oci_rollback ($lien) ;

		}
		else {

			echo LeMessage ("majOK") ;
      
			// terminaison de la transaction : validation
			oci_commit ($lien) ;

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
