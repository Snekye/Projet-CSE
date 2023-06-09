<link rel="stylesheet" href="formulaire.css">
<?php

require 'require_connexion_bdd.php';

require("require_deconnexion.php");

$partenaireOffre = [];

$query = $connexion->prepare("SELECT Nom_Partenaire,Id_Partenaire FROM partenaire ");
$query->execute();

$partenaire = $query->fetchAll();

foreach ($partenaire as $element) {
	$partenaireOffre[] = $element['Nom_Partenaire'];
};


$erreurs = [];

//var_dump($erreurs);

if (empty($_POST) === false) {

	// Vérification des données saisies
	
	$expressionReguliere = '/[\d\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

	if (empty($_POST['nomOffre'])) {
		$erreurs['nomOffre'] = 'Veuillez saisir le nom de l\'offre.';
	} else {
			if (empty($_POST['nomOffre']) === false) {
		if (preg_match($expressionReguliere, $_POST['nomOffre'])) {
			$erreurs['nomOffre'] = "Le nom de l'offre ne doit pas contenir de chiffres et de caractères spéciaux.";
		}
	}
}

    if (empty($_POST['descriptionOffre'])) {
		$erreurs['descriptionOffre'] = 'Veuillez saisir une description.';
	} else {
		if (strlen($_POST['descriptionOffre']) > 3000) {
			$erreurs['descriptionOffre'] = 'La description ne doit pas dépasser 3000 caractères.';
		}
	}
    //Date début Offre
	if (empty($_POST['dateDebutOffre'])){
		$erreurs['dateDebutOffre'] = 'Veuillez saisir une date de début de l\'offre.';
	} else {
		if(strlen($_POST['dateDebutOffre']) != 10){
				$erreurs['dateDebutOffre'] = 'Veuillez saisir une date de début de l\'offre valide';
			}
	}
    //Date Fin Offre
	if (empty($_POST['dateFinOffre'])){
		$erreurs['dateFinOffre'] = 'Veuillez saisir une date de fin d\'offre.';
	} else {
		if(strlen($_POST['dateFinOffre']) != 10){
				$erreurs['dateFinOffre'] = 'Veuillez saisir une date de fin d\'offre valide';
			}
	}
    //NB place min
	if (empty($_POST['nbPlaceMinOffre'])){
		$erreurs['nbPlaceMinOffre'] = 'Veuillez saisir un nombre minimum de place';
	}else {
		if (filter_var($_POST['nbPlaceMinOffre'], FILTER_VALIDATE_INT) === false){
			$erreurs['nbPlaceMinOffre'] = 'Veuillez saisir un nombre minimum de place valide';
		}
	}

	if (empty($_POST['nomImage1'])){
		$erreurs['nomImage1'] = 'Veuillez saisir le lien d\'une image';
	}else {
		if(filter_var($_POST['nomImage1'], FILTER_VALIDATE_URL) === false){
			$erreurs['nomImage1'] = 'Veuillez saisir un lien d\'image valide';
		}

	}

    if (empty($erreurs)) {
        try {
            $requeteInsertion = $connexion->prepare('INSERT INTO Offre (Nom_Offre, Description_Offre, Date_Debut_Offre, Date_Fin_Offre, Nombre_Place_Min_Offre, Id_Partenaire) VALUES (:Nom_Offre, :Description_Offre, :Date_Debut_Offre, :Date_Fin_Offre, :Nombre_Place_Min_Offre, :Partenaire_Offre)');
            $requeteInsertion->bindParam(':Nom_Offre', $_POST['nomOffre']);
            $requeteInsertion->bindParam(':Description_Offre', $_POST['descriptionOffre']);
            $requeteInsertion->bindParam(':Date_Debut_Offre', $_POST['dateDebutOffre']);          
            $requeteInsertion->bindParam(':Date_Fin_Offre', $_POST['dateFinOffre']);
            $requeteInsertion->bindParam(':Nombre_Place_Min_Offre', $_POST['nbPlaceMinOffre']);
            $requeteInsertion->bindParam(':Partenaire_Offre', $_POST['partenaireOffre']);

            $requeteInsertion->execute();

            
        } catch (\Exception $exception) {
            $message = 'Erreur lors de l\'ajout de l\'offre';
            // Debug de l'erreur :
            // var_dump($exception->getMessage());
        };

		try {
			$requeteInsertionImage = $connexion->prepare('INSERT INTO image (Nom_Image) VALUES (:Nom_Image)');
			$requeteInsertionImage->bindParam(':Nom_Image', $_POST['nomImage1'] );
			
		
			$requeteInsertionImage->execute();
			
		} catch (\Exception $exception) {
            $message = 'Erreur lors de l\'ajout de l\'offre';
            // Debug de l'erreur :
            // var_dump($exception->getMessage());
    };

	try {
		$query =$connexion->prepare("SELECT MAX(Id_Image) FROM image");
		$query->execute();

		$a= $query->fetchColumn();

		$query =$connexion->prepare("SELECT MAX(Id_Offre) FROM offre");
		$query->execute();

		$b= $query->fetchColumn();

		$requeteInsertionOffreImage =$connexion->prepare('INSERT INTO offre_image (Id_Offre, Id_Image) VALUES (:Id_Offre, :Id_Image )');
		$requeteInsertionOffreImage->bindParam(':Id_Offre', $b);
		$requeteInsertionOffreImage->bindParam(':Id_Image', $a);
		
		$requeteInsertionOffreImage->execute();
		$message = 'Votre demande a bien été prise en compte.';
	}catch (\Exception $exception) {
		$message = 'Erreur lors de l\'ajout offre_image';
		// Debug de l'erreur :
		// var_dump($exception->getMessage());

};
}
}

require 'require_popup.php';

?>
<div class= "container">
	<h3 class="titre_form">Ajoutez une offre</h3>
	<form action="#" method="POST" class="contact-form">
		
		<div>
			<label for="nomOffre">Nom de l'offre</label>
			<?= isset($erreurs['nomOffre']) ? $erreurs['nomOffre'] : null; ?>
			<input type="nomOffre" name="nomOffre" value="<?= isset($_POST['nomOffre']) ? $_POST['nomOffre'] : null; ?>">
		</div>

        <div>
			<label for="descriptionOffre">Description de l'offre</label>
			<textarea name="descriptionOffre"><?= isset($_POST['descriptionOffre']) ? $_POST['descriptionOffre'] : ''; ?></textarea>
			<?= isset($erreurs['descriptionOffre']) ? $erreurs['descriptionOffre'] : null; ?>
		</div>

        <div>
			<label for="dateDebutOffre">Date de début de l'offre A-M-J</label>
			<?= isset($erreurs['dateDebutOffre']) ? $erreurs['dateDebutOffre'] : null; ?>
			<input type="dateDebutOffre" name="dateDebutOffre" value="<?= isset($_POST['dateDebutOffre']) ? $_POST['dateDebutOffre'] : null; ?>">
		</div>

        <div>
			<label for="dateFinOffre">Date de fin de l'offre A-M-J</label>
			<?= isset($erreurs['dateFinOffre']) ? $erreurs['dateFinOffre'] : null; ?>
			<input type="dateFinOffre" name="dateFinOffre" value="<?= isset($_POST['dateFinOffre']) ? $_POST['dateFinOffre'] : null; ?>">
		</div>

        <div>
			<label for="nbPlaceMinOffre">Nombre de place minimum de l'offre</label>
			<?= isset($erreurs['nbPlaceMinOffre']) ? $erreurs['nbPlaceMinOffre'] : null; ?>
			<input type="nbPlaceMinOffre" name="nbPlaceMinOffre" value="<?= isset($_POST['nbPlaceMinOffre']) ? $_POST['nbPlaceMinOffre'] : null; ?>">
		</div>

        <div>
			<label for="partenaireOffre">Partenaire de l'offre</label>
			<select name="partenaireOffre" id="partenaireOffre">
				<?php foreach ($partenaireOffre as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['partenaireOffre']) && $_POST['partenaireOffre'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['partenaireOffre']) ? $erreurs['partenaireOffre'] : null; ?>
		</div>

		<div>
			<label for="nomImage1">Image 1</label>
			<?= isset($erreurs['nomImage1']) ? $erreurs['nomImage1'] : null; ?>
			<input type="nomImage1" name="nomImage1" value="<?= isset($_POST['nomImage1']) ? $_POST['nomImage1'] : null; ?>">
		</div>

		<div>
			<label for="nomImage">Image 2</label>
			<?= isset($erreurs['nomImage2']) ? $erreurs['nomImage2'] : null; ?>
			<input type="nomImage" name="nomImage" value="<?= isset($_POST['nomImage2']) ? $_POST['nomImage2'] : null; ?>">
		</div>

		<div>
			<label for="nomImage">Image 3</label>
			<?= isset($erreurs['nomImage3']) ? $erreurs['nomImage3'] : null; ?>
			<input type="nomImage" name="nomImage" value="<?= isset($_POST['nomImage3']) ? $_POST['nomImage3'] : null; ?>">
		</div>

		<div>
			<label for="nomImage">Image 4</label>
			<?= isset($erreurs['nomImage4']) ? $erreurs['nomImage4'] : null; ?>
			<input type="nomImage" name="nomImage" value="<?= isset($_POST['nomImage4']) ? $_POST['nomImage4'] : null; ?>">
		</div>

		<div>
			<input type="submit" name="validation" class="send-button">
		</div>
	</form>
</div>
</body>
</html>