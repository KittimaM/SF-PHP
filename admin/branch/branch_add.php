<?php //http://localhost/SFphp/admin/branch/branch_add.php
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
        body{
            background:smoke;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 align="center">ADD BRANCH</h1>
        </div>
        <div class="card-container">
    <form action="branch_save.php" method="post">
        <div class="mb-3">
            <p class="head">BRANCH NAME</p>
            <input type="text" class="form-control" name="name_branch"  required>
        </div>
        <div class="mb-3">
            <p class="head">PROVINCE</p>
            <select name="id_province" class = "form-control">
            <option value="" selected hidden>Select</option>
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM province");
                    $stmt->execute();
                    while($row = $stmt->fetch()):
                ?>
                <option value='<?=$row['id_province'] ?>'><?php echo $row['name_province']?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <p class="head">TYPE</p>
            <select name="id" class = "form-control">
            <option value="" selected hidden>Select</option>
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM branch_type");
                    $stmt->execute();
                    while($row = $stmt->fetch()):
                ?>
                <option value='<?=$row['id'] ?>'><?php echo $row['name']?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="text-center">
            <input class="btn btn-success" type="submit" value="SUBMIT">
            <a class="btn btn-danger" href="branch.php" > CANCLE</a>
        </div>
    </form>
    </div>
    </div>
</body>
</html>