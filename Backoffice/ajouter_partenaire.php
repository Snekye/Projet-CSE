<link rel="stylesheet" href="formulaire.css">
<?php

// !!! nouvelle requête pour insérer l'image dans la table image 
require 'require_connexion_bdd.php';

require("require_deconnexion.php");



//$imagePartenaire = 39;

//$imagePartenaire =36;

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

	if (empty($_POST['lienPartenaire'])){
		$erreurs['lienPartenaire'] = 'Veuillez saisir le lien du partenaire';
	}else {
		if(filter_var($_POST['lienPartenaire'], FILTER_VALIDATE_URL) === false){
			$erreurs['lienPartenaire'] = 'Veuillez saisir un lien valide';
		}

	}

	if (empty($_POST['nomImagePartenaire'])){
		$erreurs['nomImagePartenaire'] = 'Veuillez saisir le lien d\'une image';
	}else {
		if(filter_var($_POST['nomImagePartenaire'], FILTER_VALIDATE_URL) === false){
			$erreurs['nomImagePartenaire'] = 'Veuillez saisir un lien d\'image valide';
		}

	}

	if (empty($erreurs)){
		try {
			$requeteInsertionImage = $connexion->prepare('INSERT INTO image (Nom_Image) VALUES(:Nom_Image)');
			$requeteInsertionImage->bindParam(':Nom_Image',$_POST['nomImagePartenaire']);

			$requeteInsertionImage->execute();
			

			$query = $connexion->prepare("SELECT MAX(Id_Image) From image");
			$query->execute();

			$imagePartenaire = $query->fetchColumn();


		}catch (\Exception $exception) {
			$message = 'Erreur lors de l\'ajout de l\'image';
			$erreurs['Lien_Image'] = 'erreur';
	}
}

    if (empty($erreurs)) {
        try {

            $requeteInsertion = $connexion->prepare('INSERT INTO Partenaire (Nom_Partenaire, Description_Partenaire, Lien_Partenaire, Id_Image) VALUES (:Nom_Partenaire, :Description_Partenaire, :Lien_Partenaire, :Id_Image)');
            $requeteInsertion->bindParam(':Nom_Partenaire', $_POST['nomPartenaire']);
            $requeteInsertion->bindParam(':Description_Partenaire', $_POST['descriptionPartenaire']);
            $requeteInsertion->bindParam(':Lien_Partenaire', $_POST['lienPartenaire']);        
            $requeteInsertion->bindParam(':Id_Image', $imagePartenaire); 

            $requeteInsertion->execute();
			
            $message = 'Votre demande a bien été prise en compte.';
        } catch (\Exception $exception) {
            $message = 'Erreur lors de l\'ajout du partenaire';
			$erreurs['Nom_Image'] = 'erreur';
        }
    }
	
	
}
require 'require_popup.php';

?>
<div class= "container">
<h3 class="titre_form">Ajoutez une partenaire</h3>
<form action="#" method="POST" class="contact-form">
		
		<div>
			<label for="nomPartenaire">Nom du partenaire</label>
			<?= isset($erreurs['nomPartenaire']) ? $erreurs['nomPartenaire'] : null; ?>
			<input type="nomPartenaire" name="nomPartenaire" value="<?= isset($_POST['nomPartenaire']) ? $_POST['nomPartenaire'] : null; ?>">
		</div>

        <div>
			<label for="descriptionPartenaire">Description du partenaire</label>
			<textarea name="descriptionPartenaire"><?= isset($_POST['descriptionPartenaire']) ? $_POST['descriptionPartenaire'] : ''; ?></textarea>
			<?= isset($erreurs['descriptionPartenaire']) ? $erreurs['descriptionPartenaire'] : null; ?>
		</div>

        <div>
			<label for="lienPartenaire">Lien du partenaire</label>
			<?= isset($erreurs['lienPartenaire']) ? $erreurs['lienPartenaire'] : null; ?>
			<input type="lienPartenaire" name="lienPartenaire" value="<?= isset($_POST['lienPartenaire']) ? $_POST['lienPartenaire'] : null; ?>">
		</div>

        <div>
			<label for="nomImagePartenaire">Image du partenaire</label>
			<?= isset($erreurs['nomImagePartenaire']) ? $erreurs['nomImagePartenaire'] : null; ?>
			<input type="nomImagePartenaire" name="nomImagePartenaire" value="<?= isset($_POST['nomImagePartenaire']) ? $_POST['nomImagePartenaire'] : null; ?>">
		</div>

        <div>
			<input type="submit" name="validation" class="send-button">
		</div>
</form>
</div>