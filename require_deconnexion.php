<form action="#" method="POST" name="deconnexion">
    <input type="hidden" name="deconnexion" value="deconnexion">
    <button type="submit">Deconnexion</button>
</form>

<?php
require ('require_connexion_bdd.php');

if (!empty($_POST["deconnexion"])) {
    session_destroy();
    echo ("Vous vous êtes déconnecté.");
    header("refresh:2;url=./index.php");
}
?>