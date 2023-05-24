<?php
    require ('require_connexion_bdd.php');

//GET

if (isset($_GET['Id_Offre'])) {
    $idOffre = $_GET['Id_Offre'];

    $ind = $idOffre;
}else {
    $ind = 0;
}


$offreIdImage = [];
$offreImage = [];
$offreNom = [];
$partenaireNom = [];
$offreTxt = [];
$partenaireImage = [];

$query = $connexion->prepare("SELECT offre_image.Id_Offre, image.Nom_Image 
FROM image
JOIN offre_image ON image.Id_Image = offre_image.Id_Image
JOIN offre ON offre_image.Id_Offre = offre.Id_Offre
ORDER BY offre_image.Id_Offre");
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

$query = $connexion->prepare("SELECT Nom_Image FROM image JOIN partenaire ON image.Id_Image = partenaire.Id_Image");
$query->execute();

$partenaireImage = $query->fetchAll();

foreach ($partenaireImage as $element) {
	$partenaireImage[] = $element['Nom_Image'];
};

$query =$connexion->prepare("SELECT COUNT(Id_Image)
FROM offre_image
GROUP BY Id_Offre");
$query->execute();

$countOffre = $query->FetchAll();

foreach($countOffre as $element){
    $compte[] = $element['COUNT(Id_Image)'];
};


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="infoAnnonce.css">
    <title>site du cse</title>
</head>
<body>
    <section id="infobilletterie">
        <div class="titreInfoBilletterie">
            <!-- titre de l'annonce -->
            <?php
                echo $offreNom[$ind];
            ?>
        </div>
        <div class="partInfoBilletterie1"> 
            <div class="imgConteneurPartInfoBilletterie">
                <!-- place les 4 image -->
                <div class="imgPartInfoBilleterie">
                <?php for ($i = 0; $i < $compte[$ind]; $i++){
                    $query = $connexion->prepare("SELECT offre_image.Id_Offre, image.Nom_Image 
                    FROM image
                    JOIN offre_image ON image.Id_Image = offre_image.Id_Image
                    JOIN offre ON offre_image.Id_Offre = offre.Id_Offre
                    WHERE offre_image.Id_Offre = $ind +1");
                    $query->execute();
                    $selectionOffre = $query->fetchAll();
                    //var_dump($d);
                    ?>
                <img src="<?php echo $selectionOffre[+$i]['Nom_Image'] ?>" alt="image de l'anonce">
                <?php }  ?>
                </div>
            </div>
            <div class="billetteriePartenaire">
                <div class="imgConteneurBilletteriePartenaire">
                    <!-- image du partenaire et ouverture vers la page partenaire du partenaire--> 
                <img src="<?php echo $partenaireImage[$ind]['Nom_Image'] ?>" alt="image du partenaire">
                </div>
                <div class="titreBilletteriePartenaire">
                    <!-- titre du partenaire -->
                    <a href="#" alt="liens vers le partenaire" target="_blank">
                    <?php
                        echo $partenaireNom[$ind];
                    ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="partInfoBilletterie2">
            <div class="descriptionInfoBilletterie">
                <li>
                <?php
                    echo $offreDateDebut[$ind]['Date_Debut_Offre'];
                ?>
                </li>
                <li>
                <?php
                    echo$offreDateFin[$ind]['Date_Fin_Offre'];
                ?>
                </li>
                <li>
                <?php
                    echo $offreNbPlace[$ind]['Nombre_Place_Min_Offre'];
                ?>
                </li>
            </div>
            <div class="paragrapheInfoBilleterie">
                <!-- paragaphe du l'annonce -->
                <?php
                  // description offre 
                   echo $offreTxt[$ind]['Description_Offre'];
                ?>
            </div>
        </div>
        <a href="billetterie.php" class="retour">
            ←revenir sur la page de billetterie
        </a>
    </section>
</body>
</html>