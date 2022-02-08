<?php
    session_start();
    include '../../server/connectdb.php';
    if(isset($_POST['submit'])){
        print_r($_POST);
        $id = $_POST['branch'];
        $name = sprintf('%02s',$_POST['cinema_num']);
        $id = $id.$name;
        $arr = [':id'=>$id,':name'=>$name,':type'=>$_POST['type'],':id_branch'=>$_POST['branch'],':id_size'=>$_POST['size'],':chair'=>0];
        $save = $pdo->prepare('INSERT INTO cinema VALUES (:id,:name,:type,:id_branch,:id_size,:chair)');
        foreach(array_keys($arr) as $x ){
            $save->bindParam($x,$arr[$x]);
        }
        $save->execute();
        header('location:main.php');
    }
    header('location:main.php');
?>