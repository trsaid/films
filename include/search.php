<meta charset="utf-8" />
<form method="GET" class="search">
	<center>
	<i id="Loupe" class="fa fa-search" aria-hidden="true"></i>
	<input class="searchbar" type="search" name="search" title="Rechercher" autocomplete="off" placeholder="Rechercher" value="">
	</center>
</form>
<?php

$film = $conn->prepare('SELECT nom, ImgUrl, com FROM film ORDER BY id DESC');
$film->execute();
if(isset($_GET['search']) AND !empty($_GET['search'])) {
	$search = htmlspecialchars($_GET['search']);
	$film = $conn->prepare('SELECT nom, ImgUrl, com FROM film WHERE CONCAT(nom, com, genre) LIKE "%'.$search.'%" ORDER BY id DESC');
	$film->execute();
}
if (!empty($_GET['search'])){
	if($film->rowCount() > 0) {
?>
	<ul>
	<?php while($Result = $film->fetch()) { 
		$msg = preg_replace('#(^|\s)('.$search.')(\s|$)#', '\1<mark>\2</mark>\3', $Result);
		
		
	?>
			<div class="SearchList">
				<div class="SearchList2"><?= $msg['nom'] ?></div>
				<div><img class="SearchList2" src="<?= $Result['ImgUrl'] ?>" /></div>
				<div><a id="descri" class="SearchList2"><?= $msg['com'] ?></a></div>
			</div>
	<?php } ?>
	</ul>
<?php
	} else {
		echo 'Aucun résultat pour: '.$search.'';
	}
}
?>