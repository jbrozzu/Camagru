<?PHP
    require_once 'functions.php';
    require_once 'config/database.php';
    session_start();

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $messagesParPage = 6;

    $retour_total=$bdd->prepare('SELECT COUNT(*) AS total FROM Images');
    $retour_total->execute();
    $retour_total->setFetchMode(PDO::FETCH_ASSOC);
    $total = $retour_total->fetch();

    $nombreDePages = ceil(intval($total['total'])/$messagesParPage);

    if(isset($_GET['page'])) {
        $pageActuelle = intval($_GET['page']);
        if($pageActuelle > $nombreDePages) {
          $pageActuelle = $nombreDePages;
        }
    }
    else {
         $pageActuelle = 1;   
    }

    $premiereEntree=($pageActuelle-1)*$messagesParPage;
 

    $retour_img = $bdd->prepare('SELECT * FROM Images ORDER BY date_creation DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
    $retour_img->execute();
    $retour_img->setFetchMode(PDO::FETCH_ASSOC);

    $retour_total_com=$bdd->prepare('SELECT COUNT(*) AS total FROM comments WHERE pic_name = :name');

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/header.css" />
        <title> Camagru </title>
    </head>
    
    <body>

        <?php LogMessage(); ?>
        <?php require_once 'header.php'; ?>

        <div class="corpus">

        <div id='top'> </div>

    <?php   while($img = $retour_img->fetch()) { ?>
                <div id="gallery">
                    <?php if (isset($_SESSION['pseudo'])) { ?>
                        <a href="view_pic.php?img=<?php echo $img['img_name']; ?>&user=<?php echo $img['user_name']; ?>">
                        <img class="picture" src="./img/<?php echo $img['img_name']; ?>"></a>
                <?php }
                    else { ?>
                        <img class="picture" src="./img/<?php echo $img['img_name']; ?>">
                <?php }  ?>
                    <div id="info_pic"> 
                        Photo prise par : <?php echo htmlspecialchars($img['user_name']); ?> 

                    <?php   
                        $retour_total_com->execute(array(':name' => $img['img_name']));
                        $retour_total_com->setFetchMode(PDO::FETCH_ASSOC);
                        $total_com = $retour_total_com->fetch();  

                        $likes_nb = $bdd->prepare('SELECT COUNT(*) AS total FROM likes WHERE pic_name = ? AND activate = 1');
                        $likes_nb->execute(array($img['img_name']));
                        $likes_nb->setFetchMode(PDO::FETCH_ASSOC);
                        $total_like = $likes_nb->fetch();
                    ?>
                    <?php if (isset($_SESSION['pseudo'])) { 
                            if (checkLikes($bdd, $_SESSION['pseudo'], $img['img_name']) == 1) { ?>
                                <div class="cont_like_com"> <a href="check_likes_index.php?img=<?php echo $img['img_name'] ?>&user=<?php echo $_GET['user'] ?>&page=<?php echo $_GET['page']; ?>"><img class="like_comment" src="photos/like_vert.png"></a> <?php echo $total_like['total']; ?> </div>
                            <?php }
                            else { ?>
                                <div class="cont_like_com"> <a href="check_likes_index.php?img=<?php echo $img['img_name'] ?>&user=<?php echo $_GET['user'] ?>&page=<?php echo $_GET['page']; ?>"><img class="like_comment" src="photos/like.png"></a> <?php echo $total_like['total']; ?> </div>
                            <?php }
                            } 
                           else { ?>
                            <div class="cont_like_com"> <img class="like_comment" src="photos/like.png"> <?php echo $total_like['total']; ?> </div>
                    <?php } ?>


                        <div class="cont_like_com"> <img class="like_comment" src="photos/comment.png"> 
                        <?php echo $total_com['total']; ?> </div>
                    </div>
                </div>
                <?php
            }
        ?>

        <div id='bottom'> </div>

            <div id="page_index"> Page :
            <?php   if (1 > $nombreDePages) {
                        echo ' 1 ';
                    }

                    for($i=1; $i<=$nombreDePages; $i++) {
                        if($i==$pageActuelle) {
                            echo ' [ '.$i.' ] '; 
                        }  
                        else {
                            echo ' <a href="index.php?page='.$i.'">'.$i.'</a> ';
                        }
                    } ?> 
            </div> 
   
        </div>

        <?php require_once 'footer.php'; ?>

    </body>
</html>

