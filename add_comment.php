<?php
    require_once 'functions.php';
    require_once 'config/database.php';
    session_start();

    if (strlen($_POST['comment']) > 300) {
    	$_SESSION['ERROR_MESSAGE'] = '<div id="error">Votre commentaire est trop long (300 caractères max).</div>';
    }
    else {
	    $req = $bdd->prepare('INSERT INTO comments (comment, pic_name, author, date_publication) VALUES(?, ?, ?, NOW())');
		$req->execute(array($_POST['comment'], mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
		$_SESSION['SUCCESS_MESSAGE'] = '<div id="success">Votre commentaire a bien été enregistré.</div>';

        if ($_GET['user'] != $_SESSION['pseudo']) {

            $req_email = $bdd->prepare('SELECT email FROM Users WHERE pseudo = ?');
            $req_email->execute(array($_GET['user']));
            $email = $req_email->fetchColumn();

            $to      = $email;
            $subject = 'Nouveau commentaire';
            $message = '
            
            Des nouvelles sur Camagru,

            Une de vos photos vient d\'être commentée par ' . $_SESSION['pseudo'] . ' !
            
             
            Pour le consulter, cliquez sur ce lien:
            http://' . gethostname() . ':8080/Camagru/view_pic.php?img=' . $_GET['img'] . '&user=' . $_GET['user'] . ' 
            ';
                                 
            $headers = 'From:noreply@yourwebsite.com' . "\r\n";
            mail($to, $subject, $message, $headers);
        }
	}

	header('Location: view_pic.php?img=' . $_GET['img'] . '&user=' . $_GET['user']);

?>