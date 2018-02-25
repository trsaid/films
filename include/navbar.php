<?php

echo '

<a href="index.php"><strong><i class="fa fa-home" aria-hidden="true"></i> Accueil</strong></a>

<a href="index.php?random"><strong><i class="fa fa-random" aria-hidden="true"></i> Random</strong></a>
';

if (isset($_SESSION['user'])) {
	echo '
	<a href="index.php?films"><strong>Mes films</strong></a>
	<a href="index.php?search"><strong>Recherche</strong></a>
	<span class="right">
	<a>Bienvenue ' . $_SESSION['user'] . ' !</a>';
	if ($_SESSION['grade'] == '1') {
			echo '
	<a href="/index.php?admin"><strong>Admin</strong></a>';
	}
	echo '
	<a href="/index.php?logout"><strong>Déconnection</strong></a>
	</span>';
}
else {
	echo '
	<a href="index.php?search"><strong>Recherche</strong></a>
	<span class="right">
	<div id="menu1" onclick="afficheMenu(this)">
	<a id="user" onclick="afficheMenu(this)"><strong><i class="fa fa-user" aria-hidden="true"></i> Compte <i class="fa fa-caret-down" aria-hidden="true"></i></strong></a>
	</div>
	<div id="sousmenu1" style="display:none">
		<div class="sousmenu">
			<a href="index.php?register">Inscription</a>
		</div>
		<div class="sousmenu">
			<a href="index.php?login">Connexion</a>
		</div>
	</div>';
	
}

echo '</span>';
?>
