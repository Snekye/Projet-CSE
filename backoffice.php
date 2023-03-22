<?php
require ('require_connexion_bdd.php');
session_start();

//	Welcome user
if (!empty($_SESSION)) {
	echo "<h1 style='text-align: center;'>Bienvenue, "
     . $_SESSION["utilisateur"]["prenom"] . ' ' . $_SESSION["utilisateur"]["nom"] . ' ! ^.^ </h1>';
    } else {
        echo "<h1>Accès refusé.</h1>";
        die();
    }

//Deconnexion
require("require_deconnexion.php");

// récup BDD
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

?>

<h1>Présentation</h1>

<table>

    <thead>
        <tr>
            <th style='width: 10%;'>Tel</th>
            <th style='width: 10%;'>Email</th>
            <th style='width: 20%;'>Emplacement</th>
            <th style='width: 10%;'>Titre</th>
            <th style='width: 30%;'>Texte</th>
            <th style='width: 10%;'>Action</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td style='width: 10%;'><?=$liste_info['Num_Tel_Info_Accueil']?></td>
            <td style='width: 10%;'><?=$liste_info['Email_Info_Accueil']?></td>
            <td style='width: 20%;'><?=$liste_info['Emplacement_Bureau_Info_Accueil']?></td>
            <td style='width: 10%;'><?=$liste_info['Titre_Info_Accueil']?></td>
            <td style='width: 30%;'><?=$liste_info['Texte_Info_Accueil']?></td>
            <td style='width: 10%'>
                <button>Modifier</button>
            </td>
        </tr>
    </tbody>

</table>

<h1>Partenaires</h1>
<table>

    <thead>
        <tr>
            <th style='width: 10%;'>Nom</th>
            <th style='width: 30%;'>Description</th>
            <th style='width: 10%;'>Lien</th>
            <th style='width: 20%;'>Image</th>
            <th style='width: 10%;'>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php 
        
        foreach ($liste_partenaires as $element) { ?>

        <tr>
            <td style='width: 10%;'><?=$element['Nom_Partenaire']?></td>
            <td style='width: 40%;'><?=$element['Description_Partenaire']?></td>
            <td style='width: 10%;'><a href="<?=$element['Lien_Partenaire']?>", target="_blank"><?=$element['Lien_Partenaire']?></a></td>
            <td style='width: 20%;'><img src="<?=$element['Nom_Image']?>"></td>
            <td style='width: 25%;'>
                <button>Modifier</button>
                <button>Supprimer</button>
            </td>
        </tr>
        
        <?php } ?>

    </tbody>
</table>

<h1>Offres</h1>

<table>

    <thead>
        <tr>
            <th style='width: 10%;'>Partenaire</th>
            <th style='width: 10%;'>Nom</th>
            <th style='width: 30%;'>Description</th>
            <th style='width: 10%;'>Date de début</th>
            <th style='width: 10%;'>Date de fin</th>
            <th style='width: 10%;'>Places minimum</th>
            <th style='width: 10%;'>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php 
        
        foreach ($liste_offres as $element) { ?>

        <tr>
            <td style='width: 10%;'><?=$element['Nom_Partenaire']?></td>
            <td style='width: 10%;'><?=$element['Nom_Offre']?></td>
            <td style='width: 30%;'><?=$element['Description_Offre']?></td>
            <td style='width: 10%;'><?=$element['Date_Debut_Offre']?></td>
            <td style='width: 10%;'><?=$element['Date_Fin_Offre']?></td>
            <td style='width: 10%;'><?=$element['Nombre_Place_Min_Offre']?></td>
            <td style='width: 10%; display: flex; flex-wrap: wrap;'>
                <button>Modifier</button>
                <button>Supprimer</button>
            </td>
        </tr>
        
        <?php } ?>

    </tbody>

</table>

<h1>Messagerie</h1>

<table>

    <thead>
        <tr>
            <th style='width: 10%;'>Nom</th>
            <th style='width: 10%;'>Prénom</th>
            <th style='width: 20%;'>Email</th>
            <th style='width: 30%;'>Message</th>
            <th style='width: 5%;'>Offre</th>
            <th style='width: 5%;'>Partenaire</th>
            <th style='width: 10%;'>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php 
        
        foreach ($liste_messages as $element) { ?>

        <tr>
            <td style='width: 10%;'><?=$element['Nom_Message']?></td>
            <td style='width: 10%;'><?=$element['Prenom_Message']?></td>
            <td style='width: 20%;'><?=$element['Email_Message']?></td>
            <td style='width: 30%;'><?=$element['Contenu_Message']?></td>
            <td style='width: 5%;'><?=$element['Nom_Offre']?></td>
            <td style='width: 5%;'><?=$element['Nom_Partenaire']?></td>
            <td style='width: 10%; display: flex; flex-wrap: wrap;'>
                <button>Supprimer</button>
            </td>
        </tr>
        
        <?php } ?>

    </tbody>

    <style>
        td, th {
            border: 3px solid #DDDDDD;
        }
        button {
            font-size: 16px;
        }
        table {
            padding: 0% 5%; font-size: 20px; text-align: center;
        }
        img {
            width: 30%;
        }
    </style>