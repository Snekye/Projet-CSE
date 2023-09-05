<?php

require ('../Backoffice/require_connexion_bdd.php');

$offreImage = [];
$offreNom = [];
$partenaireNom = [];
$offreTxt = [];

//Récupération BDD Sidebar
$query = $connexion->prepare("SELECT * FROM info_accueil");
$query->execute();
$liste_info = $query->fetchAll()[0];

$query = $connexion->prepare("SELECT offre_image.Id_Offre, image.Nom_Image 
FROM image
JOIN offre_image ON image.Id_Image = offre_image.Id_Image
JOIN offre ON offre_image.Id_Offre = offre.Id_Offre
GROUP BY offre_image.Id_Offre");
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

foreach ($offre as $element) {
    $offreId[] = $element['Id_Offre'];
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
        <title>CSE Lycée Saint Vincent</title>
        <link rel="stylesheet" href="billetterie.css">
        <link rel="stylesheet" href="../assets/CSS/style.css">
    </head>
    <body>

          <!--========================HEADER========================-->

          <header>
            <div class="marge"></div>
        </header>
    
    
        <!--========================NAVBAR========================-->
        <nav class="navbar">
            <div class="logo">
                <img src="../assets/images/Logo_St_Vincent_1.png"  class="nav_logo" >
            </div>
        
        
            <ul class="nav-list">
            

                <li class="nav_item">
                    <a href="../index.php" class="nav_link">
                        Accueil
                    </a>
                </li>

                <li class="nav_item">
                    <a href="../Partenaire/partenaire.php" class="nav_link">
                        Partenariats
                    </a>
                </li>

                <li class="nav_item">
                    <a href="billetterie.php" class="nav_link">
                        Billeterie
                    </a>
                </li>


                <li class="nav_item">
                    <a href="../Contact/ajouter_message.php" class="nav_link">
                        Contact
                    </a>
                </li>

            </ul>

            
            <button type="button" id="toggle" class="nav-toggler">
                <span class="line l1"></span>
                <span class="line l2"></span>
                <span class="line l3"></span>
            </button>
        
        

        </nav>
        
        


        <!--========================SIDE BAR========================-->

        <div class="sidebar">
            <div class="menu">

                <div class="info">
                    <div class="info_accueil">
                        <img src="../assets/images/billeterie.jpg" alt="" class="info_logo">
                        <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <h1 href="#home" class="menu_titre_accueil">Billeterie</h1>
                    </div>

                    <div class="info_poll">
                        <h2 class="poll_titre">Votre avis compte</h2>		
                        <?php
                        include ('../Poll.php');        
                        $poll = new Poll();
                        $pollData = $poll->getPoll();	
                        if(isset($_POST['vote'])){
                            $pollVoteData = array(
                                'pollid' => $_POST['pollid'],
                                'pollOptions' => $_POST['options']
                            );
                            $isVoted = $poll->updateVote($pollVoteData);
                            if($isVoted){
                                setcookie($_POST['pollid'], 1, time()+60*60*24*365);			
                                $voteMessage = 'Votre vote a bien été pris en compte.';
                            } else {
                                $voteMessage = 'Vous avez déjà voté.';
                            }
                        }
                        ?>	
                        <div class="poll_container">	
                            <?php echo !empty($voteMessage)?'<div class="alert alert-danger"><strong>Warning!</strong> '.$voteMessage.'</div>':''; ?>		
                            <form action="" method="post" name="pollFrm">	
                                <?php 
                                foreach($pollData as $poll){
                                    
                                    echo "<h3 class='poll_question'>".$poll['question']."</h3>"; 				
                                    $pollOptions = explode("||||", $poll['options']);
                                    echo "<ul class='poll_choix'>";
                                    for( $i = 0; $i < count($pollOptions); $i++ ) {
                                        echo '<li class="poll_result"><input type="radio" name="options" value="'.$i.'" > '.$pollOptions[$i].'</li>';
                                    }
                                    echo "</ul>";
                                    echo '<input type="hidden" name="pollid" value="'.$poll['pollid'].'">';
                                    echo '<br><input type="submit" name="vote" class="btn btn-primary" value="Valider">';
                                    echo '<a href="results.php"> Voir les réponse</a>';	
                                } 
                                ?>			
                            </form>		
                        </div>		
                    </div>

                    <div class="info_acces_rapide">
                        <h1 class="menu_titre">Accès rapide</h1>
                        <div class="info_acces_rapide_premier">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <a href="../index.php" class="info_texte">Accueil/</a>
                            <a href="../Partenaire/partenaire.php" class="info_texte">Partenaire</a>
                        </div>

                        <div class="info_acces_rapide_second">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <a href="../Contact/ajouter_message.php" class="info_texte">Nous contacter</a>
                        </div>


                    

                    </div>
                

                    <div class="info_acces_rapide">
                        <h1 class="menu_titre">Information de contact</h1>
                        <div class="info_acces_rapide_premier">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <p class="info_texte">Par téléphone:</p>
                            <a href="<?=$liste_info['Num_Tel_Info_Accueil']?>" class="info_lien"><?=$liste_info['Num_Tel_Info_Accueil']?></a>
                        </div>

                        <div class="info_acces_rapide_second">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <p class="info_texte">Par email:</p>
                            <a href="<?=$liste_info['Email_Info_Accueil']?>" class="info_lien"><?=$liste_info['Email_Info_Accueil']?></a>
                        </div>

                        <div class="info_acces_rapide_second">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <p class="info_texte">Au lycée:</p>
                            <address class="adresse" ><?=$liste_info['Emplacement_Bureau_Info_Accueil']?></address>
                        </div>

                    </div>
                
                </div>


                <h1 class="menu_titre">Nos Partenaire</h1>
                <div class="conteneur-de-partenaire-img slider-1">
                
                    <div class="slider">
                        <!-- image des partenaires, il faut quatre image-->
                        <!-- il faut que la premiére et que la derniére image soit la même -->
                        <img src="../assets/images/leonidas@2x.png" alt="">
                        <img src="../assets/images/lego.png" alt="">
                        <img src="../assets/images/addidas.png" alt="">
                        <img src="../assets/images/cap_monde.png" alt="">
                        <img src="../assets/images/leonidas@2x.png" alt="">
                    </div>
                    <a href="../Partenaire/partenaire.php" class="info_partenaire">Découvrir tous nos partenaires</a>
                </div>


            

            

            </div>



        </div>
        <section class="home">
            
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
                            <img src="img/horloge.png" alt="image pour le début de l'offre" class="carteIcone">
                            <!-- date début offre -->
                            <p>début de l'offre</p>
                            <?php
                                echo $offreDateDebut[$i]['Date_Debut_Offre'];
                            ?>
                        </span>
                    </div>
                    <div class="tab max">
                        <!-- date fin offre -->
                        <img src="img/sablier.png" alt="images pour la fin de l'offre" class="carteIcone">
                        <p>Fin de l'offre</p>
                        <?php
                                echo$offreDateFin[$i]['Date_Fin_Offre'];
                            ?>
                        </span>
                    </div>
                    <div class="tab pris">
                        <!-- icone user -->
                        <img src="img/utilisateur.png" alt="image des utilisateurs" class="carteIcone">
                        <p>
                            nombre de place
                        </p>
                        <?php
                                echo$offreNbPlace[$i]['Nombre_Place_Min_Offre'];
                            ?>
                        
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
                            <?php
                            if ($offreId[$i] == 1){
                                $idOffre = 0;
                            }else{
                                $idOffre = $offreId[$i -1]; 
                            }
                            $url = 'infoAnnonce.php?Id_Offre=' . $idOffre;
                            ?>
                            <a href="<?php echo $url; ?>">
                                Voir les détails de l'annonce
                            </a>
                        </button>
                    </button>
                    </div>
                </div>
                <?php
            } ?>
            </div>
        </section>


        <!--========================FOOTER========================-->

        <footer class="navbottom">
            <div class="Pfooter">
                <div class="imgST">
                    <img src="../assets/images/Logo_St_Vincent_1.png">
                </div>
                <div class="boxfooter">
                    <div>
                        <p class="CSE">CSE Lycée Saint-Vincent</p>
                    </div>
                    <div class="linkfooter">
                        <a href="../Partenaire/partenaire.php">>&nbsp;Partenariats</a>
                        <a href="../Billeterie/billetterie.php">>&nbsp;Billetterie</a>
                        <a href="../Contact/ajouter_message.php">>&nbsp;Contact</a>
                    </div>
                </div>
            </div>
        </footer>


        <!--========================JS========================-->
        <script src="../assets/JS/script.js"></script>
    </body>
</html>