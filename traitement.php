<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=Camagru;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$pass_hache = sha1($_POST['pass']);
$req = $bdd->prepare('INSERT INTO Users (pseudo, email, mdp, date_inscription) VALUES(?, ?, ?, NOW())');
$req->execute(array($_POST['pseudo'], $_POST['email'], $pass_hache));

 header('Location: index.php');

?>