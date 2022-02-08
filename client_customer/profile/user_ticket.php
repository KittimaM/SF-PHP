<?php 
    include '../../server/connectdb.php';
    session_start();

?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container-ticket{
            width:100%;
            padding: 3rem;
        }
        .ticket-field{
            width:50%;
        }
        .ticket-select{
            width:30%;
            margin: 2rem 0;
        }


        
    </style>
    <link rel="stylesheet" href="https://anandchowdhary.github.io/ionicons-3-cdn/icons.css" integrity="sha384-+iqgM+tGle5wS+uPwXzIjZS5v6VkqCUV7YQ/e/clzRHAxYbzpUJ+nldylmtBWCP0" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container-ticket">
            <div class="header profile-ticket"><h1>You Ticket</h1></div>
            <?php if(isset($_SESSION["success"])):?>
                <hr>
                <div class="alert alert-success" role="alert">
                    <?=$_SESSION["success"]?>
                </div>
                <hr>
            <?php endif;?>
            <?php unset($_SESSION["success"])?>
            <div class="ticket-detil">
                <form class="ticket-select" name="type-ticket" >
                    <select class="form-select" aria-label="Default select example">
                        <option value="1" selected>Can Use</option>
                        <option value="0">Out of time</option>
                    </select>
                </form>
                <hr>
                <div class="ticket-field"></div>
                    
                </div>
            </div>
        </div>
</body>
</html>