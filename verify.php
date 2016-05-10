<?php

	require_once 'config/database.php';
	require_once 'functions.php';
	session_start();

	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	if (isset($_GET['pseudo']) && !empty($_GET['pseudo']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
	 	$pseudo = mysqli_real_escape_string($link, $_GET['pseudo']);
    	$hash = mysqli_real_escape_string($link, $_GET['hash']);
	                 
	    $search = $bdd->prepare("SELECT pseudo, mdp, active FROM Users WHERE pseudo = ? AND mdp = ? AND active = '0' "); 
	    $search->execute(array($pseudo, $hash));
	    
	                 
	    if ($search->fetchColumn()) {
	        $active = $bdd->prepare("UPDATE Users SET active = '1' WHERE pseudo = ? AND mdp = ?");
	        $active->execute(array($pseudo, $hash));
	        SuccessMess(2);
	        $_SESSION['pseudo'] = $pseudo;
	        header('Location: index.php');
	        die;
	    }
	    else {
	        $_SESSION['ERROR_MESSAGE'] = '<div id="error">Ce lien est invalide ou le compte a déjà été activé.</div>';
	        header('Location: index.php');
	        die;
	    }                 
	}
	 else {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Veuillez utiliser le lien qui vous à été envoyer par email.</div>';
        header('Location: index.php');
        die;
	 }

?>