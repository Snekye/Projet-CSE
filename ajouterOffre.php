<?php

require 'require_connexion_bdd.php';


$partenaireOffre = [
	
];
 

$erreurs = [];

if (empty($_POST) === false) {

	// Vérification des données saisies
	
	$expressionReguliere = '/[\d\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

	if (empty($_POST['nomOffre']) === false) {
		if (preg_match($expressionReguliere, $_POST['nomOffre'])) {
			$erreurs['nomOffre'] = "Le nom de l'offre ne doit pas contenir de chiffres et de caractères spéciaux.";
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

    //Date Fin Offre

    //NB place min

	if (isset($sujets[$_POST['partenaireOffre']]) === false) {
		$erreurs['partenaireOffre'] = 'Veuillez préciser un partenaire valide.';
	}


    if (empty($erreurs)) {
        try {
            $requeteInsertion = $connexion->prepare('INSERT INTO Offre (Nom_Offre, Description_Offre, Date_Debut_Offre, Nombre_Place_Min_Offre, Id_Partenaire) VALUES (:Nom_Offre, :Description_Offre, :Date_Debut_Offre, :Nombre_Place_Min_Offre, :Partenaire_Offre)');
            $requeteInsertion->bindParam(':Nom_Offre', $_POST['nomOffre']);
            $requeteInsertion->bindParam(':Description_Offre', $_POST['descriptionOffre']);
            $requeteInsertion->bindParam(':Date_Debut_Offre', $_POST['dateDebutOffre']);          
            $requeteInsertion->bindParam(':Date_Fin_Offre', $_POST['dateFinOffre']);
            $requeteInsertion->bindParam(':Nombre_Place_Min_Offre', $_POST['nbPlaceMinOffre']);
            $requeteInsertion->bindParam(':Partenaire_Offre', $_POST['partenaireOffre']);

            $requeteInsertion->execute();

            echo 'Votre demande a bien été prise en compte.';
        } catch (\Exception $exception) {
            echo 'Erreur lors de l\'ajout de la demande de contact.';
            // Debug de l'erreur :
            // var_dump($exception->getMessage());
        }
    }
}

?>

	<form action="#" method="POST">
		
		<div>
			<label for="nomOffre">Nom de l'offre</label>
			<?= isset($erreurs['nomOffre']) ? $erreurs['nomOffre'] : null; ?>
			<input type="nomOffre" name="nomOffre" value="<?= isset($_POST['nomOffre']) ? $_POST['nomOffre'] : null; ?>">
		</div>

        <div>
			<label for="descriptionOffre">Description de l'offre</label>
			<textarea name="descriptionOffre"><?= isset($_POST['descriptionOffre']) ? $_POST['descriptionOffre'] : 'Votre description...'; ?></textarea>
			<?= isset($erreurs['descriptionOffre']) ? $erreurs['descriptionOffre'] : null; ?>
		</div>

        <div>
			<label for="dateDebutOffre">Date de début de l'offre</label>
			<?= isset($erreurs['dateDebutOffre']) ? $erreurs['dateDebutOffre'] : null; ?>
			<input type="dateDebutOffre" name="dateDebutOffre" value="<?= isset($_POST['dateDebutOffre']) ? $_POST['dateDebutOffre'] : null; ?>">
		</div>

        <div>
			<label for="dateFinOffre">Date de fin de l'offre</label>
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
				<?php foreach ($sujets as $valeur => $nom) { ?>
				<option <?php if (isset($_POST['partenaireOffre']) && $_POST['partenaireOffre'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
				<?php } ?>
			</select>
			<?= isset($erreurs['partenaireOffre']) ? $erreurs['partenaireOffre'] : null; ?>
		</div>

		<div>
			<input type="submit" name="validation">
		</div>
	</form>
</body>
</html>