<?php 
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');

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
        SELECT  enrolled.grade, enrolled.absences, courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
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
            padding: 2em;
        }
        .footer{
            display:flex;
            justify-content: space-between;
        }
        .logo{
            margin-top: -75px;
            margin-left: 450px;
            width: 50%;
        }
        .text p{
            position:absolute;
            top: 50;
            margin-bottom: -25px;
            z-index: 5;
        }
        .stamp{
            text-align: right;
            margin-top: -72px;
        }
        .deanship{
            margin-left: 50px;
        }
    </style>
";

$html = $head;

$html .= "
    <div class='header'>
        <p>OFFICAL TRANSCRIPT / Saudi Arabia 2030 Brar</p>
        <p style='margin-left: 2em'>Divsion of Admissions and Registration</p>
        <h3>Student Information:</h3>
    </div>
    ";

$html .= "<table>";
$html .= "
        <tr>
            <th>Student Name</th> <td colspan='5'>" . $data['s_name'] . "</td>
        </tr>
        <tr>
            <th>Stundent Number</th> <td colspan='2'>" . $data['national_id'] . "</td>
            <th>Date of Birth</th> <td colspan='2'>" . date('M d, Y', strtotime($data['birth_date'])) . "</td>
        </tr>
        <tr>
            <th>Program of Study</th> <td colspan='2'>" . $data['major'] . "</td>
            <th>Nationality</th> <td colspan='2'>" . $data['nationality'] . "</td>
        </tr>
        <tr>
            <th>Admission Date</th> <td colspan='2'>" . $data['acceptance_term'] . "</td>
            <th>Basis of Admission</th> <td colspan='2'>" . $faculty['name'] . "</td>
         </tr>
        ";


$html .= "</table>";
$html .= "
    <h3 style='margin-top: 2em'>Courses Information:</h3>
    <table style='margin-top: 5em'>
        <tr>
            <th>Course</th> 
            <th>Course title</th>
            <th>Credits</th>
            <th>Grade</th>
            <th>Points</th>
        </tr>
";
$student_courses_result = mysqli_query($con, $get_all_student_courses);

while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
    $html .= "
        <tr>
            <td>{$courses_data['course_id']}</td> 
            <td>{$courses_data['course_name']}</td>
            <td>{$courses_data['credits']}</td>
            <td>{$courses_data['grade']}</td>
            <td></td>
        </tr>";
}

$html .= "</table>";

// echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();