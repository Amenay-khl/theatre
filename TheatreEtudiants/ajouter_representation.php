<?php

	$titre = 'DETAILS DE VOS RESERVATIONS';
	include('entete.php');

	// affichage du formulaire
	echo ("
		<form action=\"ajouter_representation_action.php\" method=\"POST\">
			<label for=\"inp_Ticket\">Veuillez renseigner une date  :</label>
			<input type=\"text\" name=\"dateRep\"  placeholder=\"DD-MM-YYYY HH24:MI \" />
      <br /><br />
      <label for=\"inp_Ticket\">Veuillez renseigner un numero de spectacle  :</label>
      <input type=\"text\" name=\"noSpec\"  placeholder=\"1,2 ou 3 \" />
			<br /><br />
   <input type=\"submit\" value=\"Valider\" />
			
		</form>
	");

	include('pied.php');

?>
