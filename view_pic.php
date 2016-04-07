<?php
	require_once 'config/database.php';
	require_once 'functions.php';
    session_start();
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/footer.css" />
        <title> Camagru </title>
    </head>
    
    <body>

        <?php LogMessage(); ?>
        <?php require_once 'header.php'; ?>

        <div class="corpus">

        	<div id="cont_main_pic">
        		<img id="main_pic" src="img/<?php echo $_GET['img']?>">
        	</div>

        </div>

        <?php require_once 'footer.php'; ?>

    </body>
</html>