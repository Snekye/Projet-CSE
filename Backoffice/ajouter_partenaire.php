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
        //    $requeteInsertion = $connexion->prepare('INSERT INTO image (Nom_Image) VALUES (:Nom_Image)');
        //    $requeteInsertion->bindParam(':Nom_Image', $_POST['nomImagePartenaire']);
        //    $requeteInsertion->execute();

            $requeteInsertion = $connexion->prepare('INSERT INTO Partenaire (Nom_Partenaire, Description_Partenaire, Lien_Partenaire, Id_Image) VALUES (:Nom_Partenaire, :Description_Partenaire, :Lien_Partenaire, :Id_Image)');
            $requeteInsertion->bindParam(':Nom_Partenaire', $_POST['nomPartenaire']);
            $requeteInsertion->bindParam(':Description_Partenaire', $_POST['descriptionPartenaire']);
            $requeteInsertion->bindParam(':Lien_Partenaire', $_POST['lienPartenaire']);
			$requeteInsertion->bindParam(':Id_Image', $_POST['nomImagePartenaire']);          
        //    $requeteInsertion->bindParam(':Id_Image', $imagePartenaire); 
       
            $requeteInsertion->execute();

            echo 'Votre demande a bien été prise en compte.';
        } catch (\Exception $exception) {
            echo 'Erreur lors de l\'ajout du partenaire';
        }
    }
}

?>

<form action="#" method="POST">
		
		<div>
			<label for="nomPartenaire">Nom du partenaire</label>
			<?= isset($erreurs['nomPartenaire']) ? $erreurs['nomPartenaire'] : null; ?>
			<input type="nomPartenaire" name="nomPartenaire" value="<?= isset($_POST['nomPartenaire']) ? $_POST['nomPartenaire'] : null; ?>">
		</div>

        <div>
			<label for="descriptionPartenaire">Description du partenaire</label>
			<textarea name="descriptionPartenaire"><?= isset($_POST['descriptionPartenaire']) ? $_POST['descriptionPartenaire'] : 'Votre description...'; ?></textarea>
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
			<input type="submit" name="validation">
		</div>
</form>