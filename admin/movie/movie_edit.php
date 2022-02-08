<?php
    include '../../server/connectdb.php';
    if(!isset($_GET["edit_id"])){
        header('location:movie_list.php');
    }
    $types = $pdo->prepare("SELECT * FROM movie_type");
    $types->execute();
    $edit = $pdo->prepare("SELECT * FROM movie WHERE id_movie = :id");
    $edit->bindParam(':id',$_GET["edit_id"]);
    $edit->execute();
    $edit = $edit->fetch(PDO::FETCH_ASSOC)
?>

<!DOCTYPE html>
<html>
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
        .header{
            margin: 30px 0 0;
            text-align: center;
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
        body{
            background:smoke;
        }
        form{
            padding:0 3rem 3rem;
        }
        .page{
            padding: 20px 8rem;
            background-color:#f1f1f1;

        }
        .content{
            padding: 2rem;
            background-color:white;
        }
        img{
            width:30%;
            height:30%;
            margin: 20px 0;
        }
        select{
            width: 80%;
            height: 5%;
            text-align: center;
        }
        h1{
            text-align: center;
        }
        textarea{
            height: 200px;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 class="header">Edit movie </h1>
        </div>
    <form class="card-container"action="movie_editing.php?id=<?=$_GET["edit_id"]?>" method="post" enctype="multipart/form-data" required>
        <div class="mb-3">
            <p class="head">English name</p>
            <input  class="form-control" type="text" name="name_movie_eng" pattern="[A-Za-z\s\d]{1,300}" value='<?=$edit["name_movie_eng"]?>' required>
        </div>
        <div  class="mb-3">
            <p class="head">Thai name</p>
            <input class="form-control" type="text" name="name_movie_th" pattern="[ก-๏\s\d]{1,300}" value='<?=$edit["name_movie_th"]?>' >
        </div>
        <div  class="mb-3">
            <p class="head">Detail</p>
            <textarea class="form-control" name="detail" required><?=$edit["detail"]?></textarea>
        </div>
        <p>Image</p>
        <div class="mb-3">
            <img src="../../img/movie_img/<?=$edit["movie_photo"]?>" alt="">
            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="mb-3 text-center">
            <p>Time</p>
            <div class="long">
                Hour : <input type="number" name="time_movie_hour" pattern="[\d]{1,2}" min="0" max="60" value=<?=$edit["time_movie_hour"]?>>
                Minute : <input type="number" name="time_movie_minute" pattern="[\d]{1,2}" min="0" max="59" value=<?=$edit["time_movie_minute"]?>>
                Second : <input type="number" name="time_movie_second" pattern="[\d]{1,2}" min="0" max="59" value=<?=$edit["time_movie_second"]?>>
            </div>
        </div>
        <br>
        <div class="mb-3 text-center">
            <p>Type</p>
            <select name="type_of_movie">
                <option value='<?=$edit["type"]?>' selected disabled hidden><?=$edit["type"]?></option>
                <?php while($row = $types->fetch()):?>
                    <option value=<?=$row['movie_type']?>><?=$row['movie_type']?></option>
                <?php endwhile;?>
            </select>
        </div>
        <br>
        <div class="text-center">
            <input class="btn btn-primary" type="submit" value="update" name="submit">
            <a class="btn btn-danger" href="movie_list.php" name="submit">cancle</a>
        </div>
    </form>
        
        </div>
</html>