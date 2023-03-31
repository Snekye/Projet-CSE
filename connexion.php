<?php
require ('require_connexion_bdd.php');
session_start();

$message = "";

if (isset($_POST['login']) && isset($_POST['password'])) {
    $query = $connexion->prepare('
        SELECT Nom_Utilisateur, Prenom_Utilisateur, Email_Utilisateur, Password_Utilisateur
        FROM utilisateur
        WHERE Email_Utilisateur = :login');

    $query->bindParam(':login', $_POST['login']);
    $query->execute();
    $userFound = $query->fetch(PDO::FETCH_ASSOC);

    if (!$userFound) {
        $message = "Vos identifiants n'existent pas.";
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
            $message = '<span style="color: green">Mot de passe incorrect.</span>';
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