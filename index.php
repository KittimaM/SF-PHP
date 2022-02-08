<?php
    session_start();
    if(!isset($_SESSION['email'])){
        $_SESSION["msg"] = "!!You must login!!";
        header('location: login.php');
    }
    
    if(isset($_GET['logout'])){
        session_destroy();
        session_unset();
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>
    <style>
        .header,.content{
            text-align: center;
        }
        .content>a{
            margin-right:20px;
        }
        .go{
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Main Page</h1>
    </div>
    <div class="content">
        <?php if(isset($_SESSION['email'])):?>
            <p>Welcome <strong><?php echo $_SESSION['email'];?></strong></p>
            <p>Name :<strong><?php echo $_SESSION['fname'];?></strong>&nbsp;&nbsp;<strong><?php echo $_SESSION['lname'];?></strong></p>
            <p>tel : <strong><?php echo $_SESSION['tel'];?></strong></p>
            <?php if($_SESSION['status'] == 'Admin'):?>
                <a class="go" href="./admin">Go to admin page</a>
            <?php endif;?>
            <p><a href="./client_customer/profile">Profile</a></p>
            <p><a href="./client_customer/seat/select.php">Seat</a></p>   
            <p><a href="index.php?logout=1">Logout</a></p>
        <?php endif;?>
    </div>
</body>
</html>