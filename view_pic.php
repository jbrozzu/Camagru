<?php
	require_once 'config/database.php';
	require_once 'functions.php';
    session_start();

    date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['pseudo'])) {
        header('Location: index.php?page=1');
        die;
    }
    
    $retour_com = $bdd->prepare('SELECT * FROM comments WHERE pic_name = :name ORDER BY date_publication DESC');
    $retour_com->execute(array(':name' => mysqli_real_escape_string($link, $_GET['img'])));
    $retour_com->setFetchMode(PDO::FETCH_ASSOC);
    $comments = $retour_com->fetchAll();

    $retour_total=$bdd->prepare('SELECT COUNT(*) AS total FROM comments WHERE pic_name = :name');
    $retour_total->execute(array(':name' => mysqli_real_escape_string($link, $_GET['img'])));
    $retour_total->setFetchMode(PDO::FETCH_ASSOC);
    $total = $retour_total->fetch();

    $likes_nb = $bdd->prepare('SELECT COUNT(*) AS total FROM likes WHERE pic_name = ? AND activate = 1');
    $likes_nb->execute(array(mysqli_real_escape_string($link, $_GET['img'])));
    $likes_nb->setFetchMode(PDO::FETCH_ASSOC);
    $total_like = $likes_nb->fetch();
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

        	<div id="gallery2">

	        	<div id="cont_main_pic">
	        		<img id="main_pic" src="img/<?php echo $_GET['img']?>">
	        	</div>
	        	<div id="info_pic2"> 
                    Photo prise par : <?php echo htmlspecialchars($_GET['user']); ?> 
                    <?php if (checkLikes($bdd, $_SESSION['pseudo'], $_GET['img']) == 1) { ?>
                    	<div class="cont_like_com"> <a href="check_likes.php?img=<?php echo $_GET['img'] ?>&user=<?php echo $_GET['user'] ?>"><img class="like_comment" src="photos/like_vert.png"></a> <?php echo $total_like['total']; ?> </div>
                    <?php }
                    	  else { ?>
                    	<div class="cont_like_com"> <a href="check_likes.php?img=<?php echo $_GET['img'] ?>&user=<?php echo $_GET['user'] ?>"><img class="like_comment" src="photos/like.png"></a> <?php echo $total_like['total']; ?> </div>
                    <?php } ?>
                    <div class="cont_like_com"> <img class="like_comment" src="photos/comment.png"> <?php echo $total['total']; ?> </div>
                </div>

        	</div>

        	<div class="commentaire">

        		<form action="add_comment.php?img=<?php echo $_GET['img'] ?>&user=<?php echo $_GET['user'] ?>" method="POST">
				<div class="commentaire_zone">
					<textarea id="zone" rows="5" cols="20" placeholder="Ecrivez votre commentaire..." name="comment" required></textarea>
				</div>
				<div class="commentaire_bouton">
				  	<input id="submit-comment" type="submit" class="bouton_com" value="ENVOYER">
				</div>
				</form>

				<div id="title_com" > Commentaires : </div>

				<div class="afficheCom">

		                <?php
		                    foreach ($comments as $comment) { 
		                ?>
		                    <div class="com_unique">
		                        <div style="font-weight: bold;"> <?php echo htmlspecialchars($comment['author']) . ' : '; ?> 
		                        <?php if ($comment['author'] == $_SESSION['pseudo']) { ?>
		                        	<a href="delete_com.php?id=<?php echo $comment['id'];?>&img=<?php echo $_GET['img'] ?>&user=<?php echo $_GET['user'] ?>" onclick="return confirm('Are you sure?')"> 
		                        	<img class="cross_com" src="./photos/cross.png"> </a>
		                        <?php } ?>
		                        </div>
		                            <?php echo htmlspecialchars($comment['comment']); ?> </br>

		                        <div style="font-style: italic;">     
		                        	<?php
                                    $time = strtotime($comment['date_publication']);
									echo 'Posté il y a '. humanTiming($time); ?>
		                        </div> 

		                    </div>
		                <?php
		                    }
		                ?>
				</div>		
    		</div>
        </div>

        <?php require_once 'footer.php'; ?>

    </body>
</html>