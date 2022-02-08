<?php
    session_start();
    include "../../server/connectdb.php";
    $seat_row = 1;
    for($i = 0;$i < $_POST['ntype'];$i++){
        $max_id = 'fffffffffffff';
        $order = 'order'.$i;
        $order = $_POST[$order];
        $id_type = 'id_type'.$i;
        $id_type = $_POST[$id_type];
        for($j=1;$j <= $order;$j++){
            $chir = $pdo->prepare('SELECT name FROM chair_row_name WHERE id = :ids');
            $chir->bindParam(':ids',$seat_row);
            $chir->execute();
            $seat_row++;
            $chir = $chir->fetch()['name'];
            for($k=1;$k <= $_POST['column'];$k++){
                $lastID = $pdo->prepare('SELECT id_chair FROM chair ORDER BY id_chair DESC LIMIT 1');
                $lastID->execute();
                $lastID = $lastID->fetch();
                $lastID = (empty($lastID))?0:hexdec($lastID[0]);
                $lastID = dechex((int)($lastID + 1));
                $lastID = sprintf('%013s',$lastID);
                $chir_in = $chir.$k;
                if($lastID != $max_id){
                    $add_seat = $pdo->prepare('INSERT INTO chair VALUES (:id_chair,:id_cinema,:name,:id_type)');
                    $add_seat->bindParam(':id_chair',$lastID);
                    $add_seat->bindParam(':id_cinema',$_POST['cinima_id']);
                    $add_seat->bindParam(':name',$chir_in);
                    $add_seat->bindParam(':id_type',$id_type);
                    $add_seat->execute();
                }else{
                    echo '<h1>Full Seat in Database</h1>';
                }
            }
        }
        
    }
    $update_cinema = $pdo->prepare('UPDATE cinema SET chair = :chair WHERE id_cinema = :idc');
    $change = 1;
    $update_cinema->bindParam(':chair',$change);
    $update_cinema->bindParam(':idc',$_POST['cinima_id']);
    $update_cinema->execute();
    header('location:main.php');
?>