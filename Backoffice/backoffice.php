
<link rel="stylesheet" href="../font/font.css">
<link rel="stylesheet" href="backoffice.css">
<script src="backoffice.js"></script>

<?php
require ('require_connexion_bdd.php');
session_start();

//Deconnexion
require("require_deconnexion.php");

//Récupération BDD
$query = $connexion->prepare("SELECT * FROM info_accueil");
$query->execute();
$liste_info = $query->fetchAll()[0];

$query = $connexion->prepare("SELECT * FROM partenaire JOIN image ON partenaire.Id_Image = Image.Id_Image");
$query->execute();
$liste_partenaires = $query->fetchAll();

$query = $connexion->prepare("SELECT * FROM offre LEFT JOIN partenaire ON (offre.Id_Partenaire = partenaire.Id_Partenaire)");
$query->execute();
$liste_offres = $query->fetchAll();

$query = $connexion->prepare("SELECT * FROM  message LEFT JOIN partenaire ON (message.Id_Partenaire = partenaire.Id_Partenaire) LEFT JOIN offre ON (message.Id_Offre = offre.Id_Offre);");
$query->execute();
$liste_messages = $query->fetchAll();

$query = $connexion->prepare("SELECT Id_Utilisateur, Nom_Utilisateur, Prenom_Utilisateur, Email_Utilisateur FROM utilisateur");
$query->execute();
$liste_utilisateurs = $query->fetchAll();

//Modification BDD
if (empty($_POST) === False) {

    //Delete

    //Delete partenaire
    if (isset($_POST['delete_partenaire'])) {
        if (isset($_POST['delete_partenaire']['id'])) {
            $page = 1;

            //Verification si il y a des offres associées au partenaire
            $query = $connexion->prepare("SELECT Id_Offre FROM offre LEFT JOIN partenaire ON (offre.Id_Partenaire = partenaire.Id_Partenaire) WHERE offre.Id_Partenaire = :id");
            $query->bindParam(':id', $_POST['delete_partenaire']['id']);
            $query->execute();

            //Verification si il y a des messages associés au partenaire
            $query2 = $connexion->prepare("SELECT Id_Message FROM message LEFT JOIN partenaire ON (message.Id_Partenaire = partenaire.Id_Partenaire) WHERE message.Id_Partenaire = :id");
            $query2->bindParam(':id', $_POST['delete_partenaire']['id']);
            $query2->execute();

            if (($query->fetchAll() != []) or ($query2->fetchAll() != [])) {
                $message = '<span style="color: red;">Refus de suppression : Le partenaire possède des offres ou messages associés.</span>';
            }
            else {
                
                try {
                    $query = $connexion->prepare('DELETE FROM partenaire WHERE Id_Partenaire = :id');
                    $query->bindParam(':id', $_POST['delete_partenaire']['id']);
                    $query->execute();
                    $message = '<span style="color: green;">Partenaire supprimé.</span>';
                } catch (\Exception $exception) {
                    var_dump($exception);
                }
            }
        }
    }
    //Delete offre
    if (isset($_POST['delete_offre'])) {
        if (isset($_POST['delete_offre']['id'])) {
            $page = 2;

            //Verification si il y a des messages associés à l'offre
            $query = $connexion->prepare("SELECT Id_Message FROM message LEFT JOIN offre ON (message.Id_Offre = offre.Id_Offre) WHERE message.Id_Offre = :id");
            $query->bindParam(':id', $_POST['delete_offre']['id']);
            $query->execute();

            if ($query->fetchAll() != []) {
                $message = "<span style='color: red;'>Refus de suppression : L'offre possède des messages associés.</span>";
            }
            else {
                try {
                    $query = $connexion->prepare('DELETE FROM offre WHERE Id_Offre = :id');
                    $query->bindParam(':id', $_POST['delete_offre']['id']);
                    $query->execute();
                    $message = '<span style="color: green;">Offre supprimée.</span>';
                } catch (\Exception $exception) {
                    var_dump($exception);
                }
            }
        }
    }
    //Delete message
    if (isset($_POST['delete_message'])) {
        if (isset($_POST['delete_message']['id'])) {
            $page = 3;

            try {
                $query = $connexion->prepare('DELETE FROM message WHERE Id_Message = :id');
                $query->bindParam(':id', $_POST['delete_message']['id']);
                $query->execute();
                $message = '<span style="color: green;">Message supprimé.</span>';
            } catch (\Exception $exception) {
                var_dump($exception);
            }
        }
    }
    //Update
}

require ('..\require_popup.php');
?>

<div class="bg">⠀</div>

<div class="deletepartenaire deleteform">
    <p>Êtes vous sûr(e) de vouloir supprimer ce partenaire ?</p>
    <form action="#" method="POST" name="delete">
        <button>Supprimer</button>
        <input type="hidden" name="delete_partenaire[id]" value="" class="deletepartenaireinput">
    </form>
    <button onclick="deletecancel()">Ne pas supprimer</button>
</div>

<div class="deleteoffre deleteform">
    <p>Êtes vous sûr(e) de vouloir supprimer cette offre ?</p>
    <form action="#" method="POST" name="delete">
        <button>Supprimer </button>
        <input type="hidden" name="delete_offre[id]" value="" class="deleteoffreinput">
    </form>
    <button onclick="deletecancel()">Ne pas supprimer</button>
</div>

<div class="deletemessage deleteform">
    <p>Êtes vous sûr(e) de vouloir supprimer ce message ?</p>
    <form action="#" method="POST" name="delete">
        <button>Supprimer</button>
        <input type="hidden" name="delete_message[id]" value="" class="deletemessageinput">
    </form>
    <button onclick="deletecancel()">Ne pas supprimer</button>
</div>

<section class="menu">
    <div class="menubutton" onclick="affiche(0)">Présentation</div>
    <div class="menubutton" onclick="affiche(1)">Partenaires</div>
    <div class="menubutton" onclick="affiche(2)">Offres</div>
    <div class="menubutton" onclick="affiche(3)">Messagerie</div>
    <div class="menubutton" onclick="affiche(4)">Utilisateurs</div>
</section>

<section class="presentation affiche">

<h1>Présentation</h1>

<table>

    <thead>
        <tr>
            <th>Tel</th>
            <th>Email</th>
            <th>Emplacement</th>
            <th>Titre</th>
            <th>Texte</th>
            <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
            <th>Action</th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td style='width: 10%;'><?=$liste_info['Num_Tel_Info_Accueil']?></td>
            <td style='width: 10%;'><?=$liste_info['Email_Info_Accueil']?></td>
            <td style='width: 20%;'><?=$liste_info['Emplacement_Bureau_Info_Accueil']?></td>
            <td style='width: 10%;'><?=$liste_info['Titre_Info_Accueil']?></td>
            <td style='width: 25%;'><?=$liste_info['Texte_Info_Accueil']?></td>
            <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
            <td style='width: 15%'>
                <button>Modifier</button>
            </td>
            <?php } ?>
        </tr>
    </tbody>

</table >

</section>

<section class="partenaires affiche">

<h1>Partenaires</h1>
<table>

    <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Lien</th>
            <th>Image</th>
            <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
            <th>Action</th>
            <?php } ?>
        </tr>
    </thead>

    <tbody>

        <?php 
        
        $table = "partenaire";
        foreach ($liste_partenaires as $element) { ?>

        <tr>
            <td style='width: 10%;'><?=$element['Nom_Partenaire']?></td>
            <td style='width: 30%;'><?=$element['Description_Partenaire']?></td>
            <td style='width: 15%;'><a href="<?=$element['Lien_Partenaire']?>", target="_blank"><?=$element['Lien_Partenaire']?></a></td>
            <td style='width: 15%;'><img src="<?=$element['Nom_Image']?>"></td>
            <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
            <td style='width: 20%;'>
                <form action="#" method="POST" name="delete">
                    <button>Modifier</button>
                </form>
                <button onclick="deletepartenaire(<?=$element['Id_Partenaire'] ?>);">Supprimer</button>
            </td>
            <?php } ?>
        </tr>
        
        <?php } ?>

    </tbody>
</table>

</section>

<section class="offre affiche">

    <h1>Offres</h1>

    <table>

        <thead>
            <tr>
                <th>Partenaire</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Places</th>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>

            <?php 
            
            foreach ($liste_offres as $element) { ?>

            <tr>
                <td style='width: 10%;'><?=$element['Nom_Partenaire']?></td>
                <td style='width: 10%;'><?=$element['Nom_Offre']?></td>
                <td style='width: 20%;'><?=$element['Description_Offre']?></td>
                <td style='width: 10%;'><?=$element['Date_Debut_Offre']?></td>
                <td style='width: 10%;'><?=$element['Date_Fin_Offre']?></td>
                <td style='width: 5%;'><?=$element['Nombre_Place_Min_Offre']?></td>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <td style='width: 15%;'>
                    <form action="#" method="POST" name="delete">
                        <button>Modifier</button>
                    </form>
                    <button onclick="deleteoffre(<?=$element['Id_Offre'] ?>);">Supprimer</button>
                </td>
                <?php } ?>
            </tr>
            
            <?php } ?>

        </tbody>

    </table>

</section>

<section class="messagerie affiche">

    <h1>Messagerie</h1>

    <table>
        

        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Message</th>
                <th>Offre</th>
                <th>Partenaire</th>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>

            <?php 
            
            foreach ($liste_messages as $element) { ?>

            <tr>
                <td style='width: 7.5%;'><?=$element['Nom_Message']?></td>
                <td style='width: 7.5%;'><?=$element['Prenom_Message']?></td>
                <td style='width: 20%;'><?=$element['Email_Message']?></td>
                <td style='width: 25%;'><?=$element['Contenu_Message']?></td>
                <td style='width: 7.5%;'><?=$element['Nom_Offre']?></td>
                <td style='width: 7.5%;'><?=$element['Nom_Partenaire']?></td>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <td style='width: 15%;'>
                    <button onclick="deletemessage(<?=$element['Id_Message'] ?>);">Supprimer</button>
                </td>
                <?php } ?>
            </tr>
            
            <?php } ?>

        </tbody>

    </table>

</section>

<section class="utilisateurs affiche">

    <h1>Utilisateurs</h1>

    <table style='width:100%;'>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>

        <?php 
            
            foreach ($liste_utilisateurs as $element) { ?>

            <tr>
                <td style='width: 20%;'><?=$element['Nom_Utilisateur']?></td>
                <td style='width: 20%;'><?=$element['Prenom_Utilisateur']?></td>
                <td style='width: 40%;'><?=$element['Email_Utilisateur']?></td>
                <?php if ($_SESSION["utilisateur"]['droit'] == 'Administrateur') { ?>
                <td style='width: 20%;'>
                    <form action="#" method="POST" name="delete">
                        <button>Modifier</button>
                    </form>
                    <button onclick="deleteutilisateur(<?=$element['Id_Utilisateur'] ?>);">Supprimer</button>
                </td>
                <?php } ?>
            </tr>

            <?php } ?>

        </tbody>
    </table>

    <?php if ($_SESSION["utilisateur"]['droit'] != 'Administrateur') { ?>
        <style>
            .utilisateurs td {
                padding: 1%;
            }
        </style>
    <?php } ?>
    
</section>


<script>affiche(<?=$page?>);</script>