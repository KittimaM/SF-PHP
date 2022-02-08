<?php
    include '../../server/connectdb.php';
    $br = $pdo->prepare('SELECT * FROM branch');
    $br->execute();
    $count = 0;
    if(isset($_GET['branch'])){
        $id_b = substr($_GET['branch'],0,5);
        $name_b = substr($_GET['branch'],5);
        $cinema = $pdo->prepare('SELECT id_cinema,name_cinema,chair FROM cinema WHERE id_branch = :branch');
        $count = $pdo->prepare('SELECT COUNT(id_cinema) FROM cinema WHERE id_branch = :branch');
        $cinema->bindParam(':branch',$id_b);
        $count->bindParam(':branch',$id_b);
        $count->execute();
        $count = $count->fetch()[0];
        $cinema->execute();
    }
    if(isset($_GET['number'])){
        $id_cinema = substr($_GET['number'],0,5);
        $name_cinema = substr($_GET['number'],5);
        $seat_t = $pdo->prepare('SELECT id,name FROM type_chair');
        $seat_t->execute();
    }
    if(isset($_GET['branch']) AND isset($_GET['number'])){
        $chair_size = $pdo->prepare('SELECT size_cinema.position,size_cinema.name,size_cinema.columns FROM size_cinema WHERE size_cinema.id_size IN(SELECT cinema.id_size FROM cinema WHERE cinema.id_cinema = :id_cinema)');
        $chair_priority = $pdo->prepare('SELECT branch_type.priority FROM branch_type WHERE branch_type.id IN(SELECT branch.branch_type FROM branch WHERE branch.id_branch = :id_b)');
        $chair = $pdo->prepare('SELECT * FROM type_chair WHERE type_chair.quality >= :piority'); 
        $chair_priority->bindParam(':id_b',$id_b);
        $chair_size->bindParam( ':id_cinema',$_GET['number']);
        $chair_size->execute();
        $chair_priority->execute();
        $chair_size = $chair_size->fetch();
        $column = $chair_size['columns'];
        $size = $chair_size['name'];
        $chair_size = explode('-',$chair_size['position']);
        $chair_priority = $chair_priority->fetch()['priority'];
        $chair->bindParam(':piority',$chair_priority);
        $chair->execute();
        $chair = $chair->fetchAll();
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
        .q1{
            margin : 20px auto;
        }
        .q2{
            text-align: center;
            margin : 20px auto 30px;
        }
        .q2 p{
            margin : 30px auto;
        }
        .q2 select{
            width: 40%;
            text-align: center;
        }
        .button{
            margin : 20px auto;
            text-align: center;
        }
        .button input{
            width: 40%;
        }
        .tten{
            text-align: center;
            margin : 20px auto;
        }
    </style>
</head>
<body>
    <?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 class="header">Add Seat</h1>
        </div>
        <div class="card-container">
            <div class='q1'>
                <hr>
                <label class="col-3 name-input">Branch :</label>

                <select class="branch" name="branch" required>
                    <option value="<?=(isset($_GET['branch']))?$_GET['branch']:'';?>" selected hidden><?=(isset($name_b))?$name_b:'Select';?></option>
                    <?php while($row = $br->fetch()):?>
                        <option value="<?=$row['id_branch']?><?=$row['name_branch']?>"><?=$row['name_branch']?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <?php if(isset($_GET['branch']) AND $count != 0):?>

                <div class='q1'>
                    <label class="col-3 name-input">Cinema number :</label>
                    <select class="number" name="number" required>
                        <option value="<?=(isset($id_cinema ))?$id_cinema :'';?>" selected hidden><?=(isset($name_cinema))?$name_cinema:'Select';?></option>
                        <?php while($row = $cinema->fetch()):?>
                            <?php if($row['chair'] == 0):?>
                                <option value="<?=$row['id_cinema']?>"><?=$row['name_cinema']?></option>
                            <?php endif;?>
                        <?php endwhile;?>
                    </select>
                </div>
                <hr>
                <?php if(isset($_GET['number'])):?>
                    <form action="adding.php" method="post">
                        <input type="hidden" name="column" value=<?=$column?>>
                        <input type="hidden" name="ntype"  value="<?=count($chair_size)?>">
                        <input type="hidden" name="cinima_id" value="<?=$_GET['number']?>">
                        <div class="q1">
                            <div class="q2">   
                            <h4><?=$size?> sized cinema</h4>
                           <?php foreach($chair_size as $x=>$data):?>
                                    <input type="hidden" name="order<?=$x?>" value="<?=$data?>">
                                    <p>Order <?=$x?> => <?=$data?> rows</p>
                                    <select class="x<?=$x?>" name="id_type<?=$x?>" required>
                                        <option value="" selected hidden>Select</option>
                                        <?php foreach($chair as $row):?>
                                
                                            <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                        <?php endforeach;?>
                                    </select>
                                
                           <?php endforeach;?>
                           </div>
                        </div>
                        <div class="button">
                            <input type="submit" name="submit" value="submit" class="btn btn-success">
                        </div>
                    </form>
                    <p class="tten" for="">***If the order is less, make the seat closer to the screen.***</p>
                    <hr>
                <?php endif;?> 
            <?php elseif(isset($_GET['branch']) AND $count == 0):?>
                <p>You Must Add Cinema number</p>
                <div class="row">
                    <a class="col" href="../cinema/main.php">Go to add Cinema number</a>
                    <a class="col" href="index.php">Go to list Seat</a>
                </div>
            <?php endif;?>
        </div>
    </div>
    <script>
        let branch1 =  document.querySelector('.branch').value;
        let branch2 = document.querySelector('.branch');
        let check2 = (document.querySelector('.number') == null);
        branch2.onclick = function(){
            if(branch2.value != branch1){
                console.log( branch1,'and',branch2.value);
                branch1 = branch2.value; 
                window.location = `/SFphp/admin/seat/add.php?branch=${branch1}`;
            }
        }
        if(!check2){
            var number = document.querySelector('.number');
            let numberf = number.value;
            number.onclick = function(){
                if(numberf != number.value){
                    numberf = number.value;
                    window.location = `/SFphp/admin/seat/add.php?branch=${branch1}&number=${numberf}`;
                }
            }
        }
    </script>
</body>
</html>