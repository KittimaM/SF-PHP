<?php //http://localhost/SFphp/admin/branch/branch.php
    require('../../server/connectdb.php'); //connect db
  
    if(!isset($_GET['id_branch'])){
        $_SESSION["fail"] = "Editing Failed";
        header( "location: branch.php" );
    }else{
        $id_branch = $_GET['id_branch'];
        $stmt = $pdo->prepare("SELECT * FROM branch , province , branch_type WHERE branch.id_province = province.id_province AND branch.branch_type = branch_type.id AND branch.id_branch = '$id_branch' " );
        $stmt->execute();
        $row = $stmt->fetch();
       
        $name_type =  $row['name'];
        $id_type = $row['id'];

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
        textarea{
            height:300px;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
    <div class="card-header">
    <h1 class="header">EDIT BRANCH</h1></div>
    <div class="card-container">
    <form action="branch_editing.php" method="post">
        <div class="mb-3">
            <p class="head">BRANCH NAME</p>
            <input type="text" name="name_branch" value="<?=$row['name_branch']?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <p class="head">PROVINCE</p>
            <select name="id_province" class = "form-control">
            <option value="<?=$row['id_province']?>" selected hidden><?=$row['name_province']?></option>
                <?php
                    $province = $pdo->prepare("SELECT * FROM province");
                    $province->execute();
                    while($row = $province->fetch()):
                ?>
                
                <option value='<?=$row['id_province'] ?>'><?php echo $row['name_province']?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <p class="head">TYPE</p>
            <select name="id" class = "form-control">
            <option value="<?=$id_type?>" selected hidden><?=$name_type?></option>
                <?php
                    $type = $pdo->prepare("SELECT * FROM branch_type");
                    $type->execute();
                    while($row = $type->fetch()):
                ?>
                <option value='<?=$row['id'] ?>'><?php echo $row['name']?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <input type="hidden" name="id_branch" value="<?=$_GET['id_branch']?>" >
        <div class="text-center">
            <input class="btn btn-success" type="submit" value="SUBMIT">
            <a class="btn btn-danger" href="branch.php" > CANCLE</a>
        </div>
        
    </form>
    </div>
    </div>
</body>
</html>