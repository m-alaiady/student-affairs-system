<?php
    require_once('env.php');
    $con=mysqli_connect('localhost','root',$password,'sis project');

    if(!$con)
    {
        die(' Please Check Your Connection'.  mysqli_connect_error());
    }

    mysqli_set_charset($con,'utf8');

?>