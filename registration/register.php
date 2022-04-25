<?php

session_start();

// print_r($_SESSION); die;


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

<form method="post">
    <input type="hidden" name="paid" value="1" />
    <input type="submit" name="pay" value="Pay" />
</form>
<?php

if(isset($_POST['pay'])){
    $_SESSION['paid']=true;
    header("Refresh:0");
}

?>
</body>
</html>