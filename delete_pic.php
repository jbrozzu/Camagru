<?php

	require_once 'config/database.php';

	$img_name = $_GET['id'];
	$req_img = $bdd->prepare('DELETE FROM Images WHERE img_name = :name');
	$req_img->bindValue(':name', mysqli_real_escape_string($link, $img_name));
	$req_img->execute();
	header("Location: cam.php");

?>