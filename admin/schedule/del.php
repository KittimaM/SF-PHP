<?php include '../../server/connectdb.php';
    session_start();
    if(isset($_GET['del'])){
        try{
            $check = $pdo->prepare("SELECT * FROM showtime , booked  WHERE showtime.id_ShowTime = :id_ShowTime AND showtime.id_ShowTime = booked.id_ShowTime ");
            $check->bindParam(':id_ShowTime',$_GET['del']);
            $check->execute();
            
            if($check->fetch() != NULL){
                $_SESSION['fail'] = 'this ciname already have seat booked';
            }else{
                $delete_sht = $pdo->prepare('DELETE FROM showtime WHERE id_ShowTime = :id_Showtime');
                $delete_sci = $pdo->prepare('DELETE FROM seat_in_cinema WHERE showtime_id = :id_Showtime');
                $delete_sht->bindParam(':id_Showtime',$_GET['del']);
                $delete_sci->bindParam(':id_Showtime',$_GET['del']);
                $delete_sht->execute();
                $delete_sci->execute();
                $_SESSION['success'] = "Delete Success";
            }

        } catch (Exception $e) {
            $_SESSION['fail'] = 'Error';
        }

        header("Location: detail.php?id=".substr($_GET['del'],0,20) );
    }else{
        header("Location: main.php" );
    }

?>