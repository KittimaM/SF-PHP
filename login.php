<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <form action="./server/login_db.php" method="post">
        <img src="./img/SF_Cinema_logo.jpg" width="35%">
        <script src="https://kit.fontawesome.com/f5910a4aaa.js" crossorigin="anonymous"></script>
        <p class="input-name">Email</p>
        <input type="email" name="email"  pattern="{1,100}" placeholder="&#xf0e0; Email" style="font-family:Arial, FontAwesome" required>
        <p class="input-name">Password</p>
        <input type="password" name="password" pattern="{1,100}"placeholder="&#xf023; Password" style="font-family:Arial, FontAwesome" required>
        <div class="forget">
            <a href="register.php">Register</a>
        </div> 
        <div class="input-group">
            <input type="submit" name ="login_user" value ="Sign in" class="btn">
        </div>
    </form>
</body>
</html>