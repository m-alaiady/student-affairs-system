<!-- if the session has a value of student id will redirect to register page -->
<!-- if the session has no value will redirect to login page -->
<?php

session_start();


if(isset($_SESSION['student_id']))
{
    if(isset($_SESSION['paid'])){
        header("location:courses.php?page=1");
    }
}
else
{
    header("location:../index.php");
}

?>

<html>
<head>

</head>
<body>
<button onclick="<?php $_SESSION['paid']='true'; header("Refresh:0"); ?>">pay</button>

</body>
</html>