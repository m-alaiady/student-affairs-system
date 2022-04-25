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
<link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//box.css" />
    <style>
        
        .pay-btn-section input[type='submit']{
            text-decoration: none; 
            background: #2691d9; 
            border-radius: 25px;
            font-size: 18px; 
            color: white;
            padding: .4em;
            font-weight: 500;
            margin-left:32%;
            border: none;
            cursor: pointer;
        }
        .rfees{
            all:unset;
            position: absolute;
            margin-left:32em;
            margin-top:15em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(1);
            padding-bottom:1em; 
        }
    </style>
</head>

<body>
    <div class="rfees">
    <p class="super-box-title">Registration fees</p>
    <p style="padding:1.6em; color:red;">You should pay the registration fees and any previous debt before <br>
    registering in the current semester and pay Registration Fees First <br> 
    from the Financial Section and check the registration calendar</p>
    <div class="pay-btn-section">
        <form method="post">
            <input type="hidden" name="paid" value="1" />
            <input type="submit" name="pay" value="Pay Registration Fees" />
        </form>
    </div>
    <h2 style="text-align: center; padding-bottom: 5px;"></h2>
    
    </div>
    <?php

    if (isset($_POST['pay'])) {
        $_SESSION['paid'] = true;
        echo "<script>window.location = 'courses.php'</script>";
    }

    ?>
</body>

</html>