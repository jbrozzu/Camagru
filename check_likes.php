<?php
    require_once 'functions.php';
    require_once 'config/database.php';
    session_start();


    $likes_nb = $bdd->prepare('SELECT COUNT(*) AS total FROM likes WHERE pic_name = ? AND user_name = ?');
    $likes_nb->execute(array(mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
    $likes_nb->setFetchMode(PDO::FETCH_ASSOC);
    $total_like = $likes_nb->fetch();
    if ($total_like['total'] < 1) {
        $likes_ini = $bdd->prepare('INSERT INTO likes (pic_name, user_name, activate) VALUES(?, ?, 1)');
        $likes_ini->execute(array(mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
    }
    else {
        $likes = $bdd->prepare('SELECT * FROM likes WHERE pic_name = ? AND user_name = ?');
        $likes->execute(array(mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
        $likes->setFetchMode(PDO::FETCH_ASSOC);
        $fetch_likes = $likes->fetch();
        if ($fetch_likes['activate'] == 1) {
            $likes_up = $bdd->prepare('UPDATE likes SET activate = 0 WHERE pic_name = ? AND user_name = ?');
            $likes_up->execute(array(mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
        }
        else {
            $likes_up = $bdd->prepare('UPDATE likes SET activate = 1 WHERE pic_name = ? AND user_name = ?');
            $likes_up->execute(array(mysqli_real_escape_string($link, $_GET['img']), $_SESSION['pseudo']));
        }
    }

	header('Location: view_pic.php?img=' . $_GET['img'] . '&user=' . $_GET['user']);

?>