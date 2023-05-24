<?php
require ('require_connexion_bdd.php');
// création des variable
$partenaire= [];
$partenaireImage=[];
$partenaireNom=[];
$partenaireLien=[];

// requette pour récupérer les partenaire
$query->$connexion->prepare("SELECT Id_Partenaire FROM partenaire ");
$query-> execute();

// attribution des valeurs dans le tableau partenaire Image
$partenaire= $query->fetchAll();

foreach($partenaire as $element){
    $partenaire[] =$element['Id_Partenaire'];
}

// requette de jointure pour les images et les partenaires
$query->$connexion->prepare("SELECT Nom_Image FROM image,partenaire WHERE image.Id_image=partenaire.Id_Image");
$query->execute();

// attribution des valeurs dans le tableau partenaire Image
$partenaireImage= $query->fetchAll();

foreach ($partenaireImage as $element){
    $partenaireImage[] = $element['Nom_Image'];
}

// requette du nom du partenaire
$query->$connexion->prepare("SELECT Nom_Partenaire FROM Partenaire");
$query->execute();

// attribution des valeurs dans le tableau partenaire Nom
$partenaireNom= $query->fetchAll();

foreach($partenaireNom as $element){
    $partenaireNom[]= $element['Nom_Partenaire'];
}

// requette des liens du partenaire
$query->$connexion->prepare("SELECT Lien_Partenaire FROM partenaire");
$query->execute();

// attribution des valeurs dans le tableau lien de partenaire
$partenaireLien=$query-> fetchAll();

foreach($partenaireLien as $element){
    $partenaireLien[]= $element['Lien_Partenaire'];
}

// attribution des valeurs dans le tableau description de partenaire
$partenaireDescription= $query->fetchAll();

// Si mon formulaire de description a été soumi, alors je le traite
if (isset($_POST['envoye'])) {
    $formulaire = $_POST['envoye'];

	    if (isset($formulaire['id'])) {
		    try {
			    $requete = $connexion->prepare('SELECT Description_Partenaire FROM partenaire WHERE partenaire_id = :id');
			    $requete->bindParam(':id', $formulaire['id']);
			    $requete->execute();

			    // Redirection vers la page liste.php (on force le raffraichissement de la page)
			    header('Location: ./back.php');
		    } catch (\Exception $exception) {
			    var_dump($exception);
		}
	}
}

//On attribut la description dans un variable
$partenaireDescription=$requete;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="partenaire.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet cse</title>
</head>
<body>
    <section id="page-Partenaire">
        <div class="textePartenaire">
            <p>
                Bienvenue dans notre section consacrée a nos partenaire. C'est ici que vous pouvez découvrir nos nombreux colaborateur qui m'ètent à
                vos disposition divers offre!
            </p>
        </div>
        <div class="modalPartenaire">
            <div class="contenaire">
                <div id="fermerModalPartenaire" onclick="fermerModal()">
                    <p>&times;</p>
                </div>
            </div>
            <div class="partenaire">
                <div class="logoPartenaire">
                    <!-- lien vers le site du partenaire -->
                    <a href="<?php echo $partenaireLien[$i]['Lien_Partenaire']?>" target="_blank">
                    <img src="<?php echo $partenaireImage[$i]['Nom_Image'] ?>" alt="nom du partenaire">
                </div>
                <div class="titrePartenaire2">
                    <h2><?php echo $partenaireNom[$i] ['Nom_Partenaire']?></h2>
                </div>
            </div>
            <div class="descriptionPartenaire">
                <p>
                    <? echo $partenaireDescription ?>
                </p>
            </div>
        </div>
        <div class="contenaire">
        <?php
            for ($i = 0; $i < count($partenaire); $i++){?>
                <div class="partenaire">
                    <div class="logoPartenaire">
                        <!-- lien vers le site du partenaire -->
                        <a href="<?php echo $partenaireLien[$i]['Lien_Partenaire']?>" target="_blank">
                            <img src="<?php echo $partenaireImage[$i]['Nom_Image'] ?>" alt="nom du partenaire">
                        </a>
                    </div>
                    <form action="#" method="POST" name="envoye">
                        <button class="titrePartenaire" onclick="ouvrirModal()">
                            <!-- ouverture de la modal -->
                            <input type="hidden" name="envoye[id]" value="<?= $element['Id_Partenaire'] ?>">
                            <h2><?php echo $partenaireNom[$i] ['Nom_Partenaire']?></h2>
                        </button>
                    </form>
                </div>
            <?php
            } 
        ?>
        </div>
    </section>
    <script src="main.js"></script>
</body>
<footer>
</footer>
</html>