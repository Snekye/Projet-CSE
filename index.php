<?php
require ('require_connexion_bdd.php');
session_start();

$message = "";

if (isset($_POST['login']) && isset($_POST['password'])) {
    $query = $connexion->prepare('
        SELECT utilisateur_login, utilisateur_mdp, utilisateur_nom, utilisateur_prénom
        FROM utilisateur
        WHERE utilisateur_login = :login');

    $query->bindParam(':login', $_POST['login']);
    $query->execute();
    $userFound = $query->fetch(PDO::FETCH_ASSOC);

    if (!$userFound) {
        $message = "Vos identifiants n'existent pas.";
    } else {
        $validPassword = password_verify($_POST['password'], $userFound['utilisateur_mdp']);
        if ($validPassword) {
            $data = [
                'login' => $_POST['login'],
                'nom' => $userFound['utilisateur_nom'],
                'prenom' => $userFound['utilisateur_prénom']
            ];

            $_SESSION['utilisateur'] = $data;

            $message = 'Vous êtes maintenant connecté!';
            header("refresh:2;url=./backoffice.php");
        } else {
            $message = "Mot de passe incorrect.";
        }
    }
}

?>

<head>
    <meta charset="utf-8">
    <title>CSE</title>
</head>

<body>
    <h1>Connexion</h1>

    <form action="#" method="POST">

        <?= $message ?><br>
        <label for="login">Login :</label>
        <input id="login" type="text" name="login"><br>

        <label for="password">Mot de passe :</label>
        <input id="password" type="password" name="password"/><br>

        <button>Connexion</button>

    </form>

</body>