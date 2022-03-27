<?php

session_start();
if(isset($_SESSION['student_id']))
{
    header("location:register.php");
}
else
{
    header("location:../index.php");
}

?>