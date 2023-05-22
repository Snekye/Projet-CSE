<?php
require ('require_connexion_bdd.php');

//	Welcome user
if (!empty($_SESSION)) {
	echo "<h1 style='text-align: center;'>Bienvenue, "
     . $_SESSION["utilisateur"]["prenom"] . ' ' . $_SESSION["utilisateur"]["nom"] . ' ! ^.^ </h1>';
    } else {
        echo "<h1>Accès refusé.</h1>";
        die();
    }

if (!empty($_POST["deconnexion"])) {
    session_destroy();
    $message = "<span style='color: green'>Vous êtes maintenant déconnecté.</span>";
    header("refresh:3;url=./connexion.php");
}
?>

<form action="#" method="POST" name="deconnexion" class="decoform">
    <input type="hidden" name="deconnexion" value="deconnexion">
    <button type="submit" class="decobutton">Deconnexion</button>
</form>

<link rel="stylesheet" href="../font/font.css">
<style>
    .decobutton {
        width: 20%;
        margin-left: 40%;
        font-size: 150%;
        padding: 1%;
        background-color: white;
        border: 3px solid #1B3168;
        border-radius: 6% / 30%;
        font-family: Montserrat;
    }
    .decobutton:hover {
        transition: .3s;
        background-color: #1B3168;
        color: white;
    }
</style>