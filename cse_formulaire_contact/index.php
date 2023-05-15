<?php

require 'includes/connexion_bdd.php';


// Filtres PHP (utilisés notamment avec filter_var)
// https://www.php.net/manual/fr/filter.filters.php

require 'includes/sujets.php';

$vide = '';
$erreurs = [];

if (isset($_POST["email"])) {
	$email = $_POST["email"];
}
if (isset($_POST["prenom"])) {
	$prenom = $_POST["prenom"];
}
if (isset($_POST["nom"])) {
	$nom = $_POST["nom"];
}

if (isset($_POST["contenu"])) {
	$contenu = $_POST["contenu"];
}

if (empty($_POST) === false) {

	// Vérification des données saisies
	if (empty($_POST['email'])) {
		$erreurs['email'] = 'Veuillez saisir une adresse email.';
	} else {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$erreurs['email'] = 'Veuillez saisir une adresse email valide.';
		}
	}

	if (empty($_POST['contenu'])) {
		$erreurs['contenu'] = 'Veuillez saisir un contenu.';
	} else {
		if (strlen($_POST['contenu']) > 2000) {
			$erreurs['contenu'] = 'Le contenu ne doit pas dépasser 2000 caractères.';
		}
	}

	$expressionReguliere = '/[\d\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

	if (empty($_POST['prenom']) === false) {
		if (preg_match($expressionReguliere, $_POST['prenom'])) {
			$erreurs['prenom'] = 'Le prénom ne doit pas contenir de chiffres et de caractères spéciaux.';
		}
	}

	if (empty($_POST['nom']) === false) {
		if (preg_match($expressionReguliere, $_POST['nom'])) {
			$erreurs['nom'] = 'Le nom ne doit pas contenir de chiffres et de caractères spéciaux.';
		}
	}

	

	// Insertion des données si aucune erreur
	if(empty($erreurs)){
	// METTRE CODE AVEC INSERT ICI
		$query = $connexion -> prepare('INSERT INTO contact (contact_nom, contact_prenom, contact_email, contact_contenu) VALUES ( :contact_nom, :contact_prenom, :contact_email, :contact_contenu)');

		$query->bindParam(':contact_nom', $nom);
		var_dump($nom);
		$query->bindParam(':contact_prenom', $prenom);
		var_dump($prenom);
		$query->bindParam(':contact_email', $email);
		var_dump($email);
		$query->bindParam(':contact_contenu', $contenu);
		var_dump($contenu);
		$query->execute();

		//debugage
		$query->errorInfo();
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contactez-nous</title>

	<link rel="stylesheet" href="style.css">
</head>
<body>

	<?php
		require 'includes/header.php';
	?>

	<section>
		<div class="contact-container">
			<div class="form-container">
				<h3>Contactez-nous</h3>

				<form action="#" method="POST" class="contact-form">
		
					<div>
						<input type="text" name="nom" placeholder="Votre nom" required value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom'], ENT_QUOTES) : ''; ?>">
						<?= isset($erreurs['nom']) ? $erreurs['nom'] : null; ?>
					</div>

					<div>
						<input type="text" name="prenom" placeholder="Votre prénom" required value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom'], ENT_QUOTES) : ''; ?>">
						<?= isset($erreurs['prenom']) ? $erreurs['prenom'] : null; ?>
					</div>


					<div>
						
						<input  type="email" name="email" placeholder="Entrer votre adresse e-mail" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
						<?= isset($erreurs['email']) ? $erreurs['email'] : null; ?>
					</div>


					<div>
						<textarea name="contenu" id="" cols="30" rows="10" placeholder="Ecrire votre message ici..." required value="<?php echo isset($_POST['contenu']) ? htmlspecialchars($_POST['contenu'], ENT_QUOTES) : ''; ?>"></textarea>
						<?= isset($erreurs['contenu']) ? $erreurs['contenu'] : null; ?>
					</div>

					<div>
						<input type="submit" name="Envoyer" class="send-button">
					</div>

					<div class="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2606.8555700187317!2d2.5862228768817648!3d49.20329937637187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e630cfeb73f31d%3A0x48c819ca44bf7503!2sLyc%C3%A9e%20Priv%C3%A9%20Saint%20Vincent%20de%20Senlis!5e0!3m2!1sfr!2sfr!4v1682076006016!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</form>

			</div>
		</div>
	</section>

</body>
</html>