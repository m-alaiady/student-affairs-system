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
        

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

$get_all_student_courses = "
        SELECT  enrolled.absences, courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
        FROM enrolled
        JOIN sections
            ON enrolled.section_id = sections.id
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON courses_time.id = sections.time_id
        JOIN teachers
            ON teachers.id = sections.tutor_id
        WHERE enrolled.student_id = '" . $student_id['id']  . "'";    


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
    <div class="student_data">
        
        <table>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Allowed Absences</th>
                <th>Student's Absences</th>
            </tr>
            <?php
                $student_courses_result = mysqli_query($con, $get_all_student_courses);

                while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
                    if($courses_data['absences'] > 0){
                        echo <<< _END
                            <tr>
                                <td> {$courses_data['course_id']} </td>
                                <td> {$courses_data['course_name']} </td>
                                <td> {$courses_data['allowed_absences']} </td>
                                <td> {$courses_data['absences']} </td>
                            </tr>
                        _END;
                    }
                }

            ?>
        </table>

    </div>
    <a href="print_student_data.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>

</body>

</html>

