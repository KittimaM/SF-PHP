<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
    <form action="./server/register_db.php" method="post">
        <img src="./img/SF_Cinema_logo.jpg" width="35%">


        <p class="input-name">Email</p>
        <input type="email" name="email" placeholder="Email" maxlength="200" size="200" pattern="{1,200}" value= <?php echo isset($_SESSION['usedEmail'])?$_SESSION['usedEmail']:'';?> >
        <?php if(isset($_SESSION['emailErr'])):?>
            <p class="error"><?php echo $_SESSION['emailErr'];?></p>
            <?php unset($_SESSION['emailErr']);?>
        <?php endif;?>
        <?php unset($_SESSION['usedEmail']);?>
        
        <p class="input-name">Password</p>
        <input type="password" name="password" placeholder="Password" maxlength="100" size="100" pattern="[A-Za-z\d]{6,100}" >
        <?php if(isset($_SESSION['PassErr'])):?>
            <p class="error"><?php echo $_SESSION['PassErr'];?></p>
            <?php unset($_SESSION['PassErr']);?>
        <?php endif;?>

        <p class="input-name">Confirm Password</p>
        <input type="password" name="cpassword" placeholder="Confirm Password" maxlength="100" size="100" pattern="[A-Za-z\d]{1,100}">
        <?php if(isset($_SESSION['2ndPassErr'])):?>
            <p class="error"><?php echo $_SESSION['2ndPassErr'];?></p>
            <?php unset($_SESSION['2ndPassErr']);?>
        <?php endif;?>

        <p class="input-name">Firstname</p>
        <input type="fname" name="fname" placeholder="Firstname" maxlength="50" size="50" pattern="[A-Za-z]{1,50}" value= <?php echo isset($_SESSION['fnameuse'])?$_SESSION['fnameuse']:'';?>>
        <?php if(isset($_SESSION['Firstname'])):?>
            <p class="error"><?php echo $_SESSION['Firstname'];?></p>
            <?php unset($_SESSION['Firstname']);?>
        <?php endif;?>
        <?php unset($_SESSION['fnameuse']);?>

        <p class="input-name">Lastname</p>
        <input type="lname" name="lname" placeholder="Lastname" maxlength="50" size="50"  pattern="[A-Za-z]{1,50}" value= <?php echo isset($_SESSION['lnameuse'])?$_SESSION['lnameuse']:'';?>>
        <?php if(isset($_SESSION['Lastname'])):?>
            <p class="error"><?php echo $_SESSION['Lastname'];?></p>
            <?php unset($_SESSION['Lastname']);?>
        <?php endif;?>
        <?php unset($_SESSION['lnameuse']);?>

        <p class="input-name">Tel</p>
        <input type="tel" name="tel" maxlength="10" size="10" placeholder="Tel" pattern="\d{10}" <input type="lname" name="lname" placeholder="Lastname" maxlength="50" size="50"  pattern="[A-Za-z]{1,50}" value= <?php echo isset($_SESSION['teluse'])?$_SESSION['teluse']:'';?>>
        <?php if(isset( $_SESSION['Telc'])):?>
            <p class="error"><?php echo  $_SESSION['Telc'];?></p>
            <?php unset( $_SESSION['Telc']);?>
        <?php endif;?>
        <?php unset($_SESSION['teluse']);?>

        <p class="input-name">Birthday</p>
        <input type="date" name="hbd"  min="1900-01-01" max='<?=date("Y-m-d")?>'>
        <?php if(isset($_SESSION['hbdnew'])):?>
            <p class="error"><?php echo $_SESSION['hbdnew'];?></p>
            <?php unset($_SESSION['hbdnew']);?>
        <?php endif;?>

        <div class="back">
            <a class="back-in" href="login.php">Back to login</a> 
        </div>
        <div class="input-group">
            <input name="check" type="submit" value ="submit" class="btn" name="oop">
        </div>
    </form>
</body>
</html>