<?php

    $con=mysqli_connect('localhost','root','','sis project');

    if(!$con)
    {
        die(' Please Check Your Connection'.mysqli_error($con));
    }
?>