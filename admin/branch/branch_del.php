<?php
    require('../../server/connectdb.php'); //connect db
    session_start();
        if(!isset($_GET['id_branch'])){
            $_SESSION["fail"] = "Delete Failed";
            
        }
        elseif(isset($_GET['id_branch'])){
    
            $id = $_GET['id_branch'];
            $check = $pdo->prepare("SELECT * FROM cinema WHERE id_branch = '$id' ");
            $check->execute();
            if($check->fetch() != NULL){
                $_SESSION["fail"] = "You can't delete branch that used by cinema";
            }else{
                $stmt = $pdo->prepare("DELETE FROM branch WHERE id_branch = '$id' ");
                $stmt->execute();
                $_SESSION["success"] = "Delete Success";
            }
        }

    header( "location: branch.php" );
?>