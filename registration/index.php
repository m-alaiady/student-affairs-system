<!-- if the session has a value of student id will redirect to register page -->
<!-- if the session has no value will redirect to login page -->

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