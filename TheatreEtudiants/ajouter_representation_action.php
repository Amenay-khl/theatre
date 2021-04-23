<?php
 $dateRep = $_POST['dateRep'];
  $noSpec = $_POST['noSpec'];
  
 
	$titre = 'AJOUT DU SPECTACLE  '.$noSpec;
	include('entete.php');

	// construction des requêtes

 
	
	$requete = "INSERT INTO LesRepresentations values (to_date(:n, 'DD-MM-YYYY HH24:MI'),:v)";

	// analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
  oci_bind_by_name ($curseur,':n', $dateRep);
  oci_bind_by_name ($curseur,':v', $noSpec);

	// execution de la requete
	$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		echo LeMessage ("majRejetee")."<br /><br />";
		$e = oci_error($curseur);
  
		echo LeMessageOracle ($e['code'], $e['message']);
		

		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}

		else {

			echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;

		}

	

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
