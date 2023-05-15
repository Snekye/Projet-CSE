<?php

require 'includes/header.php';
require 'includes/connexion_bdd.php';
require 'includes/sujets.php';

// C# : connection.prepare("SELECT * FROM contact")
$query = $connexion->prepare("SELECT * FROM contact");
$query->execute();

$liste = $query->fetchAll();

//Traitement de supression du formulaire

if(isset($_POST['suppression'])){
	$formulaire = $_POST['suppression'];

	if(isset($formulaire['id'])){
		try{
			$requete = $connexion->prepare(query:'DELETE FROM contact WHERE contact_id = :id');
			$requete->bindParam(':id', $formulaire['id']);
			$requete->execute();
			header('Location: ./liste.php');
		}catch(\Exception $exception){
		var_dump($exception);
		}
	}
}

//var_dump($liste);
var_dump($formulaire);

?>

<table>
	<thead>
		<tr>
			<th width="20%">Email</th>	
			<th>Nom</th>	
			<th>Prénom</th>	
			<th>Contenu</th>	
		</tr>
	</thead>
	<tbody>
		<?php foreach ($liste as $element) { ?>
		<tr>
			<td width="20%"><?= $element['contact_email'] ?></td>
			<td><?= $element['contact_nom'] ?></td>
			<td><?= $element['contact_prenom'] ?></td>
			<td><?= $element['contact_contenu'] ?></td>
			<td>
				<form method="POST" action="">

				<form action="#" method="POST" name="supression">
					<input type="hidden" name="suppression[contact_id]" value="1">
					<button value="1" name="confirmation">Supprimer</button>
				</form>

				

			</td>
		</tr><?php
		} ?>
	</tbody>
</table>