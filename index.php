<?php
require 'Backoffice/require_connexion_bdd.php';


//Récupération BDD Sidebar
$query = $connexion->prepare("SELECT * FROM info_accueil");
$query->execute();
$liste_info = $query->fetchAll()[0];

//Récupération offre billeterie
$query = $connexion->prepare("SELECT Nom_Offre, Description_Offre, Date_Debut_Offre, Date_Fin_Offre, Nom_Partenaire FROM Offre, Partenaire WHERE Offre.Id_Partenaire = Partenaire.Id_Partenaire ORDER BY Id_Offre DESC LIMIT 3;");
$query->execute();
$liste_offres = $query->fetchAll(); 

?>












<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>CSE Lycée Saint Vincent</title>

    <!--========================icons========================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">



    <!--========================CSS========================-->
    <link rel="stylesheet" href="assets/CSS/style.css">
    
</head>


    
<body>
    <!--========================HEADER========================-->

    <header>
        <div class="marge"></div>
    </header>
    
    
    <!--========================NAVBAR========================-->
    <nav>
        <div class="logo">
            <img src="assets/images/Logo_St_Vincent_1.png"  class="nav_logo" >
        </div>
        
        
        <ul class="nav_list">
            

            <li class="nav_item">
                <a href="#home" class="nav_link">
                    Accueil
                </a>
            </li>

            <li class="nav_item">
                <a href="#partenaire" class="nav_link">
                    Partenariats
                </a>
            </li>

            <li class="nav_item">
                <a href="#billeterie" class="nav_link">
                    Billeterie
                </a>
            </li>


            <li class="nav_item">
                <a href="#contact" class="nav_link">
                        Contact
                </a>
            </li>


        </ul>
        
        
        

    </nav>


    <!--========================SIDE BAR========================-->

    <div class="sidebar">
        <div class="menu">

            <div class="info">
                <div class="info_accueil">
                    <img src="assets/images/home@2x.png" alt="" class="info_logo">
                    <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                    <h1 href="#home" class="menu_titre_accueil">Accueil</h1>
                </div>

                <div class="info_acces_rapide">
                    <h1 class="menu_titre">Accès rapide</h1>
                    <div class="info_acces_rapide_premier">
                        <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <a href="#billeterie" class="info_lien">Offre/</a>
                        <a href="#partenaire" class="info_lien">Partenaire</a>
                    </div>

                    <div class="info_acces_rapide_second">
                        <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <a href="#contact" class="info_lien">Nous contacter</a>
                    </div>


                    

                </div>
                

                <div class="info_acces_rapide">
                    <h1 class="menu_titre">Information de contact</h1>
                    <div class="info_acces_rapide_premier">
                        <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <p class="info_texte">Par téléphone:</p>
                        <a href="<?=$liste_info['Num_Tel_Info_Accueil']?>" class="info_lien"><?=$liste_info['Num_Tel_Info_Accueil']?></a>
                    </div>

                    <div class="info_acces_rapide_second">
                        <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <p class="info_texte">Par email:</p>
                        <a href="<?=$liste_info['Email_Info_Accueil']?>" class="info_lien"><?=$liste_info['Email_Info_Accueil']?></a>
                    </div>

                    <div class="info_acces_rapide_second">
                        <img src="assets/images/chevron-suite@2x.png" alt="" class="info_logo">
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
                    <img src="assets/images/leonidas@2x.png" alt="">
                    <img src="assets/images/lego.png" alt="">
                    <img src="assets/images/addidas.png" alt="">
                    <img src="assets/images/cap_monde.png" alt="">
                    <img src="assets/images/leonidas@2x.png" alt="">
                </div>
                <a href="#partenaire" class="info_partenaire">Découvrir tous nos partenaires</a>
            </div>


            

            

        </div>



    </div>

    <!--========================MAIN========================-->
    
    <section class="home">
        <div class="presentation">
            <h2 class="sous_titre">CSE Lycée Saint-Vincent</h2>

            <p class="texte_accueil">Nous vous souhaitons la bienvenue sur le site du comité social et économique du lycée Saint-Vincent à Senlis.<br>Découvrer l'équipe et le rôle et missions de votre CSE.</p>

        </div>

        <h1 class="affiche_offre">Dernières offres de la billeterie</h1>

        <?php
        foreach ($liste_offres as $element) {  ?>

        
        <div class="annonce">
            <div class="contenu_annonce">
                <label class="bouton_accueil"><?=$element['Nom_Partenaire']?></label>
                <p class="texte_presentation_debut"><?="A partir du ".$element['Date_Debut_Offre']?></p>
                <p class="texte_presentation_fin"><?=!is_null($element['Date_Fin_Offre']) ? " - Jusqu'au ".$element['Date_Fin_Offre']: null?></p>
            </div>
            <p class="texte_accueil"><?=$element['Nom_Offre']?></p>
            <p class="texte_accueil"><?=$element['Description_Offre']?></p>

        </div>

        <?php } ?>
        
    </section>

    <!--========================FOOTER========================-->

    <footer>
        <div class="Pfooter">
            <div class="imgST">
                <img src="assets/images/Logo_St_Vincent_1.png">
            </div>
            <div class="boxfooter">
                <div>
                    <p class="CSE">CSE Lycée Saint-Vincent</p>
                </div>
                <div class="linkfooter">
                    <a href="#">>&nbsp;Partenariats</a>
                    <a href="#">>&nbsp;Billetterie</a>
                    <a href="#">>&nbsp;Contact</a>
                </div>
            </div>
        </div>
    </footer>


    <!--========================JS========================-->
    <script src="assets/JS/main.js"></script>
</body>