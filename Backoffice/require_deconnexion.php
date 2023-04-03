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

<form action="#" method="POST" name="deconnexion">
    <input type="hidden" name="deconnexion" value="deconnexion">
    <button type="submit">Deconnexion</button>
</form>
