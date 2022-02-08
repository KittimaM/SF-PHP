<?php 
    include '../../server/connectdb.php';
    session_start();
    if(TRUE){
        
        $showTimeID = "615c71cb9a71a00001012021102501";
        $Cinema_detail = $pdo->prepare("SELECT cinema.name_cinema,size_cinema.rows,size_cinema.columns,size_cinema.position FROM seat_in_cinema,chair,cinema,size_cinema WHERE seat_in_cinema.showtime_id = :ShowTimeid AND seat_in_cinema.chair_id = chair.id_chair AND chair.id_cinema = cinema.id_cinema AND cinema.id_size = size_cinema.id_size LIMIT 1");
        $Cinema_detail->bindParam(':ShowTimeid',$showTimeID);
        $Cinema_detail->execute();
        $Cinema_detail = $Cinema_detail->fetchall();

        $Type_chair = $pdo->prepare("SELECT type_chair.name,type_chair.price FROM seat_in_cinema,chair,type_chair WHERE seat_in_cinema.showtime_id = :ShowTimeid AND seat_in_cinema.chair_id = chair.id_chair AND chair.id_type = type_chair.id GROUP BY type_chair.id");
        $Type_chair->bindParam(':ShowTimeid',$showTimeID);
        $Type_chair->execute();
        $Type_chair = $Type_chair->fetchall();

        $Seat = $pdo->prepare("SELECT seat_in_cinema.sic_id,chair.name AS Anum,type_chair.name AS type_chair,seat_in_cinema.status FROM seat_in_cinema,chair,type_chair WHERE seat_in_cinema.showtime_id = :showTimeID AND seat_in_cinema.chair_id = chair.id_chair AND type_chair.id = chair.id_type");
        $Seat->bindParam(':showTimeID',$showTimeID);
        $Seat->execute();
        $col = $Cinema_detail[0]["columns"];
        $row = $Cinema_detail[0]["rows"];
        $Seat = $Seat->fetchall();
        $numSeat = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="select.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    </style>
</head>
<body>
    <div class="detail">
        <div class="theater">
            <p class="name">CINEMA</p>
            <p class="number"><?=$Cinema_detail[0]['name_cinema']?></p>
        </div>
        <div class="seat_type">
            <p>Seat Price</p>
            <?php $i = 0; foreach($Type_chair as $ddd):?>
                <p><?=$ddd['name']?> <?=$ddd['price']?> THB</p>
                <?php $i++;?> 
            <?php endforeach;?>
        </div>
    </div>
    <?php if(isset($_SESSION["error"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["error"]?>
        </div>
        <hr>
    <?php endif;?>
    <?php unset($_SESSION["error"])?>

    <form class="seat" action="scrip.php" method="post">
        <input type="text" name="IDSHOW" value="<?=$showTimeID?>" hidden>
        <input type="text" name="Cinema" value="<?=$Cinema_detail[0]['name_cinema']?>" hidden>
        <div class="screen-wrapper">
            <div class="screen-image">
                <img src="img/screen.png" width="100%" >
            </div>
        </div>
        <br>
        <table class="table-seatmap">
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <?php for($j = 1;$j <= $col;$j++):?>
                        <td class="col NUM"><?=$j?></td>
                    <?php endfor;?>
                    <td></td>
                    <td></td>
                </tr>
                    <?php for($i = 1;$i <= $row;$i++):?>
                <tr>
                    <td>
                        <?=$Seat[$numSeat]['type_chair']?>
                    </td>
                    <td>
                        <?=$Seat[$numSeat]['Anum'][0]?>
                    </td>
                    <?php for($j = 1;$j <= $col;$j++):?>
                        <?php if($Seat[$numSeat]['status'] == 0):?>
                            <td class="super_seat">
                                <div class="checkbox_wrapper">
                                    <input id="active" class="active" name="<?=$Seat[$numSeat]['Anum']?>" type="checkbox" value="<?=$Seat[$numSeat]['sic_id']?>" />
                                    <label></label>
                                </div>
                            </td>
                        <?php else:?>
                            <td class="super_seat">
                                <div class="checkbox_wrapper">
                                    <input class="disable" type="checkbox" value="<?=$Seat[$numSeat]['sic_id']?>" disabled />
                                    <label></label>
                                </div>
                            </td>
                        <?php endif;?>
                    <?php $numSeat++;?>
                    <?php endfor;?>
                    <?php $numSeat--;?>
                    <td>
                        <?=$Seat[$numSeat]['Anum'][0]?>
                    </td>
                    <td>
                        <?=$Seat[$numSeat]['type_chair']?>
                    </td>
                    <?php $numSeat++;?>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <div class="ok"> 
            <button class="btn btn-danger">SUBMIT</button>
        </div>
    </form>
    
</body>

</html>