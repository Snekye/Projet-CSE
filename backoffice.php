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


//Modification BDD
if (empty($_POST) === False) {

    //Delete
    if (isset($_POST['delete_partenaire'])) {
        //Verification si il y a des offres du partenaire à supprimer
        if (isset($_POST['delete_partenaire']['id'])) {
            $query = $connexion->prepare("SELECT Id_Offre FROM offre LEFT JOIN partenaire ON (offre.Id_Partenaire = partenaire.Id_Partenaire) WHERE offre.Id_Partenaire = :id");
            $query->bindParam(':id', $_POST['delete_partenaire']['id']);
            $query->execute();

            if ($query->fetchAll() != []) {
                $message = '<span style="color: red;">Refus de suppression : Le partenaire possède des offres</span>';
            }
            else {

                try {
                    $query = $connexion->prepare('DELETE FROM partenaire WHERE Id_Partenaire = :id');
                    $query->bindParam(':id', $_POST['delete_partenaire']['id']);
                    $query->execute();
                    $message = '<span style="color: green;">Partenaire supprimé.</span>';
                    header("refresh:2;url=./backoffice.php");
                } catch (\Exception $exception) {
                    var_dump($exception);
                }
            }
        }
    }
    if (isset($_POST['delete_offre'])) {
        if (isset($_POST['delete_offre']['id'])) {
            try {
                $query = $connexion->prepare('DELETE FROM offre WHERE Id_Offre = :id');
                $query->bindParam(':id', $_POST['delete_offre']['id']);
                $query->execute();
                $message = '<span style="color: green;">Offre supprimée.</span>';
                header("refresh:3;url=./backoffice.php");
            } catch (\Exception $exception) {
                var_dump($exception);
            }
        }
    }
    if (isset($_POST['delete_message'])) {
        if (isset($_POST['delete_message']['id'])) {
            try {
                $query = $connexion->prepare('DELETE FROM message WHERE Id_Message = :id');
                $query->bindParam(':id', $_POST['delete_message']['id']);
                $query->execute();
                $message = '<span style="color: green;">Message supprimé.</span>';
                header("refresh:3;url=./backoffice.php");
            } catch (\Exception $exception) {
                var_dump($exception);
            }
        }
    }
    //Update

    unset($_POST);
}

?>

<section class="menu">
    <div class="menubutton" onclick="affiche(0)">Présentation</div>
    <div class="menubutton" onclick="affiche(1)">Partenaires</div>
    <div class="menubutton" onclick="affiche(2)">Offres</div>
    <div class="menubutton" onclick="affiche(3)">Messagerie</div>
</section>

<?=isset($message) ? $message : null?>

<section class="presentation affiche">

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

</section>

<section class="partenaires affiche">

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
        
        $table = "partenaire";
        foreach ($liste_partenaires as $element) { ?>

        <tr>
            <td style='width: 10%;'><?=$element['Nom_Partenaire']?></td>
            <td style='width: 40%;'><?=$element['Description_Partenaire']?></td>
            <td style='width: 10%;'><a href="<?=$element['Lien_Partenaire']?>", target="_blank"><?=$element['Lien_Partenaire']?></a></td>
            <td style='width: 20%;'><img src="<?=$element['Nom_Image']?>"></td>
            <td style='width: 25%;'>
                <form action="#" method="POST" name="delete">
                    <button>Modifier</button>
                    <button>Supprimer</button>
                    <input type="hidden" name="delete_partenaire[id]" value="<?=$element['Id_Partenaire'] ?>">
                    <input type="hidden" name="page" value="1">
                </form>
            </td>
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
            <th style='width: 10%;'>Partenaire</th>
            <th style='width: 10%;'>Nom</th>
            <th style='width: 30%;'>Description</th>
            <th style='width: 10%;'>Date de début</th>
            <th style='width: 10%;'>Date de fin</th>
            <th style='width: 5%;'>Places minimum</th>
            <th style='width: 15%;'>Action</th>
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
            <td style='width: 5%;'><?=$element['Nombre_Place_Min_Offre']?></td>
            <td style='width: 15%;'>
                <form action="#" method="POST" name="delete">
                    <button>Modifier</button>
                    <button>Supprimer</button>
                    <input type="hidden" name="delete_offre[id]" value="<?=$element['Id_Offre'] ?>">
                </form>
            </td>
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
            <td style='width: 10%;'>
                <form action="#" method="POST" name="delete">
                    <button>Supprimer</button>
                    <input type="hidden" name="delete_message[id]" value="<?=$element['Id_Message'] ?>">
                </form>
            </td>
        </tr>
        
        <?php } ?>

    </tbody>

    </section>

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
            padding: 2%;
        }
        h1 {
            text-align: center;
            font-size: 300%;
        }
        .menu {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .menu div {
            border: 3px solid #DDDDDD;
            padding: 2%;
            width: 20%;
            text-align: center;
            font-size: 150%;
            margin: 1%;
        }
    </style>

    <script>
        let sections = document.getElementsByClassName("affiche");
        let buttons = document.getElementsByClassName("menubutton");
        function affiche(id) {
            for (i = 0; i < sections.length; i++) {
                sections[i].setAttribute("style","display: none;")
                buttons[i].setAttribute("style","border-color: light_grey;")
            }
            sections[id].setAttribute("style","display: block;")
            buttons[id].setAttribute("style","border-color: black;")
        }
        affiche(0);
    </script>