<?php
    include '../../server/connectdb.php';
    $branch = $pdo->prepare('SELECT * FROM branch');
    $branch->execute();
    if(isset($_GET['branch'])){
        $movie = $pdo->prepare('SELECT * FROM movie');
        $cinema = $pdo->prepare('SELECT * FROM cinema WHERE cinema.id_branch = :id_branch AND chair = :chair');
        $id_b = substr($_GET['branch'],0,5);
        $cinema->bindParam(':id_branch',$id_b);
        $chair = 1;
        $cinema->bindParam(':chair',$chair);
        $count = $pdo->prepare('SELECT COUNT(*) FROM cinema WHERE cinema.id_branch = :id_branch AND chair = :chair');
        $count->bindParam(':id_branch',$id_b);
        $count->bindParam(':chair',$chair);
        $count->execute();
        $cinema->execute();
        $movie->execute();
        $next_week = strtotime('next week');
        $time = date('Y-m-d', strtotime('sunday', $next_week));
        $time2 = date('Y-m-d',strtotime('sunday',strtotime('+4 weeks')));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
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
        html, body {
            height: 100%;
            margin: 0;
            padding:0;
        }
        .full-height {
            width:100%;
            height:100%;
            padding: 30px;
        }
        .page{
            width:80%;
            height:100%;
            background-color:white;
            margin: auto;
            padding: 30px;
        }
        .page .q1{
            margin:20px auto;
            text-align:center;
            width: 100%;
        }
        .page .q1 select{
            width:40%;
            text-align:center;
        }
        .page form{
            margin:auto;
        }
        .page form .q2inner{
            margin-top: 25px;
            text-align:center;
        }
        .page form .q2inner select,.page form .q2inner input{
            text-align:center;
            width:40%;
        }
        .alert{
            text-align:center;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="full-height">
    <div class="card">
        <div class="card-header">
            <h2 style="text-align:center;margin:20px 0px;">Add Show Time</h2>
        </div>
        <div class='page'>
        <?php if(isset($_SESSION["success"])):?>
        <hr>
        <div class="alert alert-success" role="alert">
            <?=$_SESSION["success"]?>
        </div>
        
        <?php 
            unset($_SESSION["success"]);
            elseif(isset($_SESSION["fail"])): 
        ?>
            <hr>
            <div class="alert alert-danger" role="alert">
                <?=$_SESSION["fail"]?>
            </div>
        <?php 
            unset($_SESSION["fail"]); 
            elseif(isset($_SESSION["error"])):
        ?>
            <hr>
            <div class="alert alert-warning" role="alert">
                <?=$_SESSION["error"]?>
            </div>
        <?php
            unset($_SESSION['error']);
            endif;
        ?>
            <hr>
            <div class="q1">
                <label for="">Branch :&nbsp&nbsp</label>
                <select class="question1 col-2" name="branch" required>
                    <option value="" selected hidden><?=(isset($_GET['branch']))?substr($_GET['branch'],5):"Select"?></option>
                    <?php while($row = $branch->fetch()):?>
                        <option value="<?=$row['id_branch']?><?=$row['name_branch']?>"><?=$row['name_branch']?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <hr>
            <?php if(isset($_GET['branch']) AND boolval($count->fetch()[0])):?>
            <form id='question2' action="adding.php" method="post">
                <input type="hidden" name="branch" value=<?=substr($_GET['branch'],0,5)?>>
                <div class="q2inner">
                    <label for="" class="col-1">Movie : </label>
                    <select  name="movie" required>
                        <option value="" selected hidden>Select</option>
                        <?php while($row = $movie->fetch()):?>
                            <option value="<?=$row['id_movie']?>"><?=$row['name_movie_eng']?></option>
                        <?php endwhile;?>
                    </select>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">Cinema : </label>
                    <select name='cinema' required>
                        <option value="" selected hidden>Select</option>
                        <?php while($row = $cinema->fetch()):?>
                            <?php if($row['chair']):?>
                                <option value="<?=$row['id_cinema']?>"><?=$row['name_cinema']?></option>
                            <?php endif;?>
                        <?php endwhile;?>
                    </select>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">Start Date: </label>
                    <input class="start_date" type="date" name="startdate" min=<?=$time?>>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">Month: </label>
                    <input class="month" type="number" name="month" min='1' max='3' value='1'>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">End Date: </label>
                    <input class="end_date" type="date" name="enddate" min=<?=$time2?> readonly>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">Sound: </label>
                    <select name='sound' required>
                        <option value="" selected hidden>Select</option>
                        <option value="ENG">English</option>
                        <option value="TH">Thai</option>
                    </select>
                </div>
                <div class="q2inner">
                    <label for="" class="col-1">Subtitle: </label>
                    <select name='subtitle' required>
                        <option value="" selected hidden>Select</option>
                        <option value="NONE">none</option>
                        <option value="ENG">English</option>
                        <option value="TH">Thai</option>
                    </select>
                </div>
                <hr>
                <div class="q2inner">
                    <input class="btn btn-success" name="check" style="width:20%;margin-top:10px;" type="submit" value="submit">
                </div>
            </form>
            <?php endif;?>
        </div>
    </div>
    </div>
    <script> 
        let question1 =document.querySelector('.question1');
        let branch_start = question1.value;
        question1.onclick = function(){
            if(question1.value != branch_start){
                branch_start = question1.value;
                window.location = `/SFphp/admin/schedule/add.php?branch=${branch_start}`;
            }
        }
        var date = document.querySelector('.start_date');
        var date1 = document.querySelector('.end_date');
        var month = document.querySelector('.month');
        if(date.value != ""){
            var chooseDate=new Date(date.value);
            chooseDate.setDate(chooseDate.getDate()+(30*month.value));
            var futureDate = chooseDate.getFullYear()+'-'+('0'+(chooseDate.getMonth()+1)).slice(-2)+'-'+('0'+(chooseDate.getDate())).slice(-2);
            date1.value = futureDate;
        }
        date.onchange = function(){
            var chooseDate=new Date(date.value);
            chooseDate.setDate(chooseDate.getDate()+(30*month.value));
            var futureDate = chooseDate.getFullYear()+'-'+('0'+(chooseDate.getMonth()+1)).slice(-2)+'-'+('0'+(chooseDate.getDate())).slice(-2);
            date1.value = futureDate;
        }
        month.onchange = function(){
            var chooseDate=new Date(date.value);
            chooseDate.setDate(chooseDate.getDate()+(30*month.value));
            var futureDate = chooseDate.getFullYear()+'-'+('0'+(chooseDate.getMonth()+1)).slice(-2)+'-'+('0'+(chooseDate.getDate())).slice(-2);
            date1.value = futureDate;
        }
    </script>
</body>
</html>