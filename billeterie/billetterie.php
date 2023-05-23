<?php

require ('require_connexion_bdd.php');

$offreImage = [];
$offreNom = [];
$partenaireNom = [];
$offreTxt = [];

$query = $connexion->prepare("SELECT Nom_Image FROM image JOIN offre_image ON image.Id_Image = offre_image.Id_Image JOIN offre ON offre_image.Id_Offre = offre.Id_Offre ");
$query->execute();

$offreImage = $query->fetchAll();

foreach ($offreImage as $element) {
	$offreImage[] = $element['Nom_Image'];
};

$query = $connexion->prepare("SELECT Nom_Offre,Id_Offre FROM offre ");
$query->execute();

$offre = $query->fetchAll();

foreach ($offre as $element) {
	$offreNom[] = $element['Nom_Offre'];
};


$query = $connexion->prepare("SELECT Nom_Partenaire,Id_Partenaire FROM partenaire ");
$query->execute();

$partenaire = $query->fetchAll();

foreach ($partenaire as $element) {
	$partenaireNom[] = $element['Nom_Partenaire'];
};

$query = $connexion->prepare("SELECT Description_Offre,Id_Offre FROM Offre ");
$query->execute();

$offreTxt = $query->fetchAll();

foreach ($offreTxt as $element) {
	$offreTxt[] = $element['Description_Offre'];
};

$query = $connexion->prepare("SELECT Date_Debut_Offre FROM offre");
$query->execute();

$offreDateDebut = $query->fetchAll();

foreach ($offreDateDebut as $element) {
	$offreDateDebut[] = $element['Date_Debut_Offre'];
};

$query = $connexion->prepare("SELECT Date_Fin_Offre FROM offre");
$query->execute();

$offreDateFin = $query->fetchAll();

foreach ($offreDateFin as $element) {
	$offreDateFin[] = $element['Date_Fin_Offre'];
};

$query = $connexion->prepare("SELECT Nombre_Place_Min_Offre FROM offre");
$query->execute();

$offreNbPlace = $query->fetchAll();

foreach ($offreNbPlace as $element) {
	$offreNbPlace[] = $element['Nombre_Place_Min_Offre'];
};

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page partenaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="pageBilleterie">
        <div class="texte">
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Placeat soluta nemo saepe vitae ducimus,
                veniam beatae neque consectetur deleniti voluptate possimus pariatur sed labore nesciunt, consequatur facere quidem nulla deserunt?
            </p>
        </div>

         

        <div class="conteneurBillet">
        <?php
        for ($i = 0; $i < count($offreNom); $i++){ ?>
            <div class="carte">
                <div class="carteImage">
                    <!-- Premiére image de l'anonnce -->
                    <img src="<?php echo $offreImage[$i]['Nom_Image'] ?>" alt="image de l'anonce">
                </div>
                <div class="carteTitre">
                    <?php
                        echo $offreNom[$i];
                    ?>
                    <hr>
                </div>
                <!-- icone -->
                <div class="tab min">
                    <img src="#" alt="nombre de place total" class="carteIcone">
                    <span>
                        <!-- date début offre -->
                        <?php
                            echo $offreDateDebut[$i]['Date_Debut_Offre'];
                        ?>
                    </span>
                </div>
                <div class="tab pris">
                    <img src="#" alt="nombre de place prise" class="carteIcone">
                    <span>
                        <!--date fin offre -->
                        <?php
                            echo$offreDateFin[$i]['Date_Fin_Offre'];
                        ?>
                    </span>
                </div>
                <div class="tab restant">
                    <img src="#" alt="nombre de place restante" class="carteIcone">
                    <span>
                        <!-- nombre de place min -->
                        <?php
                            echo $offreNbPlace[$i]['Nombre_Place_Min_Offre'];
                        ?>
                    </span>
                </div>
                <!-- info de l'annonce -->
                <div class="carteInfo">
                    
                    <?php
                      // description offre 
                       echo $offreTxt[$i]['Description_Offre'];
                    ?>
                </div>

                <div class="carteBtn">
                    <button type="button">
                        Voir les détails de l'annonce
                    </button>
                </button>
                </div>
            </div>
            <?php
        } ?>
        </div>
    </section>
</body>
</html>
