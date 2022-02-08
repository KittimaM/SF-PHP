<?php //http://localhost/SFphp/admin/user/user.php
    require('../../server/connectdb.php'); //connect db


    if(!isset($_POST['fname'])){
        $stmt = $pdo->prepare("SELECT * FROM user EXCEPT SELECT * FROM user WHERE status = 'admin' ");
        $stmt->execute();

    }elseif(isset($_POST['fname'])){
        $stmt = $pdo->prepare("SELECT * FROM user WHERE fname LIKE '%$_POST[fname]%' EXCEPT SELECT * FROM user WHERE status = 'admin'  ");
        $stmt->execute();

        unset($_POST['fname']);
    }else{
        $_SESSION["fail"] = "Searching Failed";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin</title>
     <!--start style --------------------------------------------------------------->
     <style>
         .card-header{
            text-align: center;
        }
        .card-container{
            padding: 20px 5%;
        }
        select{
            width: 70%;
        }
        table{
            margin: 20px auto 0;
            text-align: center;
        }
        th{
            margin: 0 auto;
        }
    </style>
    <!--end style --------------------------------------------------------------->
</head>
<body>
    <?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 class = "header">USER</h1>
        </div>
    <?php if(isset($_SESSION["fail"])):?>
        <hr>
        <div class="alert alert-danger" role="alert">
            <?=$_SESSION["fail"]?>
        </div>
        <hr>
    <?php 
        unset($_SESSION["fail"]);
        endif;
    ?>

    <div class="card-container">
    <div class="heada d-flex">
        <div class="col-8">
            <a class="btn btn-primary" href="user.php">SHOW ALL</a>
        </div>
   
        <form class ="d-flex col-2" method="post">
            <input type="search" name="fname" placeholder="FIRST NAME(ENG)" required>
            <input type="submit" value="search">
        </form>
        
        
    </div>
    <div class="tb">
        <table class = "table table-striped table-hover">
            <thead class = "table-dark">
                <th>FIRST NAME</th>
                <th>LAST NAME</th>
                <th>EMAIL</th>
                <th>TEL</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($row = $stmt->fetch()): ?>
                <tr>
                <td align = 'center'><?=$row["fname"] ?></td>
                <td align = 'center'><?=$row["lname"] ?></td>
                <td align = 'center'><?=$row["email"] ?></td>
                <td align = 'center'><?=$row["tel"] ?></td>
                
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
</body>
</html>