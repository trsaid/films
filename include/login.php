<?php
// Redirection vers l'accueil  si déjà connecter
if (isset($_SESSION['user']) != "") {
	header("Location: index.php");
	exit;
}

$error = false;

if (isset($_POST['btn-login'])) {
	$name	= $_POST['name'];
	$pass	= $_POST['pass'];

	if (empty($name)) {
		$error		= true;
		$nameError = "Veuillez enter votre nom d'utilisateur.";
	}

	if (empty($pass)) {
		$error		= true;
		$passError	= "Veuillez enter votre mot de passe.";
	}

	if (!$error) {

		$password = hash('sha256', $pass);

		$query = $conn->prepare('SELECT id, pseudo, pass, grade FROM membres WHERE pseudo= :name');
		$query->bindValue('name', $_POST['name'], PDO::PARAM_STR);
		$query->execute();
		$row   = $query->fetch();
		$count = $query->rowCount();

		if ($count == 1 && $row['pass'] == $password) {
			$_SESSION['user'] = $row['pseudo'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['grade'] = $row['grade'];
			$errMSG = "Connexion réussi. Redirection...";
			header("Location: index.php");
		} else {
			$errMSG = "Nom de compte ou mot de passe incorrect.";
		}

	}

}
?>
		<form class="login" method="post" autocomplete="on">
			<ul class="form-style-1">
			<?php
			if ( isset($errMSG) ) {

			?>
				<div class="alert alert-danger">
					<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
				</div>
			<?php
			}
			?>
				<a class="titre-login"> Se connecter </a>

				<li><label>Identifiant <span class="required">*</span></label> <input class="field-divided" name="name" placeholder="Identifiant" type="text"></li>
				<span class="text-danger"><?php echo $nameError; ?></span>
				<li><label>Mot de passe <span class="required">*</span></label> <input class="field-long" name="pass" placeholder="Mot de passe" type="password"></li>
				<span class="text-danger"><?php echo $passError; ?></span>
				<li><input type="submit" value="Connexion" name="btn-login"></li>
			</ul>
		</form>
