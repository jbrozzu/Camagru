<?php
	
	require_once 'config/database.php';
	require_once 'functions.php';
	session_start();

	if (CheckLog2($_POST['pseudo'], $_POST['email'], $bdd) == true) {

		$seed = str_split('aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 7) as $k) $rand .= $seed[$k];
        $rand = $rand . rand(1, 9);
        $hash = sha1($rand);

        $req_mdp = $bdd->prepare("UPDATE Users SET mdp = ? WHERE pseudo = ? AND email = ?");
        $req_mdp->execute(array($hash, $_POST['pseudo'], $_POST['email']));

        $to      = $_POST['email'];
		$subject = 'Réinitialisation';
		$message = '
		 
		Votre mot de passe a été réinitialisé.
		Vous pouvez dès à présent vous connecter avec votre nouveau mot de passe.
		 
		------------------------
		Username: '.$_POST['pseudo'].'
		nouveau mot de passe: '.$rand.'
		------------------------
		 
		Cliquez sur ce lien pour revenir sur le site Camagru:
		http://localhost:8080/Camagru/index.php?page=1
		 
		';

		//  http://' . gethostname() . ':8080/Camagru/index.php?page=1
		                     
		$headers = 'From:noreply@yourwebsite.com' . "\r\n";
		mail($to, $subject, $message, $headers);

		SuccessMess(3);
		header('Location: index.php');
		die;
	}
	else {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">La combinaison pseudo/email est invalide.</div>';
		header('Location: forgot.php');
		die;
	}
?>