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
    <style>
        table, td{
        
        border-top: 1px solid #fff;
        padding: 1em 2.5em;
    }
    tr:nth-child(odd) {
        background: #eee;
      }
      form td input{
          width: 114%;
          text-align: center;
      }
     .box{
        background: #fff;
        margin: 10px;;
        border-radius: 5px;
        padding: 0 4em;
        min-width: 17em;
        border: 1px solid #eee;
        box-shadow: 2px 2px #eee;
     }
     .box-title{
         color:cornflowerblue; 
     }
     .super-box-title{
         background: linear-gradient(90deg, rgba(94,139,131,1) 32%, rgba(92,111,156,1) 62%, rgba(38,86,123,1) 99%);
         padding: 1em;
         border-top-left-radius: 5px;
         border-top-right-radius: 5px;
         color: #fff;

     }
        .student_data{
            position: absolute;
            margin-left:525px;
            margin-top:200px;
            background: white;
            border-radius: 10px;
            opacity: .85;
            /* padding: 20px;  */
        }
        .row{
            display: flex;
            padding: 0 2em;
            /* justify-content: ; */
            flex-wrap: wrap;
            flex-direction: row;      
            align-items: stretch; 

        }
        .student, .student_id, .SSN{
            padding: 0 3em 0 1em;
        }
        .student_data_print_btn{
            position: absolute;
            margin-left:525px;
            margin-top:500px;
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
    <div id="canvas_div_pdf" class="student_data">
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
    </div>
    <a href="print_student_data.php" class="student_data_print_btn"><span class="fa fa-print"></span> Print </a>

</body>

</html>

