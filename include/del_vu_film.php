<?php
if (isset($_SESSION['user'])) {
	$query = $conn->prepare('SELECT id FROM film_vu WHERE id_membre = '.$_SESSION['id'].'');
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_COLUMN, 0);
	$del = $_GET['del'];
	$idm = $_SESSION['id'];
}
else{
	$ErrorT = 'Action impossible !';
	$VuError = 'Vous devez être connecté pour utiliser cette option. </br> Redirection en cours...';
	header( "refresh:2;url=index.php?login" );
}

if (!isset($_SESSION['user'])) {
	$ErrorT = 'Action impossible !';
	$VuError = 'Vous devez être connecté pour utiliser cette option. </br> Redirection en cours...';
	header( "refresh:2;url=index.php?login" );
}
else if (isset($_GET['del']) AND in_array($del, $result)) {

	
	$query = $conn->prepare('SELECT id_film, id_membre FROM film_vu WHERE id_film = :idfilm AND id_membre = :idmembre');
	$query->bindValue('idfilm', $del, PDO::PARAM_STR);
	$query->bindValue('idmembre', $idm, PDO::PARAM_STR);;
	$query->execute();
	$count = $query->rowCount();
	
	if ($count < 0) {
		$ErrorT = 'Action impossible !';
		$VuError = 'Vous ne pouvez pas faire cela. </br> Redirection en cours...';
		header( "refresh:2;url=index.php" );
	}
	else {
		$reponse = $conn->query("SELECT * FROM film, film_vu WHERE film.id = film_vu.id_film and film_vu.id =".$del);
		$reponse->execute();
		$donnees = $reponse->fetch();

		$query = $conn->prepare('DELETE FROM film_vu WHERE id ='.$del);
		$query->bindValue('idfilm', $del, PDO::PARAM_STR);
		$query->bindValue('idmembre', $idm, PDO::PARAM_STR);;
		$query->execute();
		$ErrorT = 'Votre liste a été mis à jour.';
		$VuError = ''.$donnees['nom'].' a été supprimer de vos films déjà vu.';
		header( "refresh:2;url=index.php" );
	}
}
else {
	
	$VuError = "Page introuvable. </br> Redirection en cours...";
	header( "refresh:2;url=index.php" );
}

//On affiche un message selon le résultat de la requete
echo '
<div class="MsgError">
	'.$ErrorT.' <br><br>
	'.$VuError.'
</div>';
?>