<!DOCTYPE html>
<?php //http://localhost/project_sffake/page1.php
    include('../../server/connectdb.php'); //connect db
    include '../group.php';
    $seat = $pdo->prepare('SELECT chair.id_cinema ,size_cinema.name,type_chair.name AS type_chair FROM chair,type_chair,cinema,size_cinema
    WHERE type_chair.id = chair.id_type AND chair.id_cinema = cinema.id_cinema AND cinema.id_size = size_cinema.id_size
    GROUP BY chair.id_cinema');
    $seat->execute();
    $seat = ($seat->fetchall());
    $seat = group_by('id_cinema', $seat);
    //print_r($seat);
?>
<!DOCTYPE html>
<html lang="en">
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
        select{
            width: 70%;
        }
        table{
            margin: 20px auto 0;
            text-align: center;
        }
        .d-flex{
            margin: 10px 20px; 
        }
        .btn{
            margin: 10px;
        }
        .num{
            justify-content: center; 
        }
        .alert{
            margin: 20px 0 0 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "../nav.php"?>
    <div class="card">
        <div class="card-header"><h1 class = "header">Seat in Cinema</h1></div>
        <div class="card-container">
            <div class="heada d-flex">
                <div class="col-8">
                    <a href="add.php" class="btn btn-success">+Add</a>
                </div>
            </div>
        
            <div class="tb">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <th>Cinema ID</th>
                        <th >Size of cinema</th>
                        <th >Type of Chair</th>
                    </thead>
                    <tbody>
                    <?php foreach($seat as $row):?>
                        <tr>
                        <td align = 'center'><?= $row[0]["id_cinema"] ?></td>
                        <td align = 'center'><?= $row[0]["name"] ?></td>
                        <td align = 'center'>
                        <?php foreach($row as $ddd):?>
                                <?= $ddd["type_chair"] ?>
                        <?php endforeach;?>
                        </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                
                </table>
            </div>
        </div>
    </div>
    <!-- show all movie ------------------------------------------------------->
</body>
</html>
</body>
</html>