<?php
    session_start();
    if(isset($_SESSION['email'])){
        session_destroy();
        session_unset();
        header('location: ../login.php');
    }else{
        header('location: ../login.php');
    }
?>