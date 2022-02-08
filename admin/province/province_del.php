<?php
    require('../../server/connectdb.php'); //connect db
    session_start();
    
        if(!isset($_GET['id_province'])){
            $_SESSION["fail"] = "Delete Failed";
            
        }
        elseif(isset($_GET['id_province'])){
            $id = $_GET['id_province'];
            $check = $pdo->prepare("SELECT * FROM branch WHERE id_province = '$id' ");
            $check->execute();
            if($check->fetch() != NULL){
                $_SESSION["fail"] = "You can't delete province that used by branch";
            }else{
                $stmt = $pdo->prepare("DELETE FROM province WHERE id_province = '$id' ");
                $stmt->execute();
                $_SESSION["success"] = "Delete Success";
            }
        }else{
            $_SESSION["error"] = "ERROR";
        }
    
    header( "location: province.php" );

    
?>