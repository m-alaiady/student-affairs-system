<?php
require_once('connection.php');

include("template/t1.php");


?>

<html>

<head>
    <title>SIS | Graduation Ceremony</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data{
            all: unset;
            position: absolute;
            margin-left:30vw;
            margin-top:200px;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            transform: scale(0.85);
        }
        .student_data_print_btn {
            all: unset;
            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.25em 1em;
            border: none;
            cursor: pointer;
            color: white;
            
        }
    </style>
</head>


<body>

    <div class="student_data">
        <p class="super-box-title">Graduation Ceremony</p>


        <div class="row" style="padding: 5em">

            <h4 style="color:crimson">No graduation ceremony available at this time.</h4>


        </div>




    </div>
   


    <div id="service"></div>



</body>

</html>

<?php
// show requedted file


?>