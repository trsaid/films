<table>
   <tr>
       <th>Nom</th>
       <th>Affiche</th>
       <th>Edit</th>
   </tr>
﻿<?php
$PageName = "Liste des films";
$reponse = $conn->query('SELECT * FROM film');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>

<?php

	echo'
		<tr>
			<td><a>'. $donnees['nom'] .'</a></td>
			<td><a href="index.php?cin&pid='. $donnees['id'] .'"><img src=" '. $donnees['ImgUrl'] .'" height="40%"/></td>
			<td><a>Modifier</a> <br/> <a>supprimer</a></td>
		</tr>
	';

?>
<?php

}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
</table>