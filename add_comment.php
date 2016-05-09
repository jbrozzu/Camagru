<?php
    require_once 'functions.php';
    require_once 'config/database.php';
    session_start();

    if (strlen($_POST['comment']) > 300) {
    	$_SESSION['ERROR_MESSAGE'] = '<div id="error">Votre commentaire est trop long (300 caractères max).</div>';
    }
    else {
	    $req = $bdd->prepare('INSERT INTO comments (comment, pic_name, author, date_publication) VALUES(?, ?, ?, NOW())');
		$req->execute(array(mysqli_real_escape_string($link, $_POST['comment']), mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Votre commentaire a bien été enregistré.</div>';
	}


	header('Location: view_pic.php?img=' . $_GET['img'] . '&user=' . $_GET['user']);


?>