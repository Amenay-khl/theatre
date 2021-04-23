<?php

	session_start();
	$_SESSION['noRang']=$_POST['noRang'];
	$noRang=$_POST['noRang'];
  $noPlace=$_SESSION['noPlace'];
  $dateRep=$_SESSION['dateRep'];
  $noSpec = $_SESSION['noSpec'];
	$titre = "places Disponibles  ";
	include('entete.php');


		 $dateEmission= date("Y-m-d H:i:s");
     $dateRep=date('Y-m-d H:i', strtotime($dateRep));


 if ($dateEmission>$dateRep)
 
   {echo "la representation du <b>".$dateRep."</b> est expiree veuillez changer de date de representation ";}


 else{

   $requete1 = ("select max(noSerie),max(noDossier) from Theatre.LesTickets");
   $curseur = oci_parse ($lien, $requete1) ;
		
	// execution de la requete
	 $ok0 = @oci_execute($curseur);
   $res = oci_fetch ($curseur);
	  do {

	    $noSerie= oci_result($curseur,1);
	    $noDossier=oci_result($curseur,2);      
      } 
  
    while (oci_fetch ($curseur));


	$noSerie= $noSerie+1;
  $noDossier=$noDossier+1;
	
	$requete2 = ("
		insert into lesTickets (noSerie,noSpec,dateRep,noPlace,noRang,dateEmiss,noDossier)values (:o,:p,to_date(:q,'YYYY-MM-DD HH24:MI'),:r,:s,to_date(:t,'YYYY-MM-DD     HH24:MI'),:u)");

		
 		$dateRep=date('Y-M-d H:i', strtotime($dateRep));
		$dateEmission= date("Y-M-d H:i");

		$curseur = oci_parse ($lien, $requete2) ;
		oci_bind_by_name ($curseur, ':o', $noSerie);
		oci_bind_by_name ($curseur, ':p', $noSpec);
		oci_bind_by_name ($curseur, ':q', $dateRep);
		oci_bind_by_name ($curseur, ':r', $noPlace);
		oci_bind_by_name ($curseur, ':s', $noRang);
		oci_bind_by_name ($curseur, ':t', $dateEmission);
		oci_bind_by_name ($curseur, ':u', $noDossier);
		
	// execution de la requete
	$ok = @oci_execute ($curseur) ;
  if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {echo "votre reservation a ete modifie avec succes";
			// on affiche le ticket
			echo"votre ticket";
			echo"<br></br>
				<table><tr><th>noserie</th><th>noSpec</th><th>dateRep</th><th>noplace</th><th>norang</th><th>dateemmision</th><th>nodossier</th></tr>
				<tr><td>$noSerie</td><td>$noSpec</td><td>$dateRep</td><td>$noPlace</td><td>$noRang</td><td>$dateEmission</td><td>$noDossier</td></tr></table>	";
		}
	oci_free_statement($curseur);


include('pied.php');	}

	// on libère le curseur
?>
