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
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Vous avez bien été enregistré.</div>';
	}
}

function CheckLog($pseudo, $pass, $bdd) {
	$req_pseudo = $bdd->prepare('SELECT pseudo FROM USERS where pseudo = :pseudo');
	$req_pseudo->bindParam(':pseudo', $pseudo);
	$req_pseudo->execute();
	if ($req_pseudo->fetchColumn()) {
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
    	$_SESSION['ERROR_MESSAGE'] = '<div id="error">Ce pseudo' . $req_pseudo->fetchColumn() .' est invalide.</div>';
		header('Location: login.php');
    	die;
    }
}

?>