<?php
    require('../../server/connectdb.php');
        if(!isset($_GET['id_ticket'])){
            $stmt = $pdo->prepare("SELECT * FROM (SELECT * FROM booked ) 
            AS booked , ticket,showtime,movie,cinema,seat_in_cinema,chair,branch
            WHERE ticket.id_booked = booked.id_booked
            AND booked.id_ShowTime = showtime.id_ShowTime 
            AND showtime.id_movie = movie.id_movie
            AND showtime.id_cinema = cinema.id_cinema
            AND ticket.id_chair = seat_in_cinema.sic_id
            AND chair.id_chair = seat_in_cinema.chair_id
            AND cinema.id_branch = branch.id_branch
            AND ticket.expired = '0' ");
            $stmt->execute();

        }
        else {
            $update = $pdo->prepare("UPDATE ticket SET expired = '1' WHERE id_ticket = :id_ticket  ");
            $update->bindParam(':id_ticket',$_GET['id_ticket']);
            $update->execute();

            $stmt = $pdo->prepare("SELECT * FROM (SELECT * FROM booked ) 
            AS booked , ticket,showtime,movie,cinema,seat_in_cinema,chair,branch
            WHERE ticket.id_booked = booked.id_booked
            AND booked.id_ShowTime = showtime.id_ShowTime 
            AND showtime.id_movie = movie.id_movie
            AND showtime.id_cinema = cinema.id_cinema
            AND ticket.id_chair = seat_in_cinema.sic_id
            AND chair.id_chair = seat_in_cinema.chair_id
            AND cinema.id_branch = branch.id_branch
            AND ticket.expired = '0' ");
            $stmt->execute();
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
            <h1>Ticket</h1>
        </div>

        <div class="card-container">
                <div class="tb">
                <table class = "table table-striped table-hover">
                    <thead class = "table-dark">
                        <th>id_ticket</th>
                        <th>movie</th>
                        <th>branch</th>
                        <th>cimena</th>
                        <th>date</th>
                        <th>time</th>
                        <th>seat</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php while($row = $stmt->fetch()): ?>
                        <tr>
                        <td align = 'center'><?=$row["id_ticket"] ?></td>
                        <td align = 'center'><?=$row["name_movie_eng"] ?></td>
                        <td align = 'center'><?=$row["name_branch"] ?></td>
                        <td align = 'center'><?=$row["name_cinema"] ?></td>
                        <td align = 'center'><?=$row["date"] ?></td>
                        <td align = 'center'><?=$row["Time_start"] ?></td>
                        <td align = 'center'><?=$row["name"] ?></td>
                        <td align = 'center'><a href="main.php?id_ticket=<?=$row["id_ticket"]?>" class="btn btn-warning"> expired</a></td>
                        
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                    
            </div>
        </div>
    </div>
</body>

</html>