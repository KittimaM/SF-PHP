<?php
    session_start();
    include('connect.php');

    if(isset($_POST['login_user'])){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
    
        $check = "SELECT * FROM user WHERE email = '$email' AND password = '$password' ";
        $query = mysqli_query($conn,$check);
        if(mysqli_num_rows($query) == 1){
            $_SESSION['email'] = $email;
            $result = mysqli_fetch_assoc($query);
            $_SESSION['fname'] = $result['fname'];
            $_SESSION['lname'] = $result['lname'];
            $_SESSION['hbd'] = date('m-d-Y',strtotime($result['birthday_user']));
            $_SESSION['age'] = ($result['age']);
            $_SESSION['tel'] = $result['tel'];
            $_SESSION['status'] = $result['status'];
           
            header('location:../index.php');
        }else{
            header('location:../login.php');
        }
    }
?>