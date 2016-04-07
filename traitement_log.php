<?php

	require_once 'config/database.php';
	require_once 'functions.php';
	session_start();

	if (CheckLog($_POST['pseudo'], $_POST['pass'], $bdd) == true) {
		$_SESSION['pseudo'] = $_POST['pseudo'];

		$path_img = "img/".$_SESSION['pseudo'];
		if (!file_exists($path_img)) {
	  		mkdir($path_img, 0700);
	  	}
		
		header('Location: index.php');
	}
	else {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Le mot de passe est invalide.</div>';
		header('Location: login.php');
	}
?>