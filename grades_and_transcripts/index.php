

<!-- if the session has no value will redirect to login page -->

<?php

session_start();
if(!isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

?>