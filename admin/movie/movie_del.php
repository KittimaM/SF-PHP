<?php
    session_start();
    if(!isset($_GET['del_id']) && !isset($_GET['img'])){
        header('Location: movie_list.php');
    }
    include '../../server/connectdb.php';
    $path = '../../img/movie_img/'.$_GET['img'];
    if(file_exists($path)){
        unlink($path);
    }
    ///echo $_GET['del_id'];
    
    
    $del = $pdo->prepare("DELETE FROM movie WHERE id_movie = :del_id");
    $del->bindParam(':del_id',$_GET['del_id']);
    $del->execute();
    $_SESSION['msg_movie_del'] = "Delete success";
    header('location: main.php');
?>