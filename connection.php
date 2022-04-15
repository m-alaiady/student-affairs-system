<?php

    $con=mysqli_connect('localhost','root','123456','sis project');

    if(!$con)
    {
        die(' Please Check Your Connection'.  mysqli_connect_error());
    }

    mysqli_set_charset($con,'utf8');

?>