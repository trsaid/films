<?php
if (isset($_SESSION['user']) != "") {
	header("Location: index.php");
}
$error = false;

if (isset($_POST['btn-signup'])) {
	$name	= $_POST['name'];
	$email	= $_POST['email'];
	$pass	= $_POST['pass'];
	$pass2	= $_POST['pass2'];

	//Verification pseudo
	if (empty($name)) {
		$error	 = true;
		$nameError = "Veuillez entrer un nom d'utilisateur.";
	} else if (strlen($name) < 5) {
		$error	 = true;
		$nameError = "Le nom d'utilisateur doit comporter au moins 5 caractères";
	} else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
		$error	 = true;
		$nameError = "Name must contain alphabets and space.";
	} else {
		$query = $conn->prepare('SELECT pseudo FROM membres WHERE pseudo= :name');
		$query->bindValue('name', $_POST['name'], PDO::PARAM_STR);
		$query->execute();
		$count = $query->rowCount();
		if ($count != 0) {
			$error	 = true;
			$nameError = "Ce nom d'utilisateur est déjà utilisé";
		}
	}

	//Vérification de l'adresse E-mail
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error	  = true;
		$emailError = "Veuillez entrer une adresse email valide.";
	} else { // Si la forme de l'email est valide, on férifie si elle n'existe pas déjà dans la base de donnée
		$query = $conn->prepare('SELECT email FROM membres WHERE email= :email');
		$query->bindValue('email', $_POST['email'], PDO::PARAM_STR);
		$query->execute();
		$count = $query->rowCount();
		if ($count != 0) { //Si elle éxiste déjà dans la base de donnée on retourne une erreur.
			$error		= true;
			$emailError = "Cette adresse E-mail est déjà utilisé";
		}
	}
	//Vérification du mot de passe
	if (empty($pass)) { //Si le mot de passe est vide on retourne une erreur.
		$error		= true;
		$passError	= "Veuillez entrer un mot de passe.";
	} else if (strlen($pass) < 6) { //Si le mot de passe contient moins de 6 caractères on retourne une erreur.
		$error		= true;
		$passError	= "Le mot de passe doit contenir au moins 6 charactères.";
	} else if ($pass2 != $pass){ //Vérification si les 2 mot de passes sont identique
		$error = true;
		$passError	= "Les 2 mots de passes doivent être identique.";
		$pass2Error	= "Les 2 mots de passes doivent être identique.";
	}

	// On crypte le mot de passe en SHA256
	$password = hash('sha256', $pass);

	// S'il n'y a aucune erreur, on crée le compte.
	if (!$error) {

		$query = $conn->prepare('INSERT INTO membres(pseudo,email,pass) VALUES(:name, :email,:pass)');
		$query->bindValue('name', $_POST['name'], PDO::PARAM_STR);
		$query->bindValue('email', $_POST['email'], PDO::PARAM_STR);
		$query->bindValue('pass', $password, PDO::PARAM_STR);
		$query->execute();

		$errMSG = "Votre compte a été créé avec succès";
		unset($name);
		unset($email);
		unset($pass);

	}
}
?>
		<form class="login" method="post" autocomplete="on">

			<ul class="form-style-1">
			<?php
				if ( isset($errMSG) ) {

				?>
			<div class="form-group">
				<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
					<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
				</div>
			</div><?php
				}
				?>
				<a class="titre-login"> Inscription </a>
				<li><label>Identifiant <span class="required">*</span></label> <input class="field-divided" name="name" placeholder="Entrez votre identifiant" type="text"></li>
				<li style="list-style: none"><span class="text-danger"><?php echo $nameError; ?></span></li>
				
				<li><label>E-mail <span class="required">*</span></label> <input class="field-divided" name="email" placeholder="Entrez votre E-mail" type="email"></li>
				<li style="list-style: none"><span class="text-danger"><?php echo $emailError; ?></span></li>
				
				<li><label>Mot de passe <span class="required">*</span></label> <input class="field-long" name="pass" placeholder="Entrez votre Mot de passe" type="password"></li>
				<li style="list-style: none"><span class="text-danger"><?php echo $passError; ?></span></li>
				
				<li><label>Confirmation <span class="required">*</span></label> <input class="field-long" name="pass2" placeholder="Confirmation" type="password"></li>
				<li style="list-style: none"><span class="text-danger"><?php echo $pass2Error; ?></span></li>
				
				<li><input name="btn-signup" type="submit" value="Confirmer"></li>
			</ul>
		</form>
