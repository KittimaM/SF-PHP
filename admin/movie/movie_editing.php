<?php
    include '../../server/connectdb.php';
    session_start();
    if(isset($_POST['submit']) && isset($_GET["id"])){
        $tmp = $pdo->prepare('SELECT * FROM movie WHERE id_movie = :id');
        $tmp->bindParam(':id',$_GET["id"]);
        $tmp->execute();
        $tmp = $tmp->fetch();
        $col = "";
        $arr = array();
        if(!empty($_FILES["fileToUpload"]["tmp_name"])){
            $path = '../../img/movie_img/'.$tmp['movie_photo'];
            if(file_exists($path)){
                unlink($path);
            }
            $changepic = true;
        }else{
            $changepic = false;
        }
        if(isset($_POST['type_of_movie'])){
            $col = $col.'type = :type'.",";
            $arr[':type'] = $_POST['type_of_movie'];
        }
        foreach($_POST as $x => $value){
            if(isset($tmp[$x])){
                if($tmp[$x] != $_POST[$x]){
                    $col = $col.$x.' = :'.$x.",";
                    $arr[':'.$x] = $_POST[$x];
                }
            }
        }
        $arr[':id'] = $_GET["id"];
        if(!empty($col)){
            $col = substr($col,0,-1);
            $col = 'UPDATE movie SET '.$col.' WHERE id_movie = :id';
            echo  $col.'<br>';
            echo '<br>';
            print_r($arr);
            $update = $pdo->prepare($col);
            foreach(array_keys($arr) as $x ){
               $update->bindParam($x,$arr[$x]);
            }
            $update->execute();
        }
        if($changepic){
            $img_file = $_FILES["fileToUpload"]["name"];
            $type = $_FILES["fileToUpload"]["type"];
            $size = $_FILES["fileToUpload"]["size"];
            $temp = $_FILES["fileToUpload"]["tmp_name"];
            $lname = explode('.',$img_file)[1];
            $path = "../../img/movie_img/".$tmp['movie_photo'];
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
        }
        $_SESSION["msg_movie_edit"] = "Editing success";
        header('location:main.php');
    }else{
        header('location:main.php');
    }
    
?>