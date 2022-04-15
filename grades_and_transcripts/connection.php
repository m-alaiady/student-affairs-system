<?php
     require_once('../env.php');
    $academic_con=mysqli_connect('localhost','root',$password,'academic_plan');

    if(!$academic_con)
    {
        die(' Please Check Your Connection'.  mysqli_connect_error());
    }
    mysqli_set_charset($con,'utf8');
?>