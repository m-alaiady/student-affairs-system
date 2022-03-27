<?php

session_start();
if(isset($_SESSION['student_id']))
{
    header("location:view_information.php");
}
else
{
    header("location:../index.php");
}

?>