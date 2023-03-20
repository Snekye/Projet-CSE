<?php
require ('require_connexion_bdd.php');
session_start();

//	Welcome user
if (!empty($_SESSION)) {
	echo "<h1 style='text-align: center;'>Bienvenue, " . $_SESSION["utilisateur"]["login"] . ' ! ^.^';
    } else {
        echo "<h1>Accès refusé.</h1>";
        die();
    }

//Deconnexion
require("require_deconnexion.php");

// récup BDD
$query = $connexion->prepare("SELECT * FROM info");
$query->execute();
$liste_info = $query->fetchAll()[0];

$query = $connexion->prepare("SELECT * FROM partenaire");
$query->execute();
$liste_partenaires = $query->fetchAll();

?>

<h1>Présentation</h1>

<table>

    <thead>
        <tr>
            <th style='width: 15%;'>Tel</th>
            <th style='width: 40%;'>Description</th>
            <th style='width: 20%;'>Email</th>
            <th style='width: 15%;'>Action</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td style='width: 15%;'><?=$liste_info['info_tel']?></th>
            <td style='width: 40%;'><?=$liste_info['info_msg']?></td>
            <td style='width: 20%;'><?=$liste_info['info_email']?></td>
            <td style='width: 15%'>
                <button>Modifier</button>
            </td>
        </tr>
    </tbody>

</table>

<h1>Partenaire</h1>
<table>

    <thead>
        <tr>
            <th style='width: 15%;'>Nom</th>
            <th style='width: 35%;'>Description</th>
            <th style='width: 15%;'>Lien</th>
            <th style='width: 25%;'>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($liste_partenaires as $element) { ?>

        <tr>
            <td style='width: 15%;'><?=$element['partenaire_nom']?></td>
            <td style='width: 35%;'><?=$element['partenaire_description']?></td>
            <td style='width: 15%;'><a href="<?=$element['partenaire_lien']?>", target="_blank"><?=$element['partenaire_lien']?></a></td>
            <td style='width: 25%;'>
                <button>Modifier</button>
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
            font-size: 24px;
        }
        table {
            padding: 0% 5%; font-size: 20px; text-align: center;
        }
    </style>

</table>