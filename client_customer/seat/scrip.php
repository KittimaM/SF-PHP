<?php 
  include '../../server/connectdb.php';
  session_start();
  $moviesht = $pdo->prepare("SELECT showtime.id_ShowTime,showtime.date,showtime.Time_start,showtime.soundtrack,showtime.subtitle,movie.name_movie_eng FROM `showtime`,movie WHERE id_ShowTime = :shw_id AND movie.id_movie = showtime.id_movie LIMIT 1");
  $moviesht->bindParam(":shw_id",$_POST['IDSHOW']);
  $moviesht->execute();
  $moviesht = ($moviesht->fetch());
  $priceAll = 0;
  $showtime = $pdo->prepare("SELECT cinema.name_cinema,branch_type.service,screen_type.price AS screenP,screen_type.name as screenN,branch_type.name AS branchT
  FROM cinema,screen_type,branch,branch_type
  WHERE cinema.id_cinema IN(SELECT showtime.id_cinema FROM `showtime` WHERE showtime.id_ShowTime = :idshotime)
  AND cinema.id_screen = screen_type.id_screen 
  AND cinema.id_branch = branch.id_branch
  AND branch.branch_type = branch_type.id");
  $showtime->bindParam(':idshotime',$_POST['IDSHOW']);
  $showtime->execute();
  $showtime = ($showtime->fetch());
?>

<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>SF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="scrip.css">

</head>

<body>
  <form action="selecting.php" method="post">
      <input type="text" name="IDSHOW" value="<?=$_POST['IDSHOW']?>" hidden>
      <div class="blog-card">
        <div class="description">
          <h1 class="head"><?=$moviesht['name_movie_eng']?></h1>
          <div class="container">
            <p>Booked By <?=$_SESSION['email']?></p>
            <p>Cinema&nbsp:&nbsp<?=$_POST['Cinema']?></p>
            <p>Date&nbsp:&nbsp<?=$moviesht['date']?></p>
            <p>Showtime&nbsp:&nbsp<?=$moviesht['Time_start']?></p>
          </div>
        </div>
      </div>
      <?php foreach($_POST as $key=>$value):?>
        <?php if($key != 'IDSHOW' AND $key != 'Cinema'):?>
          <?php 
            $seat_data = $pdo->prepare("SELECT seat_in_cinema.sic_id,type_chair.name,type_chair.price FROM `seat_in_cinema`,chair,type_chair 
            WHERE seat_in_cinema.sic_id = :sic_id AND chair.id_chair = seat_in_cinema.chair_id AND type_chair.id = chair.id_type");  
            $seat_data->bindParam(':sic_id',$value);
            $seat_data->execute();
            $seat_data = $seat_data->fetch();
            $priceAll += $seat_data['price'];
          ?>
            <div class="blog-card">
              <div class="description">
                <h1><b><?=$key?></b></h1>
                <hr>
                <div class="data">
                  <input type="text" name="<?=$key?>" value="<?=$seat_data['sic_id']?>" hidden>
                  <p >Type Seat&nbsp:&nbsp<?=$seat_data['name']?> </p>
                  <p>ID seat&nbsp:&nbsp<?=$seat_data['sic_id']?></p>
                  <hr>
                  <div class="price">
                    <p><b>Price&nbsp:&nbsp<?=number_format($seat_data['price'],2)?> THB</b></p>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
        <?php endif;?>
      <?php  endforeach;?>
      <div class="blog-card">
          <?php $sers = 0;?>
          <div class="description">
            <p class="ttt"><b>Service</b> &nbsp:&nbsp <?=$showtime['branchT']?></p>
            <div class="price"><p><b>Price&nbsp&nbsp:<?=number_format($showtime['service'],2)?> THB</b></p></div>
            <hr>
            <p class="ttt"><b>Screen</b> &nbsp:&nbsp <?=$showtime['screenN']?></p>
            <div class="price"><p><b>Price&nbsp:&nbsp<?=number_format($showtime['screenP'],2)?> THB</b></p></div>
            <?php $sers += $showtime['service'];$sers += $showtime['screenP'];$priceAll += $sers;?>
            <hr>

          </div>
        </div>
      
        
      <div class="blog-card">
        <div class="description row">
          <input type="submit" class="btn btn-danger col" name="submit" value="Submit">
          <input type="number" name="priceAll" value="<?=$priceAll?>" hidden>
          <h1 class="total col">Total&nbsp:&nbsp<?=number_format($priceAll,2)?> THB</h1>
        </div>
      </div>
  </form>

</body>

</html>