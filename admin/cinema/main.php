
<?php //http://localhost/project_sffake/page1.php
    require('../../server/connectdb.php'); //connect db
    if(!isset($_POST['name_branch'])){
        $stmt = $pdo->prepare("SELECT cinema.id_cinema,cinema.name_cinema,branch.name_branch,screen_type.name,size_cinema.name 
        FROM cinema,screen_type,branch,size_cinema 
        WHERE cinema.id_branch = branch.id_branch 
        AND cinema.id_screen = screen_type.id_screen
        AND cinema.id_size = size_cinema.id_size");
        $stmt->execute();

    }else if(isset($_POST['name_branch'])){

        $stmt = $pdo->prepare("SELECT cinema.id_cinema,cinema.name_cinema,branch.name_branch,screen_type.name,size_cinema.name 
        FROM cinema,screen_type,branch,size_cinema 
        WHERE cinema.id_branch = branch.id_branch 
        AND cinema.id_screen = screen_type.id_screen
        AND cinema.id_size = size_cinema.id_size
        AND name_branch LIKE :keyword ");
        $value = '%'.$_POST['name_branch'].'%';
        $stmt->bindParam(':keyword',$value);
        $stmt->execute();
        unset($_POST['name_branch']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
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
        .num{
            text-align: center;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 class = "header">CINEMA</h1>
        </div>
        <div class="card-container">
        <div class="heada d-flex">
            <div class="col-8">
                <a href="add.php" class="btn btn-success">+Add</a>
                <a class="btn btn-primary" href="main.php">SHOW ALL</a>
            </div>
    
            <form class ="d-flex col-2" method="post">
                <input type="search" name="name_branch" placeholder="BRANCH NAME(ENG)" required>
                <input type="submit" value="search">
            </form>
        </div>
        <div class="tb">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <th >Cinema ID</th>
                    <th>Cinema Number</th>
                    <th >Screen Type</th>
                    <th >Size</th>
                    <th >Branch</th>
                </thead>
                <tbody>
                <?php while($row = $stmt->fetch()):?>
                    <tr>
                        <td ><?=$row["id_cinema"] ?></td>
                        <td align = 'center'><?=$row["name_cinema"] ?></td>
                        <td align = 'center'><?=$row["3"] ?></td>
                        <td align = 'center'><?=$row["4"] ?></td>
                        <td align = 'center'><?=$row["name_branch"] ?></td>
                    </tr>
                <?php endwhile;?>
                </tbody>
            
            </table>
        </div>
        </div>
    </div>
    <!-- show all movie ------------------------------------------------------->
</body>
</html>
</body>
</html>