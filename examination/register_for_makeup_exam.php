<?php
require_once('../connection.php');

include("../template/t1.php");


?>

<html>

<head>
    <title>SIS | Exam Certificate</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data{
            all: unset;
            position: absolute;
            margin-left:40vw;
            margin-top:10em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            transform: scale(0.85);
        }
    </style>
</head>


<body>

    <div class="student_data">
        <p class="super-box-title">Register For Makeup Exam</p>


        <div class="row" style="padding: 5em">

            <h4 style="color:crimson">You cannot currently access this section.</h4>


        </div>




    </div>
   


    <div id="service"></div>



</body>

</html>

<?php
// show requedted file


?>