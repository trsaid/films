<?php
if (isset($_SESSION['user']) != "") {
	$reponse = $conn->query('SELECT film.id FROM film WHERE film.id NOT IN (SELECT id_film FROM film_vu WHERE id_membre = '. $_SESSION['id'] .')');
	$reponse->execute();
	$result = $reponse->fetchAll(PDO::FETCH_COLUMN, 0); //fetchAll : Retourne un tableau contenant toutes les lignes
	$count = $reponse->rowCount();
	$reponse->closeCursor();
	
	
	if ($count > 0){
		$Film = array_rand($result, 1);
		header('Location: index.php?cin&pid='.$result[$Film].'');
	}else {
		echo '
		<div class="MsgError">
			<br><br>
			Il semble que vous ayez déjà tous les films disponibles dans votre liste de déjà vu. 
		</div>';
	}
	
}else {
	$reponse = $conn->query('SELECT film.id FROM film');
	$reponse->execute();
	$result = $reponse->fetchAll(PDO::FETCH_COLUMN, 0); //fetchAll : Retourne un tableau contenant toutes les lignes
	$reponse->closeCursor();
	$Film = array_rand($result, 1);
	
	header('Location: index.php?cin&pid='.$result[$Film].'');
}
?>