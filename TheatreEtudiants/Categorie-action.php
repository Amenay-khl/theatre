<?php
$noDossier = $_POST['noDossier'];

	// récupération des variables saisis
  $noDossier = $_POST['noDossier'];
  $nomC = $_POST['nomC']; 
	//
	$titre = "Liste des places associées au dossier $noDossier et pour la catégorie $nomC";
	include('entete.php');
 
	// construction de la requete qui permet d'afficher les N� de places associ� au dossier selectionn� et la categorie choisi
	$requete = ("
		SELECT noPlace, noRang, noZone, nomS, noDossier
		FROM theatre.LesSieges natural join theatre.LesZones natural join theatre.LesCategories natural join theatre.LesTickets natural join theatre.LesSpectacles
		where nomC='$nomC'  and noDossier=$noDossier   	 
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
 
	 // oci_execute a réussi, on fetch sur le premier résultat de la 1ere requette
	$res = oci_fetch ($curseur);

		if (!$res) {
  // construction de la 2eme requette qui nous donnera le nom de la categorie pour le dossier choisi
			$requete2 = ("
		  SELECT distinct nomC
		  FROM theatre.LesCategories natural join theatre.LesPlaces natural join theatre.LesZones natural join theatre.LesTickets
      where noDossier = $noDossier	
	                ");
 	

	    // analyse de la requete et association au curseur
	    $curseur = oci_parse ($lien, $requete2) ;
 	
	    // execution de la requete
	    $ok = @oci_execute ($curseur) ;

	    // on teste $ok pour voir si oci_execute s'est bien pass�
	
	  	$res2 = oci_fetch ($curseur);
      $nomC2 = oci_result($curseur, 1);
    
      //construction de la 3eme requette qui nous donnera les numeros de dossier pour la categorie choisi(inverse de la requette2)
      $requete3 = ("
		  SELECT distinct  noDossier
		  FROM theatre.LesCategories natural join theatre.LesPlaces natural join theatre.LesZones natural join theatre.LesTickets
      where nomC= '$nomC' order by noDossier 
	                ");
       
       // analyse de la requete et association au curseur
       $curseur1 = oci_parse ($lien, $requete3) ;
 	
      // execution de la requete 3
      $ok1 = @oci_execute ($curseur1) ;

	    // on teste $ok1 pour voir si oci_execute s'est bien pass�
	    $res3 = oci_fetch ($curseur1);

 
			// on affiche le nom de la categorie qu'il fallait choisir pour le dossier choisi(requette2), et on affiche inversement  les numeros de dossier pour la            categorie choisie(requette3)
			
      echo ("
      <i><b>aucune place disponible!</b></i>
      <br /><br />
				pour le <b>dossier numero $noDossier </b> le nom de la categorie pour laquelle il existe encore des places est <b>$nomC2</b>. <br /><br />
        vous trouverez ci-dessous la liste des numeros de dossier qui ont des places disponibles pour la categorie <b> $nomC </b> :        
			");	

		  echo "<table><tr><th>noDossier</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {
        $noDossier = oci_result($curseur1, 1) ;
				echo "<tr><td>$noDossier</td></tr>";
         } 

      while (oci_fetch ($curseur1));

			echo "</table>";
  	}  // fin if (!$res)
   
		else {

			// else (res) on affiche la table qui va servir a la mise en page du resultat requette 1
			echo "<table><tr><th>Spectacle</th><th>Place</th><th>Rang</th><th>Zone</th><th>noDossier</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$noPlace = oci_result($curseur, 1) ;
				$noRang = oci_result($curseur, 2) ;
				$noZone = oci_result($curseur, 3) ;
				$nomS = oci_result($curseur, 4) ;
        $noDossier = oci_result($curseur, 5) ;
				echo "<tr><td>$nomS</td><td>$noPlace</td><td>$noRang</td><td>$noZone</td><td>$noDossier</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');
 

?>
