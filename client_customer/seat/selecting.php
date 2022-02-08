<?php
    session_start();
    
    include '../../server/connectdb.php';
    print_r($_POST);
    echo '<br>';
    if(isset($_POST['submit'])){
        $lastID = $pdo->prepare('SELECT id_booked FROM booked ORDER BY id_booked DESC LIMIT 1');
        $lastID->execute();
        $lastID = $lastID->fetch();
        if(empty($lastID)){
            $lastID = "0";
        }else if($lastID == 'ffffffffffffffffffffffffffff'){
            $_SESSION["error"] = "ERROR";
            header( "location:branch.php" );
        }else{
            $lastID = $lastID[0];
        }
        $lastID = hexdec($lastID);
        $lastID = dechex((int)( $lastID + 1));
        $lastID = sprintf('%030s',$lastID);

        $check = true; 
        $check_status = $pdo->prepare("SELECT seat_in_cinema.status FROM seat_in_cinema WHERE seat_in_cinema.sic_id = :id_C");
        foreach($_POST as $key=>$value){
            if($key != 'IDSHOW' AND $key != 'priceAll' AND $key != 'submit'){
                $check_status->bindParam(':id_C',$value);
                $check_status->execute();
                $check = $check && ($check_status->fetch()[0]==1)?false:true;
            }
        }
        echo  $check;
        if($check){
            foreach($_POST as $key=>$value){
                date_default_timezone_set("Asia/Bangkok");
                $now_date = date('Y-m-d');
                $now_time = date("G:i:s");
                if($key != 'IDSHOW' AND $key != 'priceAll' AND $key != 'submit'){
                    $update_status = $pdo->prepare("UPDATE seat_in_cinema SET status = 1 WHERE seat_in_cinema.sic_id = :sic_id");
                    $update_status->bindParam(':sic_id',$value);
                    $update_status->execute();
                    echo 'update = '.$value;
                    echo '<br>';
                }
            }
            $booked = $pdo->prepare("INSERT INTO `booked` VALUES (:id_booked,:id_ShowTime,:id_user,:date_booked,:time_booked)");
            $booked->bindParam(':id_booked',$lastID);
            $booked->bindParam(':id_ShowTime',$_POST['IDSHOW']);
            $booked->bindParam(':id_user',$_SESSION['email']);
            $booked->bindParam(':date_booked',$now_date);
            $booked->bindParam(':time_booked',$now_time);
            $booked->execute();
            $ddd = array($lastID,$_POST['IDSHOW'],$_SESSION['email'],$now_date,$now_time);
            foreach($_POST as $key=>$value){
                if($key != 'IDSHOW' AND $key != 'priceAll' AND $key != 'submit'){
                    $IDTicket = $pdo->prepare('SELECT id_ticket FROM ticket ORDER BY id_ticket DESC LIMIT 1');
                    $IDTicket->execute();
                    $IDTicket = $IDTicket->fetch();
                    if(empty($IDTicket)){
                        $IDTicket = "0";
                    }else if($IDTicket == 'ffffffffffffffffffffffffffffffffffffffffffff'){
                        $_SESSION["error"] = "ERROR";
                        header( "location:branch.php" );
                    }else{
                        $IDTicket = $IDTicket[0];
                    }
                    $IDTicket = hexdec($IDTicket);
                    $IDTicket = dechex((int)($IDTicket + 1));
                    $IDTicket = sprintf('%030s',$IDTicket);
   
                    $ticket = $pdo->prepare("INSERT INTO `ticket` VALUES (:id_ticket,:id_chair,:id_booked)");
                    $ticket->bindParam(':id_ticket',$IDTicket);
                    $ticket->bindParam(':id_chair',$value);
                    $ticket->bindParam(':id_booked',$lastID);
                    $ticket->execute();
                }
            }
            $_SESSION["success"] = "Your booked has been success";
            header('location:../profile/user_ticket.php?');
        }else{
            $_SESSION["error"] = "Your seat has been reserved.";
            header('location:select.php?showTimeID='.$_POST['IDSHOW']);
        }
    }
?>