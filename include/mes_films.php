<div class="titre-page">
	Liste de mes films déjà vu
</div>
<ul id="og-grid" class="og-grid">

<?php
if (!isset($_SESSION['user'])) {
	header("Location: index.php");
	exit;
}

$reponse = $conn->query('SELECT nom, film.id idfilm, film_vu.id idvu, ImgUrl FROM film, film_vu WHERE film.id = id_film AND id_membre = ' . $_SESSION['id']);
$count = $reponse->rowCount();

if ($count == 0){
	echo '
	<div class="MsgError">
		<br><br>
		Vous n\'avez ajouté aucun film à votre liste 
	</div>';
}

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{


	echo'
	<li>
		<span class="vignette">
			<a class="titre">'. $donnees['nom'] .'</a>
			<a href="index.php?del='. $donnees['idvu'] .'" name="btn-del" class="btn_del" title="Supprimer '. $donnees['nom'] .' des films déjà vu" alt="Supprimer-vu">x</a>
			</br>
			<a href="index.php?cin&pid='. $donnees['idfilm'] .'">
			<img src=" '. $donnees['ImgUrl'] .' "/></a>
		</span>
	</li>
	';

}

$reponse->closeCursor(); // Termine le traitement de la requête pour qu'elle puisse être réexecuter

?>

</ul>
