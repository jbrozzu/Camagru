<?php

    require_once 'functions.php';
    require_once 'config/database.php';
    session_start();

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    if (!isset($_SESSION['pseudo'])) {
        header('Location: index.php?page=1');
        die;
    }

    $get_img = $bdd->prepare('SELECT * FROM Images WHERE user_name = :pseudo ORDER BY date_creation DESC');
    $get_img->execute(array(':pseudo' => $_SESSION["pseudo"]));
    $get_img->setFetchMode(PDO::FETCH_ASSOC);
    $imgs = $get_img->fetchAll();

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

        <?php 
            LogMessage();
            require_once 'header.php';
         ?>

         <div class="corpus">


            <div id="display_stiker">
                <div class="stiker_scroll">
                <?php
                    $path_png = "./img_png";
                    $pngs = scandir($path_png);
                    foreach ($pngs as $png) {
                    if ($png != "." && $png != "..") {
                        $id = strpos($png, '.');
                        $id = substr($png, 0, $id);
                ?>
                
                    <div class="stiker">
                      <div class="">
                        <img id="<?php echo $id; ?>" width="90px" height="90px" src="./img_png/<?php echo $png; ?>" alt="" />
                      </div>
                      <div class="">
                        <input type="radio" name="groupe_png" value="<?php echo $id; ?>" onclick="document.getElementById('capture').disabled = false">
                      </div>
                    </div>

                <?php
                    }
                }
                ?>
                </div>

            </div>

            <form id="form_upload" enctype="multipart/form-data" action="upload.php" method="post">              
                    <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Uploader :</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                    <input name="fichier" type="file" id="fichier_a_uploader" />
                    <input id="upload" type="submit" name="submit" value="Uploader" />                 
            </form>

            <div class="container">

                <div class="booth"> 
                <?php if ($_GET["img"] == "upload") { ?>
                    <img id="image" width="400" height="300" src="./files/upload.png">
                <?php }
                      else { ?>
                    <video id="video" width="400" height="300"> </video>
                <?php } ?>

                    <button href="#" id="capture" class="booth-capture-button" onclick="document.getElementById('submit').disabled = false" disabled>TAKE PHOTO</button>
                    <canvas id="canvas" width="400" height="300" > </canvas>
                    <img id="photo" src="photos/placeholder.jpg">
                    
                    <form action="post_pics.php" method="POST">
                      <input type="hidden" name="img" id="postpic">
                      <input type="submit" value="SAVE" onclick="getDataURL();" id ="submit" class="booth-capture-button" disabled>
                    </form>

                </div>

                <div class="mini_galery">

                <?php

                    foreach ($imgs as $img) { 
                ?>
                        <div class="mini_pic" style="background-image: url(./img/<?php echo $img['img_name'] ?>);">
                            <a href="delete_pic.php?id=<?php echo $img['img_name']; ?>" onclick="return confirm('Are you sure?')"> <img class="cross" src="./photos/cross.png"> </a>
                        </div> 
                <?php
                    }
                ?>

                </div>
                
                <?php if ($_GET["img"] == "upload") { ?>
                    <script src="js/photo2.js"></script>
                <?php }
                      else { ?>
                    <script src="js/photo.js"></script>
                <?php } ?>
                    

            </div>

        </div>

        <?php require_once 'footer.php'; ?>

    </body>
</html>