<?php 
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');

if(!isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

$query="select * from students where student_id='".$_SESSION['student_id']."' ";
$result=mysqli_query($con,$query);
$data = mysqli_fetch_assoc($result);

$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
        
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

$get_all_student_courses = "
        SELECT  enrolled.grade, enrolled.absences, courses.*,courses.course_id as c_id, sections.id as section_id, sections.*, courses_time.time, teachers.teacher_name
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

$head = "
    <style>
        table,tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td{
            padding: 1em;
        }
        .footer{
            display:flex;
            justify-content: space-between;
        }
        .logo{
            margin-top: -60x;
            margin-left: 39%;
            width: 50%;
        }
        .text p{
            font-size: 1.6em;
            font-weight: bold;
            text-align: center;
            margin-bottom: -50px;
            z-index: -5;
        }
        .stamp{
            text-align: right;
            margin-top: -5.8em;
        }
        .deanship{
            margin-left: 50px;
        }
    </style>
";

$html = $head;

$html .= "
    <div class='header'>
        
        <div class='logo'>
        <img src='aou-logo.png' alt='logo' width='150'/>
        </div>
        <div class='text'>
            <p>
            Examination schedule
            </p>
            <br><br><br><br>
        </div>
    </div>
    ";

$html .= "
    
    <table style='margin-top: 5em'>
        <tr>
            <th>Course Code</th> 
            <th>Course Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Classroom</th>
        </tr>
";
$student_courses_result = mysqli_query($con, $get_all_student_courses);

while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
    $course_time = $courses_data['exam_time'] > 12 ?  $courses_data['exam_time'] . ' PM': $courses_data['exam_time'] . ' AM';

    $html .= "
        <tr>
            <td>{$courses_data['c_id']}</td> 
            <td>{$courses_data['course_name']}</td>
            <td>{$courses_data['exam_date']}</td>
            <td>{$course_time}</td>
            <td>{$courses_data['id']}</td>
        </tr>";
}

$html .= "</table>";

$html .= "
    
    
    <br><br><br><br>
    <div class='footer'>
        <div class='signature'>
            <p>
                Deanship of admission & Students Affairs<br>
                    <p class='deanship'>
                           Name Here
                    </p>
            </p>
        </div>
        <div class='stamp'>
            <p>Stamp</p>
        </div>
    </div>";

// echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();