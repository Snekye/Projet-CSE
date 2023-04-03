<?php

try {
	$user = "root";
	$pass = "";
	$dbName = "projet_cse";
	$connexion = new \PDO("mysql:host=127.0.0.1;dbname=$dbName;charset=UTF8", $user, $pass);
} catch (\Exception $exception) {
	echo 'Erreur lors de la connexion à la base de données. : ' . $exception->getMessage();
	exit;
}
