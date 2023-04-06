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
			if (strlen($_POST['contenuMessage']) > 100) {
				$erreurs['contenuMessage'] = 'Le prénom ne doit pas dépasser 100 caractères.';
			}
		}
	}

    if (empty($_POST['contenuMessage'])) {
		$erreurs['contenuMessage'] = 'Veuillez saisir un message.';
	} else {
		if (strlen($_POST['contenuMessage']) > 3000) {
			$erreurs['contenuMessage'] = 'Le message ne doit pas dépasser 3000 caractères.';
		}
	}


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
			<input type="submit" name="validation">
		</div>
</form>