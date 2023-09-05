<link rel="stylesheet" href="formulaire.css">
<?php

require '../Backoffice/require_connexion_bdd.php';

//Récupération BDD Sidebar
$query = $connexion->prepare("SELECT * FROM info_accueil");
$query->execute();
$liste_info = $query->fetchAll()[0];


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
			if (strlen($_POST['prenomMessage']) > 100) {
				$erreurs['prenomMessage'] = 'Le prénom ne doit pas dépasser 100 caractères.';
			}
		}
	}

	if (empty($_POST['emailMessage'])) {
		$erreurs['emailMessage'] = 'Veuillez saisir une adresse email.';
	} else {
		if (filter_var($_POST['emailMessage'], FILTER_VALIDATE_EMAIL) === false) {
			$erreurs['emailMessage'] = 'Veuillez saisir une adresse email valide.';
		}
	}

    if (empty($_POST['contenuMessage'])) {
		$erreurs['contenuMessage'] = 'Veuillez saisir un message.';
	} else {
		if (strlen($_POST['contenuMessage']) > 3000) {
			$erreurs['contenuMessage'] = 'Le message ne doit pas dépasser 3000 caractères.';
		}
	}

//	var_dump(($_POST['nomPartenaire']) === $partenaireNom[] = "aucun");
//	var_dump(($_POST['nomPartenaire']) != $partenaireNom[] = "aucun");

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

            $message = 'Votre demande a bien été prise en compte.';
            header("refresh:4;url=../Contact/ajouter_message.php");
        } catch (\Exception $exception) {
            $message = 'Erreur lors de l\'ajout du message';
        }

        
    }

    
}

require('../require_popup.php');

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>CSE Lycée Saint Vincent</title>

        <!--========================icons========================-->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!--========================CSS========================-->
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
                    <a href="../Billeterie/billetterie.php" class="nav_link">
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
                        <img src="../assets/images/contact.png" alt="" class="info_logo">
                        <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                        <h1 href="#" class="menu_titre_accueil">Contact</h1>
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
                            <a href="../Billeterie/billetterie.php" class="info_texte">Offre/</a>
                            <a href="../Partenaire/partenaire.php" class="info_texte">Partenaire</a>
                        </div>

                        <div class="info_acces_rapide_second">
                            <img src="../assets/images/chevron-suite@2x.png" alt="" class="info_logo">
                            <a href="../index.php" class="info_texte">Accueil</a>
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
        <div class= "container">
            <h3 class="titre_form">Contactez-nous !</h3>
            <form action="#" method="POST" class="contact-form">
            
                <div>
                    <label for="nomMessage">Nom <span style="color: red;">*</span></label>
                    <?= isset($erreurs['nomMessage']) ? $erreurs['nomMessage'] : null; ?>
                    <input type="nomMessage" name="nomMessage" value="<?= isset($_POST['nomMessage']) ? $_POST['nomMessage'] : null; ?>">
                </div>

                <div>
                    <label for="prenomMessage">Prénom</label>
                    <?= isset($erreurs['prenomMessage']) ? $erreurs['prenomMessage'] : null; ?>
                    <input type="prenomMessage" name="prenomMessage" value="<?= isset($_POST['prenomMessage']) ? $_POST['prenomMessage'] : null; ?>">
                </div>

                <div>
                    <label for="emailMessage">Email <span style="color: red;">*</span></label>
                    <?= isset($erreurs['emailMessage']) ? $erreurs['emailMessage'] : null; ?>
                    <input type="emailMessage" name="emailMessage" value="<?= isset($_POST['emailMessage']) ? $_POST['emailMessage'] : null; ?>">
                </div>

            
                <div>
                    <label for="contenuMessage">Contenu</label>
                    <textarea name="contenuMessage"><?= isset($_POST['contenuMessage']) ? $_POST['contenuMessage'] : ''; ?></textarea>
                    <?= isset($erreurs['contenuMessage']) ? $erreurs['contenuMessage'] : null; ?>
                </div>

                <div>
                    <label for="nomOffre">Offre<span style="color: red;">*</span></label>
                    <select name="nomOffre" id="nomOffre">
                        <?php foreach ($offreNom as $valeur => $nom) { ?>
                        <option <?php if (isset($_POST['nomOffre']) && $_POST['nomOffre'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
                        <?php } ?>
                    </select>
                    <?= isset($erreurs['nomOffre']) ? $erreurs['nomOffre'] : null; ?>
                </div>

                <div>
                    <label for="nomPartenaire">Partenaire<span style="color: red;">*</span></label>
                    <select name="nomPartenaire" id="nomPartenaire">
                        <?php foreach ($partenaireNom as $valeur => $nom) { ?>
                        <option <?php if (isset($_POST['nomPartenaire']) && $_POST['nomPartenaire'] === $valeur) { echo 'selected'; } ?> value="<?= $valeur ?>"><?= $nom ?></option>
                        <?php } ?>
                    </select>
                    <?= isset($erreurs['nomPartenaire']) ? $erreurs['nomPartenaire'] : null; ?>
                </div>

                <div class="g-recaptcha" data-sitekey="6LctE48mAAAAAMCKWMnzAu_ZaQTFXtVeAeYvZoZh"></div>


                <div>
                    <input type="submit" name="validation" class="send-button">
                </div>

                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2606.8555700187317!2d2.5862228768817648!3d49.20329937637187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e630cfeb73f31d%3A0x48c819ca44bf7503!2sLyc%C3%A9e%20Priv%C3%A9%20Saint%20Vincent%20de%20Senlis!5e0!3m2!1sfr!2sfr!4v1682076006016!5m2!1sfr!2sfr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </form>
        </div>

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

</html>

