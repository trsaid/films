<?php
$query = $conn->prepare('SELECT id FROM film');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_COLUMN, 0); //fetchAll : Retourne un tableau contenant toutes les lignes
$vu = $_GET['vu'];
			
if (isset($_GET['vu']) AND in_array($vu, $result)) {
	
	if (!isset($_SESSION['user'])) { //Vérification si connecté
		$ErrorT = 'Action impossible !';
		$VuError = 'Vous devez être connecté pour ajouté un film à vos films déjà vu. </br> Redirection en cours...';
		header("refresh:2;url=index.php?login");
	}
	else {
		$reponse = $conn->query("SELECT * FROM film WHERE id = " . $_GET['vu']);
		$reponse->execute();
		$donnees = $reponse->fetch();
		
		$idm = $_SESSION['id'];
		$add = $_GET['vu'];
		$query = $conn->prepare('SELECT id_film, id_membre FROM film_vu WHERE id_film= :idfilm AND id_membre = :idmembre');
		$query->bindValue('idfilm', $add, PDO::PARAM_STR);
		$query->bindValue('idmembre', $idm, PDO::PARAM_STR);;
		$query->execute();
		$count = $query->rowCount();
		
		if ($count != 0) { //Vérification si le film éxiste déjà dans la liste des déjà vu
			$ErrorT = 'Action impossible !';
			$VuError = ''.$donnees['nom'].' est déjà dans vos films déjà vu. </br> Redirection en cours...';
			header("refresh:2;url=index.php");
		}
		else {
			$idm = $_SESSION['id'];
			$query = $conn->prepare('INSERT INTO film_vu(id_film, id_membre) VALUES(:idfilm, :idmembre)');
			$query->bindValue('idfilm', $add, PDO::PARAM_STR);
			$query->bindValue('idmembre', $idm, PDO::PARAM_STR);;
			$query->execute();
			$ErrorT = 'Votre liste a été mis à jour.';
			$VuError = ''.$donnees['nom'].' a été ajouté aux films déjà vu.';
			header("refresh:2;url=index.php?films");
		}
	}
}
else {
	$ErrorT = 'Erreur !';
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