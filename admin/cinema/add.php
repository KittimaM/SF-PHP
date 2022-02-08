<?php
    include '../../server/connectdb.php';
    $branch = $pdo->prepare('SELECT * FROM branch');
    $branch->execute();
    $type = $pdo->prepare('SELECT * FROM screen_type');
    $type->execute();
    $size = $pdo->prepare('SELECT * FROM size_cinema');
    $size->execute();
    $number = FALSE;
    $branchID ="";
    if(isset($_GET['branch'])){
        $branchN = substr($_GET['branch'],5);
        $branchID = substr($_GET['branch'],0,5);
        $ciniN = $pdo->prepare('SELECT COUNT(*) FROM cinema WHERE id_branch = :id');
        $ciniN->bindParam(':id',$branchID);
        $ciniN->execute();
        $number = TRUE;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
         .card-header{
            text-align: center;
        }
        .card-container{
            padding: 20px 5%;
        }
        .btn{
            width: 100px;
            margin-right:2em;
        }
        .header{
            text-align: center;
        }
        body{
            background:smoke;
        }
        .page{
            padding: 30px;
            background-color:#f1f1f1;
            min-height: 44rem; 
        }
        .content{
            width: 60%;
            min-height: 500px;
            margin: auto;
            padding: 50px 5em;
            background-color:white;
        }
        select{
            width: 80%;
            height: 2em;
            text-align: center;
        }
        h1{
            text-align: center;
        }
        textarea{
            height: 200px;
        }
        input[type=text] , input[type=number]{
            text-align:center;
            width: 80%;
        }
        .top-1{
            width: 20rem;
            margin: 0 2rem 0 0;
            display:flex;
            align-items: center;
            justify-content: center;
        }
        .top{
            margin-top:20px;
        }
        label{
            width: 10em;
        }
        .form-group{
            text-align: center;
        }
    </style>
</head>
<body>
<?php include "../nav.php"?>
    <div class="card">
        <div class="card-header">
            <h1 class="header">Add Cinema </h1>
        </div>
        <div class="card-container">
    <hr>
    <div  class="mb-3 top">
        Branch: 
        <select class="add1" name="branch">
            <option value='<?=isset($_GET['branch'])?$_GET['branch']:'';?>' selected="selected" hidden><?=isset($branchN)?$branchN:'select one';?> </option>
            <?php while($row = $branch->fetch()):?>
                <option  value='<?=$row['id_branch']?><?=$row['name_branch']?>'><?=$row['name_branch']?></option>
            <?php endwhile;?>
        </select>
        </div>
    <hr>
    <?php if(isset($_GET['branch'])):?>
        <form class="form-group" action="adding.php?" method="post">
            <input type="hidden" value='<?=$branchID?>' name="branch">
            <div class="top" style="display:inline-flex;">
                <div>
                    <label>Cinema number</label>&nbsp
                    <input name ="cinema_num" type="number" min='0' max='99' value='<?=($number)?($ciniN->fetch()[0]+1):1;?>' readonly required>
                </div>
                <div>
                    <label>Screen type</label>&nbsp
                    <select name="type" required>
                            <option value="" selected="selected" disabled hidden>select one</option>
                            <?php while($row = $type->fetch()):?>
                                <option value='<?=$row['id_screen']?>'><?=$row['name']?></option>
                            <?php endwhile;?>
                    </select>
                </div>
                <div>
                    <label>Cinema size</label>&nbsp
                    <select name="size" required>
                            <option value="" selected="selected" disabled hidden>select one</option>
                            <?php while($row = $size->fetch()):?>
                                <option value='<?=$row['id_size']?>'><?=$row['name']?></option>
                            <?php endwhile;?>
                    </select>
                </div>
                
            </div>
            <hr>
            <br>

            <div class="text-center">
                <input class="btn btn-primary" type="submit" value="add" name="submit">
                <a class="btn btn-danger" href="main.php" name="submit">cancle</a>
            </div>
            <br>
        </form>
    <?php endif;?>
    </div>
    </div>
    <script>
        const option1 =  document.querySelector('.add1').value;
        let option2 = document.querySelector('.add1');
        option2.onclick = function(){
            if(option1 !== option2.value){
                window.location = '/SFphp/admin/cinema/add.php?'+'branch='+option2.value;
            }
        }
    </script>
</body>
</html>