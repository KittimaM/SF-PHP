<?php
   require('../../server/connectdb.php'); //connect db
    session_start();

    if(isset($_POST['id_province']) and isset($_POST['name_province']) and isset($_POST['region'])){
     
        
        $check = $pdo->prepare("SELECT * FROM province WHERE name_province = :name_province ");
        $check->bindParam(':name_province',$_POST['name_province']);
        $check->execute();
        $check = $check->fetch();
        
        if($check != NULL){
            if($check['id_province'] == $_POST['id_province']){
                $stmt = $pdo->prepare(" UPDATE province SET name_province = :name_province , region = :region WHERE id_province = :id_province ");
                $stmt->bindParam(':name_province',$_POST['name_province']);
                $stmt->bindParam(':region',$_POST['region']);
                $stmt->bindParam(':id_province',$_POST['id_province']);
                $stmt->execute();
                $_SESSION["success"] = "Editing Success";
            }else{

                $_SESSION['fail'] = 'this province already exits';
            }

        }else{

            $stmt = $pdo->prepare(" UPDATE province SET name_province = :name_province , region = :region WHERE id_province = :id_province ");
            $stmt->bindParam(':name_province',$_POST['name_province']);
            $stmt->bindParam(':region',$_POST['region']);
            $stmt->bindParam(':id_province',$_POST['id_province']);
            $stmt->execute();
            $_SESSION["success"] = "Editing Success";
        }
    
        
    }else{
        $_SESSION["error"] = "ERROR";
      
    }
  header( "location: province.php" );
?>