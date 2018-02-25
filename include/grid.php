<ul id="og-grid" class="og-grid">
﻿<?php
$PageName = "Liste des films";
$reponse = $conn->query('SELECT * FROM film');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>


<!-- Affichage -->
<li>
<?php

	echo'
		<span class="vignette">
			<a class="titre">'. $donnees['nom'] .'</a>
			<a href="index.php?vu='. $donnees['id'] .'" name="btn-vu" class="btn_vu" title="Ajouter '. $donnees['nom'] .' aux films déjà vu" alt="Ajouter-vu">+</a>
			</br>
			<a href="index.php?cin&pid='. $donnees['id'] .'">
			<img src=" '. $donnees['ImgUrl'] .' "/></a>
		</span>
	';

?>
</li>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
</ul>
