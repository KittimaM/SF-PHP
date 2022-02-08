<?php include '../../server/connectdb.php';

    if(isset($_POST['branch'])){
        $showtime = $pdo->prepare("SELECT showtime.id_ShowTime,movie.name_movie_eng,cinema.name_cinema,MAX(showtime.date) 
        AS dateMAX,MIN(showtime.date) AS dateMIN ,showtime.soundtrack,showtime.subtitle FROM `showtime`,movie,cinema
        WHERE showtime.id_cinema LIKE :idc AND showtime.id_movie = movie.id_movie AND cinema.id_cinema = showtime.id_cinema 
        GROUP BY showtime.id_cinema , movie.id_movie ");
        $id_b = $_POST['branch'].'%';
        $showtime->bindParam(':idc',$id_b);
        $showtime->execute();

      
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
    </style>
</head>
<body>
    <?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1>Showtime</h1>
        </div>
        <div class="card-container">
            <?php if(isset($_SESSION["fail"])):?>
            <hr>
            <div class="alert alert-danger" role="alert">
                <?=$_SESSION["fail"]?>
            </div>
            <?php 
                unset($_SESSION["fail"]);
                endif;
            ?>
            <br>
            <div class="heada d-flex">
                <?php if(isset($_POST['branch'])):?>
                    <div class="col-8">
                        <a href="add.php" class="btn btn-success">+Add</a>

                    </div>
                <?php endif;?>
                <?php  
                    $branch = $pdo->prepare('SELECT * FROM branch');
                    $branch->execute();
                ?>
                <form class ="d-flex select" method="post">
                    <select class="question1" name="branch" required>
                        <option value="" selected hidden><?=(isset($_GET['branch']))?substr($_GET['branch'],5):"Branch Select"?></option>
                        <?php while($row = $branch->fetch()):?>
                            <option value="<?=$row['id_branch']?>"><?=$row['name_branch']?></option>
                        <?php endwhile;?>
                    </select>
                    <input type="submit" value="search">
                </form>
                
            </div>
            <?php if(isset($_POST['branch'])):?>
                <div class="tb">
                    <table class = "table table-striped table-hover">
                        <thead class = "table-dark">
                            <th>Showtime ID</th>
                            <th>Movie name(ENG)</th>
                            <th>Date</th>
                            <th>Sound/Subtitle</th>
                        </thead>
                        <tbody>
                        <?php while($row = $showtime->fetch()): ?>
                            <tr>
                                <td align = 'center'><a href="detail.php?id=<?=substr($row["id_ShowTime"],0,20)?>"><?=substr($row["id_ShowTime"],0,20) ?></a></td>
                                <td align = 'center'><?=$row["name_movie_eng"] ?></td>
                                <td align = 'center'><?=$row["dateMIN"] ?> to <?=$row["dateMAX"] ?></td>
                                <td align = 'center'><?=$row["soundtrack"] ?>/<?=$row["subtitle"] ?></td>
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