<?php

session_start();


if(isset($_SESSION['student_id']))
{
    if(isset($_SESSION['paid'])){
        header("location:courses.php");
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