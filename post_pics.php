<?php

	require_once 'config/database.php';
	session_start();


	if (isset($_POST['img'])) {
		$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['img']));
		file_put_contents('img/'.$_SESSION['pseudo'].'/image-'.time().'.png', $data);

		$img_name = $_SESSION['pseudo'].'/image-'.time().'.png';
		$req_insert_img = $bdd->prepare('INSERT INTO Images (img_name, user_name, date_creation) VALUES (?, ?, NOW())');
		$req_insert_img->execute(array(mysqli_real_escape_string($link, $img_name), $_SESSION['pseudo']));

		header('Location: cam.php');
	}

?>