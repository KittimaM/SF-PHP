<?php include '../../server/connectdb.php';
    if(isset($_GET['id'])){
        $showtime = $pdo->prepare("SELECT showtime.id_ShowTime,movie.name_movie_eng,cinema.name_cinema,showtime.date,showtime.Time_start,showtime.Time_end,showtime.soundtrack,showtime.subtitle FROM `showtime`,movie,cinema
        WHERE showtime.id_ShowTime LIKE :idc AND showtime.id_movie = movie.id_movie AND cinema.id_cinema = showtime.id_cinema  AND showtime.date >= :date");
        $id_b = $_GET['id'].'%';
        $date = date("Y-m-d");
        $date = strtotime($date);
        $date = strtotime("+1 day", $date);
        $date = date('Y-m-d', $date);
        $showtime->bindParam(':date',$date);
        $showtime->bindParam(':idc',$id_b);
        $showtime->execute();
        // print_r($showtime->fetchall());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .alert{
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h2>Showtime detail</h2>
        </div>
        <div class="card-container">
            <?php if(isset($_SESSION["fail"])):?>
            <div class="alert alert-danger" role="alert">
                <?=$_SESSION["fail"]?>
            </div>
            <?php 
                unset($_SESSION["fail"]);
                endif;
            ?>

            <?php if(isset($_SESSION["success"])):?>
            <div class="alert alert-success" role="alert">
                <?=$_SESSION["success"]?>
            </div>
            <?php 
                unset($_SESSION["success"]);
                endif;
            ?>
            <br>
            <div class="heada d-flex">
            
                
            </div>
            <?php if(isset($_GET['id'])):?>
                <div class="tb">
                    <table class = "table table-striped table-hover">
                        <thead class = "table-dark">
                            <th>Showtime ID</th>
                            <th>Movie name(ENG)</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Sound/Subtitle</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                        <?php while($row = $showtime->fetch()): ?>
                            <tr>
                                <td align = 'center'><?=$row["id_ShowTime"] ?></td>
                                <td align = 'center'><?=$row["name_movie_eng"] ?></td>
                                <td align = 'center'><?=$row["date"] ?></td>
                                <td align = 'center'><?=$row["Time_start"] ?> - <?=$row["Time_end"] ?></td>
                                <td align = 'center'><?=$row["soundtrack"] ?>/<?=$row["subtitle"] ?></td>
                                <td align = 'center'><a href="del.php?del=<?=$row["id_ShowTime"] ?>" class="btn btn-danger">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
        </div>
    </div>
</body>
</html>