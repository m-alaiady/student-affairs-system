<!-- if the session has a value of student id will redirect to register page -->
<!-- if the session has no value will redirect to login page -->
<?php

session_start();

if (isset($_SESSION['student_id'])) {
    if (isset($_SESSION['paid'])) {
        header("location:courses.php");
        exit;
    }
} else {
    header("location:../index.php");
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

// it is to include the SIS project project
require_once("../connection.php");

// this will include the design of the page such as: background, head, footer, and side menu
include("../template/t1.php");

?>

<html>

<head>
    <style>
        .pay-btn-section{
            position: absolute;
            margin-top:10em;
            margin-left: 30em;
        }
        .pay-btn-section input[type='submit']{
            padding: 1em 2em;
            font-size: 1.5em;
        }
    </style>
</head>

<body>

    <div class="pay-btn-section">
        <form method="post">
            <input type="hidden" name="paid" value="1" />
            <input type="submit" name="pay" value="Pay" />
        </form>
    </div>
    <?php

    if (isset($_POST['pay'])) {
        $_SESSION['paid'] = true;
        echo "<script>window.location = 'courses.php'</script>";
    }

    ?>
</body>

</html>