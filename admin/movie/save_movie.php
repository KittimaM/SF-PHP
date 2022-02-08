<?php
    include "../../server/connectdb.php";
    session_start();
    //ทำต่อด้วย()
    // if($_POST["time_movie_hour"] == 0 AND  $_POST["time_movie_minute"] == 0  AND $_POST["time_movie_second"]==0){
    //     $_SESSION["time_error"] = "*The show time of the movie cannot be set 0:00:00.";
    //     $_SESSION["movie_add_eng"] = $_POST["eng_name"];
    //     $_SESSION["movie_add_thai"] = $_POST["thai_name"];
    //     $_SESSION["movie_add_detail"] = $_POST["detail"];
    //     $_SESSION["movie_add_file"] =  $_FILES["fileToUpload"]["name"];
    //     $_SESSION["movie_add_type"] = $_POST["type_of_movie"];
    //     header();
    //     exit(0);
    // }
    do{
        $id = uniqid();
        $cid = $pdo->prepare("SELECT COUNT(id_movie) FROM movie WHERE id_movie = '$id'");
        $cid->execute();
    }while($cid->fetch()[0] != 0);
    echo $id.'<br>';
    $name = $id;

    $img_file = $_FILES["fileToUpload"]["name"];//ชื่อไฟล์
    $type = $_FILES["fileToUpload"]["type"];//
    $size = $_FILES["fileToUpload"]["size"];
    $temp = $_FILES["fileToUpload"]["tmp_name"];
    $lname = explode('.',$img_file)[1];
    $path = "../../img/movie_img/". $name.'.'.$lname;
    echo $path.'<br>';
    if(empty($img_file)){
        $errorMsg = "Please Select Image";
    }else if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif"){
        if(!file_exists($path)){
            if( $size < 50000000){
                move_uploaded_file($temp, $path);
            }else{
                $errorMsg = "Sorry, your file is too large.";
            }
        }else{
            $errorMsg = "Sorry, file already exists.";
        }
    }else{
        $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    $detail = $_POST["detail"];
    $eng_name = $_POST["eng_name"];
    $thai_name = $_POST["thai_name"];
    $time_movie_hour = $_POST["time_movie_hour"];
    $time_movie_minute = $_POST["time_movie_minute"];
    $time_movie_second = $_POST["time_movie_second"];
    $type_of_movie = $_POST["type_of_movie"];
    $real_name = $name.'.'.$lname;

    $get_data = $pdo->prepare("INSERT INTO movie VALUES (:id,:name_eng,:name_thai,:img,:detail,:movie_time_h,:movie_time_m,:movie_time_s,:type)");
    $get_data->bindParam(':id', $id);
    $get_data->bindParam(':name_eng', $eng_name);
    $get_data->bindParam(':name_thai',$thai_name);
    $get_data->bindParam(':detail',$detail);
    $get_data->bindParam(':img',$real_name);
    $get_data->bindParam(':movie_time_h',$time_movie_hour);
    $get_data->bindParam(':movie_time_m',$time_movie_minute);
    $get_data->bindParam(':movie_time_s',$time_movie_second);
    $get_data->bindParam(':type',$type_of_movie);
    $get_data->execute();
    $_SESSION["msg_movie_add"] = "Adding success";
    header('location:main.php?');
?>