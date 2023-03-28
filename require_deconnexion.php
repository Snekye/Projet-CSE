<form action="#" method="POST" name="deconnexion">
    <input type="hidden" name="deconnexion" value="deconnexion">
    <button type="submit">Deconnexion</button>
</form>

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
    echo ("Vous vous êtes déconnecté.");
    header("refresh:2;url=./connexion.php");
}
?>