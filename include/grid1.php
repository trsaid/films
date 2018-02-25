<script type="text/javascript">
</script>
<?php
$pid    = $_GET['pid'];
$error  = false;
$MaNote = "";

//Récupération de l'ID du film.
$queryPid = $conn->query('SELECT id FROM film');
$result   = $queryPid->fetchAll(PDO::FETCH_COLUMN, 0); //fetchAll : Retourne un tableau contenant toutes les lignes
$queryPid->closeCursor();


//On affiche les infos du film si l'ID éxiste
if (isset($_GET['pid']) AND in_array($pid, $result)) {
	$reponse = $conn->query("SELECT * FROM film WHERE id = " . $pid);
	$reponse->execute();
	$donnees = $reponse->fetch();
	
	//Récupération de la note atribuer au film par l'utilisateur 
	if (isset($_SESSION['user']) != "") {
		$idm    = $_SESSION['id'];
		$query  = $conn->query('SELECT note FROM note, membres, film WHERE note.membre = ' . $idm . ' AND note.film = ' . $pid . '');
		$MaNote = $query->fetch();
	}
	
	//Calcule de la note moyenne
	$queryMoy = $conn->query('SELECT AVG(note) FROM note WHERE film = ' . $pid . '');
	$NoteMoy  = $queryMoy->fetch();
	$queryMoy->closeCursor();
	
	//Bouton "Déjà vu"
	if (isset($_POST['btn-vu'])) {
		header('location: index.php?vu=' . $pid . '');
	}
	//
	if (isset($_GET['pid']) AND isset($_GET['note']) AND in_array($pid, $result)) {
		$note = $_GET['note'];
		if (isset($_SESSION['user']) != "") {
			if ($note >= 1 AND $note <= 5) {
				$queryNote = $conn->prepare('SELECT film, membre FROM note WHERE film= :film AND membre = :membre');
				$queryNote->bindValue('film', $pid, PDO::PARAM_STR);
				$queryNote->bindValue('membre', $idm, PDO::PARAM_STR);
				;
				$queryNote->execute();
				$count = $query->rowCount();
				$queryNote->closeCursor();
				
				if ($count > 0) {
					$ErrMsg = 'Vous avez déjà attribué une note à ' . $donnees['nom'] . '';
				} else {
					$queryNote = $conn->prepare('INSERT INTO note(note, membre, film) VALUES(:note, :membre, :film)');
					$queryNote->bindValue('note', $note, PDO::PARAM_STR);
					$queryNote->bindValue('membre', $idm, PDO::PARAM_STR);
					$queryNote->bindValue('film', $pid, PDO::PARAM_STR);
					;
					$queryNote->execute();
					$queryNote->closeCursor();
					$ErrMsg = 'vous avez donné ' . $note . ' etoiles à ' . $donnees['nom'] . '';
				}
			} else {
				header("Location: index.php");
			}
		} else {
			$error   = true;
			$ErrorT  = 'Action impossible !';
			$VuError = 'Vous devez être connecté pour donné une note à un film. </br> Redirection en cours...';
			header("refresh:2;url=index.php?login");
		}
		
	}
	
	//Affichage image
	echo '
	<div class="film">
		<div class="pres">
			<a class="titre-desc">' . $donnees['nom'] . '</a></br></br>
			<img src=" ' . $donnees['ImgUrl'] . ' " class="imgT"/>
			<a>Durée : </a></br>
			<a>De : </a></br>
			<a>Pays : </a></br>
			<a>Genres : ' . $donnees['genre'] . '</a></br></br>
			
			<a> Attribuer une note à <b>' . $donnees['nom'] . '<b/> :</br>
			<div class="notation" id="note">
				<a onclick="refresh()" class="note" href="index.php?cin&pid=' . $pid . '&note=5" title="Donner 5 étoiles">★</a>
				<a class="note" href="index.php?cin&pid=' . $pid . '&note=4" title="Donner 4 étoiles">★</a>
				<a class="note" href="index.php?cin&pid=' . $pid . '&note=3" title="Donner 3 étoiles">★</a>
				<a class="note" href="index.php?cin&pid=' . $pid . '&note=2" title="Donner 2 étoiles">★</a>
				<a class="note" href="index.php?cin&pid=' . $pid . '&note=1" title="Donner 1 étoile">★</a>
			</div>
			' . $ErrMsg . '
			<div id="note1">
			Votre note : ' . $MaNote[0] . '/5
			<br>
			Note moyenne : ' . round($NoteMoy[0], 2) . '/5
			</div>
			<form method="post">
			<button type="button" class="btn btn-gris">Bande-annonce</button>
			<input type="submit" name="btn-vu" value="Déjà vu" class="btn btn-gris"></br></form>
			
		</div>
		<hr class="separateur">
		<div class="desc">
			<H1>Synopsis : </H1>
			<p>' . $donnees['com'] . '</p>
		</div>
	</div>
	
	';
}
//Sinon on redirige vers l'accueil
else {
	echo '
	<div class="MsgError">
		Erreur <br><br>
		Il n\'y a rien ici. Redirection...
	</div>';
	
	header("refresh:2;url=index.php");
}
if ($MaNote[0] >= 1){
	$nbr = $MaNote[0];
?>
<script type="text/javascript">
window.onload = function refresh() {
	var Note = <?= $nbr ?>;
	var x = document.getElementsByClassName("note");
	var i;
	for (i = 5 - Note; i <= 5; i++) {
		x[i].style.color = "Orange";
	}
};
</script>

<?php	
}
if ($error) {
	echo '
		<div class="MsgError">
			' . $ErrorT . ' <br><br>
			' . $VuError . '
		</div>';
}
?>