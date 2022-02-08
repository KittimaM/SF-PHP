<?php
    require('../../server/connectdb.php'); //connect db
    session_start();

    if(!isset($_POST['name_province'])){
        $_SESSION["fail"] = "Adding Failed";
   
    }elseif(isset($_POST['name_province']) and isset($_POST['region'])){

        
            $lastID = $pdo->prepare('SELECT id_province FROM province ORDER BY id_province DESC LIMIT 1');
            $lastID->execute();
            $lastID = $lastID->fetch();
        
            if(empty($lastID)){
                $lastID = "0";
            }else if($lastID == 'fff'){
                $_SESSION["error"] = "ERROR";
                header( "location: province.php" );
            }else{
                $lastID = $lastID[0];
            }
            
            $lastID = hexdec($lastID);
            $lastID = dechex((int)( $lastID + 1));
            $lastID = sprintf('%03s',$lastID);

            $check = $pdo->prepare("SELECT * FROM province WHERE name_province = :name_province ");
            $check->bindParam(':name_province',$_POST['name_province']);
            $check->execute();
            if($check->fetch() != NULL){
                $_SESSION["fail"] = "this province already exits";
            }else{
                $stmt = $pdo->prepare("INSERT INTO province (id_province,name_province,region) 
                VALUES (:id,:name_province,:region)");
                $stmt->bindParam(':id',$lastID);
                $stmt->bindParam(':name_province',$_POST['name_province']);
                $stmt->bindParam(':region',$_POST['region']);
                $stmt->execute();

                $_SESSION["success"] = "Adding Success";
            }
            
        
    }else{
        $_SESSION["error"] = "ERROR";
        
    }
    header( "location: province.php" );
    
?>