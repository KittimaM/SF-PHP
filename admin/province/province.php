<?php //http://localhost/SFphp/admin/province/province.php
    require('../../server/connectdb.php'); //connect db

    if(!isset($_POST['name_province'])){
        $stmt = $pdo->prepare("SELECT * FROM province");
        $count = $pdo->prepare("SELECT COUNT(*) FROM province");
        $stmt->execute();
        $count->execute();
    }else{
        $stmt = $pdo->prepare("SELECT * FROM province WHERE name_province LIKE :keyword ");
        $count = $pdo->prepare("SELECT COUNT(*) FROM province  WHERE name_province LIKE :keyword ");
        $value = '%'.$_POST['name_province'].'%';
        $stmt->bindParam(':keyword',$value);
        $count->bindParam(':keyword',$value);
        $stmt->execute();
        $count->execute();
        unset($_POST['name_province']);
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
        .btn{
            margin: 10px;
        }
        .num{
            justify-content: center; 
        }
        .alert{
            margin: 20px 0 0 0;
            text-align: center;
        }
        td{
            width: 200rem;
        }
    </style>
    <!--end style --------------------------------------------------------------->

</head>
<body>
<?php include "../nav.php"?> 
    <div class="card">
        <div class="card-header">
        <h1 class = "header">PROVINCE</h1>
        </div>
        <?php if(isset($_SESSION["success"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["success"]?>
        </div>
        
    <?php 
        unset($_SESSION["success"]);
        elseif(isset($_SESSION["fail"])): 
    ?>
        <hr>
        <div class="alert alert-danger" role="alert">
            <?=$_SESSION["fail"]?>
        </div>
    <?php 
        unset($_SESSION["fail"]); 
        elseif(isset($_SESSION["error"])):
    ?>
        <hr>
        <div class="alert alert-warning" role="alert">
            <?=$_SESSION["error"]?>
        </div>
    <?php
        unset($_SESSION['error']);
        endif;
    ?>
    <div class="card-container">
    <div class="heada d-flex">
        <div class="col-8">
            <a href="province_add.php" class="btn btn-success">+Add</a>
            <a class="btn btn-primary" href="province.php">SHOW ALL</a>
        </div>
   
        <form class ="d-flex col-2" method="post">
            <input type="search" name="name_province" placeholder="province name (ENG)" required>
            <input type="submit" value="search">
        </form>
    </div>

    <div class="tb">
        <table class = "table table-striped table-hover">
            <thead class = "table-dark">
                <th>iD PROVINCE</th>
                <th>NAME PROVINCE</th>
                <th>REGION</th>
                <th>EDIT</th>
                <th></th>
            </thead>
            <tbody>
            <?php while($row = $stmt->fetch()): ?>
                <tr>
                <td align = 'center'><?=$row["id_province"] ?></td>
                <td align = 'center'><?=$row["name_province"] ?></td>
                <td align = 'center'><?=$row["region"] ?></td>
                <td align = 'center'><a href="province_del.php?id_province=<?=$row["id_province"]?>" class="btn btn-danger">DELETE</a></td>
                <td align = 'center'><a href="province_edit.php?id_province=<?=$row["id_province"]?>" class="btn btn-warning">EDIT</a></td>
                
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div></div></div>
</body>
</html>