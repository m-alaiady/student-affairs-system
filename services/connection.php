<?php
    require_once('../env.php');
    $services_con=mysqli_connect('localhost','root',$password,'services');

    if(!$services_con)
    {
        die('There is an error in the services DB, please Check Your Connection'.  mysqli_connect_error());
    }
    mysqli_set_charset($services_con,'utf8');
?>