<link rel="stylesheet" href="formulaire.css">
<?php

require 'require_connexion_bdd.php';

$offreNom = [];
$partenaireNom = [];

$query = $connexion->prepare("SELECT Nom_Offre,Id_Offre FROM offre ");
$query->execute();

$offre = $query->fetchAll();

$offreNom[] = "aucun";
foreach ($offre as $element) {
	$offreNom[] = $element['Nom_Offre'];
};

$query = $connexion->prepare("SELECT Nom_Partenaire,Id_Partenaire FROM partenaire ");
$query->execute();

$partenaire = $query->fetchAll();

$partenaireNom[] = "aucun";
foreach ($partenaire as $element) {
	$partenaireNom[] = $element['Nom_Partenaire'];
};

$erreurs = [];

if (empty($_POST) === false) {

	// Vérification des données saisies
	
	$expressionReguliere = '/[\d\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

	if (empty($_POST['nomMessage']) === false) {
		if (preg_match($expressionReguliere, $_POST['nomMessage'])) {
			$erreurs['nomMessage'] = "Le nom ne doit pas contenir de chiffres et de caractères spéciaux.";
		}else {
			if (strlen($_POST['nomMessage']) > 100) {
				$erreurs['nomMessage'] = 'Le nom ne doit pas dépasser 100 caractères.';
			}
		}
	}

	if (empty($_POST['prenomMessage']) === false) {
		if (preg_match($expressionReguliere, $_POST['prenomMessage'])) {
			$erreurs['prenomMessage'] = "Le Prénom ne doit pas contenir de chiffres et de caractères spéciaux.";
		}else {
			if (strlen($_POST['prenomMessage']) > 100) {
				$erreurs['prenomMessage'] = 'Le prénom ne doit pas dépasser 100 caractères.';
			}
		}
	}

	if (empty($_POST['emailMessage'])) {
		$erreurs['emailMessage'] = 'Veuillez saisir une adresse email.';
	} else {
		if (filter_var($_POST['emailMessage'], FILTER_VALIDATE_EMAIL) === false) {
			$erreurs['emailMessage'] = 'Veuillez saisir une adresse email valide.';
		}
	}

    if (empty($_POST['contenuMessage'])) {
		$erreurs['contenuMessage'] = 'Veuillez saisir un message.';
	} else {
		if (strlen($_POST['contenuMessage']) > 3000) {
			$erreurs['contenuMessage'] = 'Le message ne doit pas dépasser 3000 caractères.';
		}
	}

//	var_dump(($_POST['nomPartenaire']) === $partenaireNom[] = "aucun");
//	var_dump(($_POST['nomPartenaire']) != $partenaireNom[] = "aucun");

    if (empty($erreurs)) {
        try {
			
            $requeteInsertion = $connexion->prepare('INSERT INTO message (Nom_Message, Prenom_Message, Email_Message, Contenu_Message, Id_Offre, Id_Partenaire) VALUES (:Nom_Message, :Prenom_Message, :Email_Message, :Contenu_Message, :Id_Offre, :Id_Partenaire)');
            $requeteInsertion->bindParam(':Nom_Message', $_POST['nomMessage']);
            $requeteInsertion->bindParam(':Prenom_Message', $_POST['prenomMessage']);
            $requeteInsertion->bindParam(':Email_Message', $_POST['emailMessage']);
			$requeteInsertion->bindParam(':Contenu_Message', $_POST['contenuMessage']);
       
			if (($_POST['nomOffre']) != $partenaireNom[] = "aucun") {
			
				$requeteInsertion->bindParam(':Id_Offre', $_POST['nomOffre']);
			}else {
				$_POST['nomOffre'] = null;
				$requeteInsertion->bindParam(':Id_Offre', $_POST['nomOffre']);
			}

			if (($_POST['nomPartenaire']) != $partenaireNom[] = "aucun") {
			
				$requeteInsertion->bindParam(':Id_Partenaire', $_POST['nomPartenaire']);           
			}else {
				$_POST['nomPartenaire'] = null;
				$requeteInsertion->bindParam(':Id_Partenaire', $_POST['nomPartenaire']);
			}

            $requeteInsertion->execute();

            echo 'Votre demande a bien été prise en compte.';
        } catch (\Exception $exception) {
            echo 'Erreur lors de l\'ajout du message';
        }
    }
}

?>
<div class= "container">
	<h3 class="titre_form">Contactez-nous</h3>
		<form action="#" method="POST" class="contact-form">
		
		<div>
			<label for="nomMessage">Nom</label>
			<?= isset($erreurs['nomMessage']) ? $erreurs['nomMessage'] : null; ?>
			<input type="nomMessage" name="nomMessage" value="<?= isset($_POST['nomMessage']) ? $_POST['nomMessage'] : null; ?>">
		</div>

        <div>
			<label for="prenomMessage">Prénom</label>
			<?= isset($erreurs['prenomMessage']) ? $erreurs['prenomMessage'] : null; ?>
			<input type="prenomMessage" name="prenomMessage" value="<?= isset($_POST['prenomMessage']) ? $_POST['prenomMessage'] : null; ?>">
		</div>

        <div>
			<label for="emailMessage">Email</label>
			<?= isset($erreurs['emailMessage']) ? $erreurs['emailMessage'] : null; ?>
			<input type="emailMessage" name="emailMessage" value="<?= isset($_POST['emailMessage']) ? $_POST['emailMessage'] : null; ?>">
		</div>

        
        <div>
			<label for="contenuMessage">Contenu</label>
			<textarea name="contenuMessage"><?= isset($_POST['contenuMessage']) ? $_POST['contenuMessage'] : ''; ?></textarea>
			<?= isset($erreurs['contenuMessage']) ? $erreurs['contenuMessage'] : null; ?>
		</div>

        <div>
			<label for="nomOffre">Offre</label>
			<select name="nomOffre" id="nomOffre">
				<?php foreach ($offreNom as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['nomOffre']) && $_POST['nomOffre'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['nomOffre']) ? $erreurs['nomOffre'] : null; ?>
		</div>

        <div>
			<label for="nomPartenaire">Partenaire</label>
			<select name="nomPartenaire" id="nomPartenaire">
				<?php foreach ($partenaireNom as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['nomPartenaire']) && $_POST['nomPartenaire'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['nomPartenaire']) ? $erreurs['nomPartenaire'] : null; ?>
		</div>


        <div>
			<input type="submit" name="validation" class="send-button">
		</div>

		<div class="map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2606.8555700187317!2d2.5862228768817648!3d49.20329937637187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e630cfeb73f31d%3A0x48c819ca44bf7503!2sLyc%C3%A9e%20Priv%C3%A9%20Saint%20Vincent%20de%20Senlis!5e0!3m2!1sfr!2sfr!4v1682076006016!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
</form>
</div>