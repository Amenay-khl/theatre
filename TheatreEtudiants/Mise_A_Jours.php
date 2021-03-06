<?php

	$titre = 'Les dates du spectacle Les enfoirés';
	include('entete.php');

	// construction des requêtes
	
        $requete1 = " INSERT INTO LesSpectacles (noSpec, nomS)
                    SELECT noSpec,nomS FROM theatre.LesSpectacles ";

        $requete2 = "INSERT INTO LesCategories (nomC, prix)
                    SELECT nomC,prix FROM theatre.LesCategories" ;

        $requete3 = "INSERT INTO LesRepresentations (dateRep, noSpec)
                    SELECT dateRep,noSpec FROM theatre.LesRepresentations ";

        $requete4 = "INSERT INTO LesZones (noZone, nomC)
                    SELECT noZone,nomC FROM theatre.LesZones" ;

        $requete5 = "INSERT INTO LesPlaces (noPlace, noRang, noZone)
                      SELECT distinct noPlace,noRang,noZone FROM theatre.LesPlaces" ; 

        $requete6 = "INSERT INTO LesDossiers (noDossier, montant)
                      SELECT noDossier , sum(prix) as montant FROM theatre.LesZones natural join theatre.LesCategories natural join theatre.LesPlaces 
                      natural join theatre.LesTickets group by noDossier order by noDossier";

        $requete7 = "INSERT INTO LesTickets (noSerie, noSpec,dateRep,noPlace,noRang,dateEmiss,noDossier)
                      SELECT * FROM theatre.LesTickets where (noSerie, noSpec) in (select noSerie, noSpec from LesRepresentations)" ; 
                      
        
                      
	// analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete1) ;
 
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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete2) ;

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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete3) ;

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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete4) ;

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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete5) ;

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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete6) ;

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

		// analyse de la requete 2 et association au curseur
		$curseur = oci_parse ($lien, $requete7) ;

		// execution de la requete
		$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;
		
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

	}}}}}}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
