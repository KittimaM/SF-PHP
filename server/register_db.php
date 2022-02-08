<?php
    session_start();
    $age = '';
    if(!isset($_POST['check'])){
        header("location: ../login.php");
    }else{
        function CheckEmail(){
            include('connect.php');
            if($_POST['email'] != ""){
                $email = $_POST['email'];
                $check = "SELECT email FROM user WHERE email = '$email'";
                $query = mysqli_query($conn,$check);
                $result = mysqli_fetch_assoc($query);
                if(empty($result)){
                    $_SESSION['usedEmail'] = $email;
                    return true;
                }else{
                    $_SESSION['emailErr'] = "*Duplicate email.";
                    return false;
                }
            }else{
                $_SESSION['emailErr'] = "*Please enter your email.";
                return false;
            }
        }
        function Checkpassword1(){
            if($_POST['password'] != ""){
                return $_POST['password'];
            }
            $_SESSION['PassErr'] = "*Please enter your password";
            return false;
        }
        function Checkpassword2(){
            if($_POST['cpassword'] != ""){
                return $_POST['cpassword'];
            }
            $_SESSION['2ndPassErr'] = "*Please enter confirm password";
            return false;
        }
        function CheckPassword12(){
            $cp = Checkpassword2();
            $p  = Checkpassword1();
            if($cp && $p){
                if($p == $cp){
                    return true;
                }else{
                    $_SESSION['2ndPassErr'] = "*It not same password";
                    return false;
                }
            }else{
                return false;
            }
        }
        function Checkfname(){
            if($_POST['fname'] != ""){
                $_SESSION['fnameuse'] = $_POST['fname'];
                return true;
            }else{
                $_SESSION['Firstname'] = "*Please enter firstname";
                return false;
            }
        }
        function Checklname(){
            if($_POST['lname'] != ""){
                $_SESSION['lnameuse'] = $_POST['lname'];
                return true;
            }else{
                $_SESSION['Lastname'] = "*Please enter lastname";
                return false;
            }
        }
        function Checktel(){
            if($_POST['tel'] != ""){
                $_SESSION['teluse'] = $_POST['tel'];
                return true;
            }else{
                $_SESSION['Telc'] = "*Please enter telephone number";
                return false;
            }
        }
        function Checkhbd(){
            if($_POST['hbd'] != ""){
                return true;
            }else{
                $_SESSION['hbdnew'] = "*Please enter your birthday";
                return false;
            }
        }
        function Check(){
            $c1 = CheckEmail();
            $c2 = CheckPassword12();
            $c3 = Checkfname();
            $c4 = Checklname();
            $c5 = Checktel();
            $c6 = Checkhbd();
            return $c1 AND $c2 AND $c3 AND $c4 ;
        }
        function age(){
            $t1 = new DateTime(date("Y-m-d"));
            $t2 = new DateTime( $_POST['hbd']);
            return ($t1->diff($t2))->y;
        }
        include('connectdb.php');
        
        if(Check()){

            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $fname =$_POST['fname'];
            $lname = $_POST['lname'];
            $birthday = $_POST['hbd'];
            $tel = $_POST['tel'];
            $status = "Customer";
            $age = age();


            $sql = "INSERT INTO user VALUES (:email,:fname,:lname,:password,:birthday,:age,:tel,:status)";
            $record = $pdo->prepare($sql);
            $record->bindParam(':email',$email);
            $record->bindParam(':fname',$fname);
            $record->bindParam(':lname',$lname);
            $record->bindParam(':password',$password);
            $record->bindParam(':birthday',$birthday);
            $record->bindParam(':age',$age);
            $record->bindParam(':tel',$tel);
            $record->bindParam(':status',$status);
            $record->execute();
            header('location:../login.php');
        }else{
            header('location:../register.php');
        }
    }
?>