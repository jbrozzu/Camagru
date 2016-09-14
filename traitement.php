<?php
	
	require_once 'config/database.php';
	require_once 'functions.php';
	session_start();

	CheckUniqueInfo($_POST['pseudo'], $_POST['email'], $bdd);
	CheckMdp($_POST['pass'], $_POST['cpass']);

	$pass_hache = sha1($_POST['pass']);
	$req = $bdd->prepare('INSERT INTO Users (pseudo, email, mdp, date_inscription) VALUES(?, ?, ?, NOW())');
	$req->execute(array(mysqli_real_escape_string($link, $_POST['pseudo']), mysqli_real_escape_string($link, $_POST['email']), $pass_hache));
	SuccessMess(1);

	$path_img = "img/".$_SESSION['pseudo'];
	if (!file_exists($path_img)) {
  		mkdir($path_img, 0700);
  	}


  	$to      = $_POST['email'];
	$subject = 'Signup | Verification';
	$message = '
	 
	Votre compte a bien été créé.
	Afin d\'activer ce compte, merci de bien vouloir cliquer sur le lien ci dessous.
	 
	------------------------
	Pseudo: '.$_POST['pseudo'].'
	E-mail: '.$_POST['email'].'
	------------------------
	 
	Si les informations sont exactes, cliquer sur ce lien:
	http://localhost:8080/Camagru/verify.php?pseudo='.$_POST['pseudo'].'&hash='.$pass_hache.'
	 
	';

	//  http://' . gethostname() . ':8080/Camagru/verify.php?pseudo='.$_POST['pseudo'].'&hash='.$pass_hache.'
	 
	                     
	$headers = 'From:noreply@yourwebsite.com' . "\r\n";
	mail($to, $subject, $message, $headers);


	header('Location: index.php');

?>