<?php //http://localhost/project_sffake/page1.php
    require('../../server/connectdb.php'); //connect db
    if(!isset($_POST['name_movie'])){
        $stmt = $pdo->prepare("SELECT * FROM movie");
        $count = $pdo->prepare("SELECT COUNT(*) FROM movie");
        $stmt->execute();
        $count->execute();
    }else{
        $stmt = $pdo->prepare("SELECT * FROM movie WHERE name_movie_eng LIKE :keyword");
        $count = $pdo->prepare("SELECT COUNT(*) FROM movie  WHERE name_movie_eng LIKE :keyword");
        $value = '%'.$_POST['name_movie'].'%';
        $stmt->bindParam(':keyword',$value);
        $count->bindParam(':keyword',$value);
        $stmt->execute();
        $count->execute();
        unset($_POST['name_movie']);
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
        img{
            width:9rem;
            height:9rem;
            object-fit: fill;
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
            <h1 class = "header">MOVIE</h1>
        </div>
    <?php if(isset($_SESSION["msg_movie_add"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["msg_movie_add"]?>
        </div>
        <hr>
    <?php endif;?>
    <?php unset($_SESSION["msg_movie_add"])?>
    <?php if(isset($_SESSION["msg_movie_edit"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["msg_movie_edit"]?>
        </div>
        <hr>
    <?php endif;?>
    <?php unset($_SESSION["msg_movie_edit"])?>
    <?php if(isset($_SESSION["msg_movie_del"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["msg_movie_del"]?>
        </div>
        <hr>
    <?php endif;?>
    <?php unset($_SESSION["msg_movie_del"])?>
    <div class="card-container">
    <div class="heada d-flex">
        <div class="col-8">
            <a href="movie_add.php" class="btn btn-success">+Add</a>
            <a class="btn btn-primary" href="main.php">SHOW ALL</a>
        </div>
   
        <form class ="d-flex col-2" method="post">
            <input type="search" name="name_movie" placeholder="MOVIE NAME(ENG)">
            <input type="submit" value="search">
        </form>
    </div>
    <p class="num col-12">have <?=$count->fetch()[0]?> record</p>
    <div class="tb">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <th >Movie ID</th>
                <th>Name(ENG)</th>
                <th >Name(TH)</th>
                <th >Time</th>
                <th>Type</th>
                <th>Image</th>
                <th>Detail</th>
                <th >Delete</th>
                <th>Edit</th>
            </thead>
            <tbody>
            <?php while($row = $stmt->fetch()):?>
            <tr>
                <td ><?=$row["id_movie"] ?></td>
                <td align = 'center'><?=$row["name_movie_eng"] ?></td>
                <td align = 'center'><?=$row["name_movie_th"] ?></td>
                <?php
                    $hour = $row["time_movie_hour"];
                    if(strlen($row["time_movie_minute"]) == 1){
                        $minute = '0'.$row["time_movie_minute"];
                    }else{
                        $minute = $row["time_movie_minute"];
                    }
                    if(strlen($row["time_movie_second"]) == 1){
                        $second = '0'.$row["time_movie_second"];
                    }else{
                        $second = $row["time_movie_second"];
                    }
                    $time =  $hour.":".$minute.":".$second;
                ?>
                <?php if($row["time_movie_hour"] == 0 AND  $row["time_movie_minute"] == 0  AND $row["time_movie_second"]==0):?>
                    <td align = 'center'>NULL</td>
                <?php else:?>
                    <td align = 'center'><?=$time?></td>
                <?php endif;?>
                <td align = 'center'><?=$row["type"] ?></td>
                <td><img src="/SFphp/img/movie_img/<?=$row["movie_photo"]?>" class="img-fluid"></td>
                <td align = 'center'><?=$row["detail"] ?></td>
                <td align = 'center'><a href="movie_del.php?del_id=<?=$row["id_movie"]?>&img=<?=$row["movie_photo"]?>" class="btn btn-danger">delete</a></td>
                <td align = 'center'><a href="movie_edit.php?edit_id=<?=$row["id_movie"]?>" class="btn btn-warning">edit</a></td>
            </tr>
            <?php endwhile;?>
            </tbody>
        
        </table>
    </div>
    </div>
    <!-- show all movie ------------------------------------------------------->
</body>
</html>
</body>
</html>