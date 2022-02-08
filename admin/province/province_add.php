<?php
    require('../../server/connectdb.php'); //connect db
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin</title>
    <style>
        body{
            background:smoke;
        }
        form{
            padding:0 30px 30px 30px;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <h1 align="center">ADD PROVINCE</h1>
    <form action="./province_save.php" method="post">
        <div class="mb-3">
            <p class="head">PROVINCE NAME</p>
            <input type="text" class="form-control" name="name_province"  required>
        </div>
        <div class="mb-3">
            <p class="head">REGION</p>
            <select name="region" class ="form-control" required>
                <option hidden selected disabled>choose one..</option>
                <option value="Bangkok and surrounding areas">Bangkok and surrounding areas</option>
                <option value="Central">Central</option>
                <option value="Northeast">Northeast</option>
                <option value="Eastern">Eastern</option>
                <option value="Central">Central</option>
                <option value="South">South</option>
                <option value="North">North</option>
            </select>
        </div>
        <div class="text-center">
            <input class="btn btn-success" type="submit" value="SUBMIT">
            <a class="btn btn-danger" href="province.php" > CANCLE</a>
        </div>
    </form>
</body>
</html>