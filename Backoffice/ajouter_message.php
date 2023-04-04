<?php

require 'require_connexion_bdd.php';

$query = $connexion->prepare("SELECT MAX(Id_Image) From image");
$query->execute();

$imagePartenaire = $query->fetchAll();

//var_dump($imagePartenaire);


if (empty($_POST) === false) {

	// Vérification des données saisies
	
	$expressionReguliere = '/[\d\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

	if (empty($_POST['nomPartenaire']) === false) {
		if (preg_match($expressionReguliere, $_POST['nomPartenaire'])) {
			$erreurs['nomPartenaire'] = "Le nom du partenaire ne doit pas contenir de chiffres et de caractères spéciaux.";
		}
	}else {
        if (empty($_POST['nomPartenaire'])) {
            $erreurs['nomPartenaire'] = 'Veuillez saisir un nom de partenaire.';
        }

    }

    if (empty($_POST['descriptionPartenaire'])) {
		$erreurs['descriptionPartenaire'] = 'Veuillez saisir une description.';
	} else {
		if (strlen($_POST['descriptionPartenaire']) > 3000) {
			$erreurs['descriptionPartenaire'] = 'La description ne doit pas dépasser 3000 caractères.';
		}
	}


    if (empty($erreurs)) {
        try {

            $requeteInsertion = $connexion->prepare('INSERT INTO message (Nom_Message, Prenom_Message, Email_Message, Contenu_Message, Id_Offre, Id_Partenaire) VALUES (:Nom_Message, :Prenom_Message, :Email_Message, :Contenu_Message, :Id_Offre, :Id_Partenaire)');
            $requeteInsertion->bindParam(':Nom_Message', $_POST['nomMessage']);
            $requeteInsertion->bindParam(':Prenom_Message', $_POST['prenomMessage']);
            $requeteInsertion->bindParam(':Email_Message', $_POST['emailMessage']);
			$requeteInsertion->bindParam(':Contenu_Message', $_POST['contenuMessage']);
            $requeteInsertion->bindParam(':Id_Offre', $_POST['nomOffre']); 
            $requeteInsertion->bindParam(':Id_Partenaire', $_POST['nomPartenaire']);           
       
            $requeteInsertion->execute();

            echo 'Votre demande a bien été prise en compte.';
        } catch (\Exception $exception) {
            echo 'Erreur lors de l\'ajout du message';
        }
    }
}

?>

<form action="#" method="POST">
		
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
			<textarea name="contenuMessage"><?= isset($_POST['contenuMessage']) ? $_POST['contenuMessage'] : 'Votre contenu...'; ?></textarea>
			<?= isset($erreurs['contenuMessage']) ? $erreurs['contenuMessage'] : null; ?>
		</div>

        <div>
			<label for="nomOffre">Offre</label>
			<select name="nomOffre" id="nomOffre">
				<?php foreach ($partenaireOffre as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['nomOffre']) && $_POST['nomOffre'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['nomOffre']) ? $erreurs['nomOffre'] : null; ?>
		</div>

        <div>
			<label for="nomPartenaire">Partenaire</label>
			<select name="nomPartenaire" id="nomPartenaire">
				<?php foreach ($partenaireOffre as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['nomPartenaire']) && $_POST['nomPartenaire'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['nomPartenaire']) ? $erreurs['nomPartenaire'] : null; ?>
		</div>

        <div>
			<input type="submit" name="validation">
		</div>
</form>