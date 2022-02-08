<?php //http://localhost/SFphp/admin/province/province_edit.php
    require('../../server/connectdb.php'); //connect db
    if(!isset($_GET['id_province'])){
        $_SESSION["fail"] = "Editing Failed";
        header( "location: http://localhost/SFphp/admin/province/province.php" );
    }else{
        $id_province = $_GET['id_province'];
        $stmt = $pdo->prepare(" SELECT * FROM province WHERE id_province = '$id_province' ");
        $stmt->execute();
        $row = $stmt->fetch();
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
        .mb-3{
            text-align:center;
        }
        .mb-3 .head{
            text-align:left;
        }
        textarea{
            height:300px;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
    <div class="card-header"><h1 class="header">EDIT PROVINCE</h1></div>
    <form class="card-container"action="province_editing.php" method="post">
        <div class="mb-3">
            <p class="head">PROVINCE NAME</p>
            <input type="text" name="name_province" value="<?=$row['name_province']?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <p class="head">REGION</p>
            <select name="region" class ="form-control">
            <option value="<?=$row['region']?>" selected hidden><?=$row['region']?></option>
                <option value="Bangkok and surrounding areas">Bangkok and surrounding areas</option>
                <option value="Central">Central</option>
                <option value="Northeast">Northeast</option>
                <option value="Eastern">Eastern</option>
                <option value="South">South</option>
                <option value="North">North</option>
            </select>
        </div>
        <input type="hidden" name="id_province" value="<?=$_GET['id_province']?>" >
        <div class="text-center">
            <input class="btn btn-success" type="submit" value="SUBMIT">
            <a class="btn btn-danger" href="province.php" > CANCLE</a>
        </div>
    </form>
    </div>
</body>
</html>