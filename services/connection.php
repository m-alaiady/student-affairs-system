<?php

    $services_con=mysqli_connect('localhost','root','123456','services');

    if(!$services_con)
    {
        die('There is an error in the services DB, please Check Your Connection'.  mysqli_connect_error());
    }
?>