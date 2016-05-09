<?php

	require_once 'config/database.php';

	$com_id = $_GET['id'];
	$req_com = $bdd->prepare('DELETE FROM comments WHERE id = :id');
	$req_com->bindValue(':id', $com_id);
	$req_com->execute();
	header('Location: view_pic.php?img=' . $_GET['img'] . '&user=' . $_GET['user']);

?>