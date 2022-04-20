<?php

ob_start();
require_once('../connection.php');
include("../template/t1.php");

if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

// get the faculty, major and branch name
$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
        
$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);

?>

<html>

<head>
    <title>SIS | Academic Affairs</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//box.css" />
    <style>
    .student_data{
        all:unset;
        position: absolute;
        margin-top: 10em;
        margin-left: 20em;
        margin-bottom: 2em;
        background: white;
        border-radius: 10px;
        opacity: .85;
        transform: scale(0.85);
        /* transform: translate(35%, 50%); */
        /* padding: 20px;  */
                
    }
        
    .student_data_print_btn{
        position: relative;
        margin-top: 2vh;
        margin-left: 45%;
        background-color: dodgerblue;
        border-radius: 10px;
        padding: 0.5em 2em;
        border: none;
        cursor: pointer;
        color: white;
    }
    </style>
</head>


<body>
    <div class="student_data">
        <p class="super-box-title">Student Data</p>
        <div class="row">
            <div class="student box">
                <p class="box-title">Stundet Name</p>
                <p><?php echo $data['s_name']; ?></p>
            </div>
            <div class="student_id box">
                <p class="box-title">Stundet ID</p>
                <p><?php echo $data['student_id']; ?></p>
            </div>
            <div class="SSN box">
                <p class="box-title">SSN</p>
                <p><?php echo $data['national_id']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="student box">
                <p class="box-title">Acceptance Term</p>
                <p><?php echo $data['acceptance_term']; ?></p>
            </div>
            <div class="student_id box">
                <p class="box-title">Current Academic Status</p>
                <p><?php echo ($data['status'] == '1'? 'Active': 'Not active'); ?></p>
            </div>
            <div class="SSN box">
                <p class="box-title">Final GPA</p>
                <p><?php echo $data['GPA']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="student box">
                <p class="box-title">Faculty</p>
                <p><?php echo $faculty['name']; ?></p>
            </div>
            <div class="student_id box">
                <p class="box-title">Major</p>
                <p><?php echo $data['major']; ?></p>
            </div>
            <div class="SSN box">
                <p class="box-title">Branch</p>
                <p><?php echo $faculty['branch']; ?></p>
            </div>
        </div>
        <div class="row">
            <a href="print_student_data.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
        </div>
        <br />
        </div>

    </div>

</body>
</html>

