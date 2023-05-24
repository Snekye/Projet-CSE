<?php
require ('require_connexion_bdd.php');
// création des variable
$partenaire= [];
$partenaireImage=[];
$partenaireNom=[];
$partenaireLien=[];

// requette pour récupérer les partenaire
$query = $connexion->prepare("SELECT Id_Partenaire FROM partenaire ");
$query-> execute();

// attribution des valeurs dans le tableau partenaire Image
$partenaire= $query->fetchAll();


foreach($partenaire as $element){
    $partenaire[] =$element['Id_Partenaire'];
}

// requette de jointure pour les images et les partenaires
$query =$connexion->prepare("SELECT Nom_Image FROM image,partenaire WHERE image.Id_image=partenaire.Id_Image");
$query->execute();

// attribution des valeurs dans le tableau partenaire Image
$partenaireImage= $query->fetchAll();

foreach ($partenaireImage as $element){
    $partenaireImage[] = $element['Nom_Image'];
}

// requette du nom du partenaire
$query =$connexion->prepare("SELECT Nom_Partenaire FROM Partenaire");
$query->execute();

// attribution des valeurs dans le tableau partenaire Nom
$partenaireNom= $query->fetchAll();

foreach($partenaireNom as $element){
    $partenaireNom[]= $element['Nom_Partenaire'];
}

// requette des liens du partenaire
$query =$connexion->prepare("SELECT Lien_Partenaire FROM partenaire");
$query->execute();

// attribution des valeurs dans le tableau lien de partenaire
$partenaireLien=$query-> fetchAll();

foreach($partenaireLien as $element){
    $partenaireLien[]= $element['Lien_Partenaire'];
}

// requette des liens du partenaire
$query =$connexion->prepare("SELECT Description_Partenaire FROM partenaire");
$query->execute();

// attribution des valeurs dans le tableau description de partenaire
$partenaireDescription= $query->fetchAll();

foreach($partenaireDescription as $element){
    $partenaireDescription[]= $element['Description_Partenaire'];
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="partenaire.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet cse</title>
    <script src="main.js"></script>
</head>
<body>
    <section id="page-Partenaire">
        <div class="textePartenaire">
            <p>
            Découvrez nos partenaires privilégiés !
            </br>Nous sommes ravis de vous accueillir dans notre espace dédié aux partenaires. Ici, vous trouverez une liste exclusive de partenaires qui offrent des avantages et des réductions spéciales aux membres du CSE.
            </p>
        </div>
        <div class="contenaire">
            <?php
                for ($i = 0; $i < count($partenaire); $i++){?>
                    <div class="modalPartenaire">
                            <div class="fermerModalPartenaire" onclick="fermerModal()">
                                <p>&times;</p>
                            </div>
                        <div class="partenaire">
                            <div class="logoPartenaire">
                            <a href="<?php echo $partenaireLien[$i]['Lien_Partenaire']?>" target="_blank">
                                    <img src="<?php echo $partenaireImage[$i]['Nom_Image'] ?>" alt="nom du partenaire">
                                </a>
                            </div>
                            <div class="titrePartenaire2">
                                <h2><?php echo $partenaireNom[$i] ['Nom_Partenaire']?></h2>
                            </div>
                        </div>
                        <div class="descriptionPartenaire">
                            <p>
                                <?php echo $partenaireDescription[$i] ['Description_Partenaire']?>
                            </p>
                        </div>
                    </div>
                    <div class="partenaire">
                        <div class="logoPartenaire">
                            <!-- lien vers le site du partenaire -->
                            <a href="<?php echo $partenaireLien[$i]['Lien_Partenaire']?>" target="_blank">
                                <img src="<?php echo $partenaireImage[$i]['Nom_Image'] ?>" alt="nom du partenaire">
                            </a>
                        </div>
                        <div class="titrePartenaire" onclick="ouvrirModal()">
                            <!-- ouverture de la modal -->
                                <h2><?php echo $partenaireNom[$i] ['Nom_Partenaire']?></h2>
                        </div>
                    </div>
        <?php
            }
            ?>
        </div>
    </section>
</body>
<footer>
</footer>
</html>