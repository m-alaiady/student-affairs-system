<?php
     require_once('../env.php');
    $exam_con=mysqli_connect('localhost','root',$password,'examination');

    if(!$exam_con)
    {
        die('There is an error in the services DB, please Check Your Connection'.  mysqli_connect_error());
    }
    mysqli_set_charset($exam_con,'utf8');
?>