<?php


function LogMessage(){
	if (isset($_SESSION['ERROR_MESSAGE']) && !empty($_SESSION['ERROR_MESSAGE'])) {
		echo $_SESSION['ERROR_MESSAGE'];
		unset($_SESSION['ERROR_MESSAGE']);
	}
	if (isset($_SESSION['SUCCESS_MESSAGE']) && !empty($_SESSION['SUCCESS_MESSAGE'])) {
		echo $_SESSION['SUCCESS_MESSAGE'];
		unset($_SESSION['SUCCESS_MESSAGE']);
	}
}

function CheckMdp($mdp, $cmdp) {
	if (strlen($mdp) < 8 || (!preg_match('`\d`si',($mdp)))) {
	    $_SESSION['ERROR_MESSAGE'] = '<div id="error">Votre mot de passe doit contenir 8 caractères minimum (avec au moins un chiffre).</div>';
	    header('Location: inscription.php');
    	die;
	}
	elseif ($mdp != $cmdp) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Le mot de passe et la confirmation ne sont pas identiques.</div>';
	    header('Location: inscription.php');
    	die;
	}
}

function CheckUniqueInfo($pseudo, $email, $bdd) {
	if (strlen($pseudo) > 20) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Ce pseudo est trop long (20 caractères max).</div>';
		header('Location: inscription.php');
		die;
	}
	if (!preg_match('/^[A-Za-z0-9_]+$/', $pseudo)){
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Le pseudo est invalide (lettres, chiffres et underscore uniquement).</div>';
		header('Location: inscription.php');
		die;
	}
	$req_pseudo = $bdd->prepare('SELECT pseudo FROM USERS where pseudo = :pseudo');
	$req_pseudo->bindParam(':pseudo', $pseudo);
	$req_pseudo->execute();
	$req_email = $bdd->prepare('SELECT email FROM USERS where email = :email');
	$req_email->bindParam(':email', $email);
	$req_email->execute();
	if ($req_pseudo->fetchColumn()) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Ce pseudo est déjà pris.</div>';
		header('Location: inscription.php');
    	die;
    }
	elseif ($req_email->fetchColumn()) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Cette adresse e-mail est déjà prise.</div>';
		header('Location: inscription.php');
    	die;
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">L\'adresse e-mail est invalide.</div>';
		header('Location: inscription.php');
    	die;
	}
}

function SuccessMess($nb) {
	if ($nb == 1) {
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Votre compte a été créé, veuillez l\'activer en cliquant sur le lien qui vous a été envoyer par email.</div>';
	}
	else if ($nb == 2) {
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Votre compte a été activé.</div>';
	}
	else if ($nb == 3) {
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Un mail contenant votre nouveau mot de passe vient de vous être envoyé.</div>';
	}
}

function CheckLog($pseudo, $pass, $bdd) {
	$active = $bdd->prepare('SELECT active FROM Users WHERE pseudo = ?');
	$active->execute(array($pseudo));
	if ($active->fetchColumn() == 0) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Veuillez activer votre compte avant de vous connecter.</div>';
        header('Location: index.php');
        die;
	}

	$req_pseudo = $bdd->prepare('SELECT pseudo FROM USERS where pseudo = :pseudo');
	$req_pseudo->bindParam(':pseudo', $pseudo);
	$req_pseudo->execute();

	if ($req_pseudo->fetchColumn() == $pseudo) {
		$req_password = $bdd->prepare('SELECT mdp FROM USERS where pseudo = :pseudo');
	    $req_password->bindParam(':pseudo', $pseudo);
		$req_password->execute();
		$users = $req_password->fetchAll();
		foreach ($users as $user) {
			if ($user['mdp'] == sha1($pass)) {
				return true;
			}
		}
		return false;
    }
    else {
    	$_SESSION['ERROR_MESSAGE'] = '<div id="error">Ce pseudo est invalide.</div>';
		header('Location: login.php');
    	die;
    }
}

function CheckLog2($pseudo, $email, $bdd) {
	$active = $bdd->prepare('SELECT active FROM Users WHERE pseudo = ?');
	$active->execute(array($pseudo));
	if ($active->fetchColumn() == 0) {
		$_SESSION['ERROR_MESSAGE'] = '<div id="error">Veuillez activer votre compte avant de tenter de réinitialiser le mot de passe.</div>';
        header('Location: index.php');
        die;
    }

	$req_pseudo = $bdd->prepare('SELECT pseudo FROM USERS where pseudo = ? AND email = ?');
	$req_pseudo->execute(array($pseudo, $email));

	if ($req_pseudo->fetchColumn()) {
		return true;
	}
	else {
		return false;
	}


}

function humanTiming($time) {
    $time = time() - $time;
    $time = ($time < 1) ? 1 : $time;
    $tokens = array (
        31536000 => 'an',
        2592000 => 'mois',
        604800 => 'semaine',
        86400 => 'jour',
        3600 => 'heure',
        60 => 'minute',
        1 => 'seconde'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
 	}
 }

function checkLikes($bdd, $user_name, $pic_name) {
	$likes = $bdd->prepare('SELECT * FROM likes WHERE pic_name = ? AND user_name = ?');
    $likes->execute(array($pic_name, $user_name));
    $likes->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_likes = $likes->fetch();
     if ($fetch_likes['activate'] == 1) {
     	return 1;
     }
     else {
     	return 0;
     } 
}

?>