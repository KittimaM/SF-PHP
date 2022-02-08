<?php
    require('../../server/connectdb.php'); //connect db
    session_start();

    if(isset($_POST['id_branch']) and isset($_POST['name_branch']) and isset($_POST['id_province']) and isset($_POST['id'])){

        
        $check = $pdo->prepare("SELECT * FROM branch WHERE name_branch = :name_branch");
        $check->bindParam(':name_branch',$_POST['name_branch']);
        $check->execute();
        $check = $check->fetch();
        if($check != NULL){
            if($check['id_branch'] == $_POST['id_branch']){
                $stmt = $pdo->prepare(" UPDATE branch SET name_branch = :name_branch, id_province = :id_province, branch_type = :id 
                WHERE id_branch = :id_branch ");
                $stmt->bindParam(':id_branch',$_POST['id_branch']);
                $stmt->bindParam(':name_branch',$_POST['name_branch']);
                $stmt->bindParam(':id_province',$_POST['id_province']);
                $stmt->bindParam(':id',$_POST['id']);
                $stmt->execute();
                $_SESSION["success"] = "Editing Success";

            }else{

                 $_SESSION['fail'] = 'this branch already exits';
            }
        }else{

            $stmt = $pdo->prepare(" UPDATE branch SET name_branch = :name_branch, id_province = :id_province, branch_type = :id 
            WHERE id_branch = :id_branch ");
            $stmt->bindParam(':id_branch',$_POST['id_branch']);
            $stmt->bindParam(':name_branch',$_POST['name_branch']);
            $stmt->bindParam(':id_province',$_POST['id_province']);
            $stmt->bindParam(':id',$_POST['id']);
            $stmt->execute();
            $_SESSION["success"] = "Editing Success";
        }
        
     
    }else{
        $_SESSION["error"] = "ERROR";
        
    }
    header( "location: branch.php" );
?>