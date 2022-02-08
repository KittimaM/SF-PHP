<?php
    include '../../server/connectdb.php';
    $types = $pdo->prepare("SELECT * FROM movie_type");
    $types->execute();
    
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
            padding: 50px 300px;
            background-color:white;
        }
        select{
            width: 80%;
            height: 40px;
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
                <h1 align="center">Add movie</h1>
            </div>
        <form class="card-container" action="save_movie.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <p class="head">English name</p>
                <input placeholder="English only..." class="form-control" type="text" name="eng_name" pattern="[A-Za-z\s\d]{1,300}" required>
            </div>
            <div  class="mb-3">
                <p class="head">Thai name</p>
                <input placeholder="Thai only...." class="form-control" type="text" name="thai_name" pattern="[ก-๏\s\d]{1,300}" required>
            </div>
            <div  class="mb-3">
                <p class="head">Detail</p>
                <textarea placeholder="text..." class="form-control" name="detail"  pattern="[ก-๏\s\d]{1,300}" required></textarea>
            </div>
            <p>Upload Image</p>
            <div class="mb-3">
                <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required>
            </div>
            <div class="mb-3 text-center">
                <p class="head">Time</p>
                <div>
                    <?php if(isset($_SESSION["time_error"])):?>
                        <div class="alert alert-danger" role="alert">
                            <?=$_SESSION["time_error"]?>
                        <div>
                    <?php endif; ?>
                    <?php unset($_SESSION["time_error"]);?>
                </div>
                <div class="long">
                    Hour : <input type="number" name="time_movie_hour" pattern="[\d]{1,2}" min="0" max="3" value="0">
                    Minute : <input type="number" name="time_movie_minute" pattern="[\d]{1,2}" min="0" max="59" value="0">
                    Second : <input type="number" name="time_movie_second" pattern="[\d]{1,2}" min="0" max="59"  value="0">
                </div>
            </div>
            <br>
            <div class="mb-3 text-center">
                <p>Type</p>
                <select name="type_of_movie">
                    <option value="" selected disabled hidden>Choose here</option>
                    <?php while($row = $types->fetch()):?>
                        <option value=<?=$row['movie_type']?>><?=$row['movie_type']?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <br>
            <div class="text-center">
                <input class="btn btn-success" type="submit" value="submit" name="submit">
                <a class="btn btn-danger" href="movie_list.php" name="submit">cancle</a>
            </div>
        </form>
        </div>
</html>