<!DOCTYPE html>
<html>
<?php
	// ob_start();
	session_start();
	include 'include/dbconnect.php';
?>

	<head>
		<meta charset="UTF-8" />
		<title>Films</title>
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="https://use.fontawesome.com/856c8e9e8f.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>
	
	<header>
		<div class="Menu clearfix">
			<?php
			include 'include/navbar.php';
			?>
		</div>
	</header>
	
	<body>
		<div class="main">
			<?php
				if(isset($_GET['films'])){
					include 'include/mes_films.php';
				}
				else if(isset($_GET['cin'])){
					include 'include/grid1.php';
				}
				else if(isset($_GET['login'])){
					include 'include/login.php';
				}
				else if(isset($_GET['logout'])){
					include 'include/logout.php';
				}
				else if(isset($_GET['register'])){
					include 'include/register.php';
				}
				else if(isset($_GET['vu'])){
					include 'include/add_vu_film.php';
				}
				else if(isset($_GET['del'])){
					include 'include/del_vu_film.php';
				}
				else if(isset($_GET['random'])){
					include 'include/random.php';
				}
				else if(isset($_GET['admin'])){
					include 'include/admin.php';
				}
				else if(isset($_GET['search'])){
					include 'include/search.php';
				}
				else{
					include 'include/grid.php';
				}
			?>
		</div>
	</body>
</html>
