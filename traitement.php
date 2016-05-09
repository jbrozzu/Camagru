<?php
	
	require_once 'config/database.php';
	require_once 'functions.php';
	session_start();

	CheckUniqueInfo($_POST['pseudo'], $_POST['email'], $bdd);
	CheckMdp($_POST['pass'], $_POST['cpass']);

	$pass_hache = sha1($_POST['pass']);
	$req = $bdd->prepare('INSERT INTO Users (pseudo, email, mdp, date_inscription) VALUES(?, ?, ?, NOW())');
	$req->execute(array(mysqli_real_escape_string($link, $_POST['pseudo']), mysqli_real_escape_string($link, $_POST['email']), $pass_hache));
	$_SESSION['pseudo'] = $_POST['pseudo'];
	SuccessMess(1);

	$path_img = "img/".$_SESSION['pseudo'];
	if (!file_exists($path_img)) {
  		mkdir($path_img, 0700);
  	}

	header('Location: index.php');

?>