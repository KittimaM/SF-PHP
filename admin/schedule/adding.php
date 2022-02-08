<?php
    session_start();
    include '../../server/connectdb.php';
    $time_diffult = array (
        array('01','10:30:00','13:30:00'),
        array('02','14:00:00','17:00:00'),
        array('03','17:30:00','20:30:00'),
    );
    
    //id show_time แก้ด้วย
    if(isset($_POST['check'])){
        //fix
        //print_r($_POST);
        //echo '<br>';
        $date = strtotime($_POST['startdate']);

        $ddd = $pdo->prepare('SELECT id_chair FROM `chair` WHERE chair.id_cinema = :id');
        $ddd->bindParam(':id',$_POST['cinema']);
        $ddd->execute();
        $ddd = $ddd->fetchall();

        $id_show = $_POST['movie'].$_POST['cinema'];
        $like = $id_show.'%';
        $day = $_POST['month']*30;
        $duplicate = $pdo->prepare('SELECT COUNT(*) FROM showtime WHERE id_ShowTime LIKE :like');
        $duplicate->bindParam(':like',$like);
        $duplicate->execute();
        $duplicate = $duplicate->fetch()[0];
        if($duplicate == 0){
            for($i = 0;$i < $day;$i++){
                $date = strtotime("+1 day", $date);
                foreach($time_diffult as $row){
                    //fix
                   $id_show_time = $id_show.date('Ymd', $date).$row[0];
                    $date_in = date('Y-m-d', $date);
                  /*  echo $id_show_time." ".$_POST['movie']." ".$_POST['cinema']." ";
                    echo $date_in." ".$row[1]." ".$row[2]." ".$_POST['sound']." ".$_POST['subtitle'];
                    echo '<br>';*/
                    $save = $pdo->prepare("INSERT INTO showtime VALUES ( :id_show_time,  :id_movie,  :id_cinema,  :date,  :time_start,  :time_end,  :soundtrack,  :subtitle)");
                    $save->bindParam(':id_show_time',$id_show_time);
                    $save->bindParam(':id_movie',$_POST['movie']);
                    $save->bindParam(':id_cinema',$_POST['cinema']);
                    $save->bindParam(':date',$date_in);
                    $save->bindParam(':time_start',$row[1]);
                    $save->bindParam(':time_end',$row[2]);
                    $save->bindParam(':soundtrack',$_POST['sound']);
                    $save->bindParam(':subtitle',$_POST['subtitle']);
                    $save->execute();
                    foreach($ddd as $seat){
                        $sic = $id_show_time.$seat['id_chair'];
                        $save = $pdo->prepare('INSERT INTO seat_in_cinema VALUES (:sic_id,:show_id,:chair_id,:status)');
                        $save->bindParam(':sic_id',$sic);
                        $save->bindParam(':show_id',$id_show_time);
                        $dd = 0;
                        $save->bindParam(':chair_id',$seat['id_chair']);
                        $save->bindParam(':status',$dd);
                        $save->execute();
                    }
                }
            }
            header('location:main.php');
        }else{
            $_SESSION['error'] = 'This movie has already in this cinema number.';
            header('location:add.php');
        }
    }else{
        header('location:main.php');
    }
  
?>
