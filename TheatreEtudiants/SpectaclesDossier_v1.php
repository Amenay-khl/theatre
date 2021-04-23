<?php

	$titre = 'Liste des places associées au dossier 11 pour une catégorie donnée';
	include('entete.php');

	// affichage du formulaire
	
	echo ("
		<form action=\"SpectaclesDossier_v1_action.php\" method=\"post\">
					<label for=\"sel_categorie\">Selectionnez une categorie :</label>
					<select id=\"sel_categorie\" name=\"nomC\">
                  <option value=\"1er balcon\">1er balcon</option>
                  <option value=\"2nd balcon\">2nd balcon</option>
                  <option value=\"orchestre\">orchestre</option>
                  <option value=\"poulailler\">poulailler </option>
                  
      </select> 
      <br /><br />  
      <div class=\"centre\"> 
      <input type=\"submit\" value=\"Valider\" />
      </div>  
			
		
		</form>
	");
 


	include('pied.php');

?>
