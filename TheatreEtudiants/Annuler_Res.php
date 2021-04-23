<?php

	$titre = 'ANNULATION DE VOTRE RESERVATION';
	include('entete.php');

	// affichage du formulaire
	echo ("
		<form action=\"Annuler_Res_action.php\" method=\"POST\">
			<label for=\"inp_Ticket\">Veuillez renseigner votre numero de ticket :</label>
			<input type=\"text\" name=\"noSerie\"  placeholder=\"exemple: 999 \" />
			<br /><br />
   <input type=\"submit\" value=\"Valider\" />
			
		</form>
	");

	include('pied.php');

?>
