<?php 
    include '../../server/connectdb.php';
    session_start();
    if(!(isset($_SESSION['email']) AND isset($_SESSION['status']))){
        header("Location: ../../login.php");
    }
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .box{
            padding: 3rem;
        }
        .container{
            width: 100%;
            height: 90vh;
            margin:0 auto;
            border: 2px solid black;
            border-radius:30px;
            padding: 3rem;
        }
        .header{
            text-align: center;
        }
        .inside{
            margin:0 auto;
            width: 50%;
        }
        .inside input{
            padding-left: 2rem;
            -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box;    /* Firefox, other Gecko */
            box-sizing: border-box;         /* Opera/IE 8+ */
        }
        .button-ticket{
            margin: 30px auto;
            width: 50%;
        }
        .button-ticket a{
            width:100%;
            padding: 10px 1em;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="container">
            <div class="header"><h1>Profile</h1></div>
            <div class="profile-detil">
                <div class="row mb-3 inside">
                    <p>Name</p>
                    <input type="text" value="<?=$_SESSION['fname']?>  <?=$_SESSION['lname']?>" readonly>
                </div>
                <div class="row mb-3 inside">
                    <p>Birthday</p>
                    <input type="text" value="<?=$_SESSION['hbd']?>" readonly>
                </div>
                <div class="row mb-3 inside">
                    <p>Age</p>
                    <input type="text" value="<?=$_SESSION['age']?>" readonly>
                </div>
                <div class="row mb-3 inside">
                    <p>Email</p>
                    <input type="email" value="<?=$_SESSION['email']?>" readonly>
                </div>
                <div class="row mb-3 inside">
                    <p>Tel</p>
                    <input type="text" value="<?=$_SESSION['tel']?>" readonly>
                </div>
                <div class="button-ticket">
                    <a class="btn btn-info" href="user_ticket.php?userID=<?=$_SESSION['email']?>">Ticket Check</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>