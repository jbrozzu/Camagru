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



         <?php    while($img = $retour_img->fetch()) { ?>
            <div id="gallery">
                <?php if (isset($_SESSION['pseudo'])) { ?>
                    <a href="view_pic.php?img=<?php echo $img['img_name']; ?>"><img class="picture" src="./img/<?php echo $img['img_name']; ?>"></a>
            <?php }
                else { ?>
                    <img class="picture" src="./img/<?php echo $img['img_name']; ?>">
            <?php }  ?>
                <div id="info_pic"> 
                    Photo prise par : <?php echo $img['user_name']; ?> 
                    <div class="cont_like_com"> <img class="like_comment" src="photos/like.png"> 0 </div>
                    <div class="cont_like_com"> <img class="like_comment" src="photos/comment.png"> 0 </div>
                </div>
            </div>
        <?php
            }
        ?>
   
        </div>

        <div id="page_index"> Page :
        <?php   for($i=1; $i<=$nombreDePages; $i++) {
                    if($i==$pageActuelle) {
                        echo ' [ '.$i.' ] '; 
                    }  
                    else {
                        echo ' <a href="index.php?page='.$i.'">'.$i.'</a> ';
                    }
                } ?> 
        </div> 

        <?php require_once 'footer.php'; ?>

    </body>
</html>

