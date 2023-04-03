<?php
require ('require_connexion_bdd.php');
session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $query = $connexion->prepare('
        SELECT Nom_Utilisateur, Prenom_Utilisateur, Email_Utilisateur, Password_Utilisateur
        FROM utilisateur
        WHERE Email_Utilisateur = :login');

    $query->bindParam(':login', $_POST['login']);
    $query->execute();
    $userFound = $query->fetch(PDO::FETCH_ASSOC);

    if (!$userFound) {
        $message = '<span style="color: red">Identifiants inconnus.</span>';
        $_POST['password'] = '';
    } else {
        $validPassword = password_verify($_POST['password'], $userFound['Password_Utilisateur']);
        if ($validPassword) {
            $data = [
                'login' => $userFound['Email_Utilisateur'],
                'nom' => $userFound['Nom_Utilisateur'],
                'prenom' => $userFound['Prenom_Utilisateur']
            ];

            $_SESSION['utilisateur'] = $data;

            $message = '<span style="color: green;">Vous êtes maintenant connecté!</span>';
            header("refresh:3;url=./backoffice.php");
        } else {
            $message = '<span style="color: red">Mot de passe incorrect.</span>';
            $_POST['password'] = '';
        }
    }
}

require('require_popup.php');
?>

<head>
    <meta charset="utf-8">
    <title>CSE</title>
</head>

<body>
    <h1>Connexion</h1>

    <form action="#" method="POST">

        <label for="login">Login :</label>
        <input id="login" type="text" name="login" value="<?= isset($_POST['login']) ? $_POST['login'] : null ?>"><br>

        <label for="password">Mot de passe :</label>
        <input id="password" type="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : null ?>"><br>

        <button>Connexion</button>

    </form>

</body>