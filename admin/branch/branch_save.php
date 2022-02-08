<?php
    require('../../server/connectdb.php'); //connect db
    session_start();
    if(!isset($_POST['name_branch'])){
        $_SESSION["fail"] = "Adding Failed";
        header( "location: branch.php" );
    }
    elseif(isset ($_POST['name_branch']) and ($_POST['id_province']) and ($_POST['id']) ){
       
            $lastID = $pdo->prepare('SELECT id_branch FROM branch ORDER BY id_branch DESC LIMIT 1');
            $lastID->execute();
            $lastID = $lastID->fetch();
        
            if(empty($lastID)){
                $lastID = "0";
            }else if($lastID == 'fffff'){
                $_SESSION["error"] = "ERROR";
                header( "location:branch.php" );
            }else{
                $lastID = $lastID[0];
            }
            
            $lastID = hexdec($lastID);
            $lastID = dechex((int)( $lastID + 1));
            $lastID = sprintf('%05s',$lastID);

            $check = $pdo->prepare("SELECT * FROM branch WHERE name_branch = :name_branch");
            $check->bindParam(':name_branch',$_POST['name_branch']);
            $check->execute();

            if($check->fetch() != NULL){

                $_SESSION["fail"] = "this branch already exits";

            }else{
                
                $stmt = $pdo->prepare("INSERT INTO branch (id_branch,name_branch,id_province,branch_type) 
                VALUES (:id,:name_branch,:id_province,:branch_type)");
                $stmt->bindParam(':id',$lastID);
                $stmt->bindParam(':name_branch',$_POST['name_branch']);
                $stmt->bindParam(':id_province',$_POST['id_province']);
                $stmt->bindParam(':branch_type',$_POST['id']);
                $stmt->execute();

                $_SESSION["success"] = "Adding Success";
            }
         
           
      
    }else{
        $_SESSION["error"] = "ERROR";
    }
    header( "location: branch.php" );
?>