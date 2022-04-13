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
        
$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);


$std_id = $student_id['id'];

$get_registered_hours = "
        SELECT
            SUM(credits)
        FROM
            enrolled
            JOIN sections ON enrolled.section_id = sections.id
            JOIN courses ON sections.course_id = courses.id
        WHERE
            student_id = '$std_id';";    

$get_registered_hours_result = mysqli_query($con, $get_registered_hours);

$registered_hours = mysqli_fetch_assoc($get_registered_hours_result);

$head = "
    <style>
        table,tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
            border-width: 2px;
        }
        th, td{
            padding: 2em;
        }
        .footer{
            display:flex;
            justify-content: space-between;
        }
        .logo{
            margin-top: -60x;
            margin-left: 450px;
            width: 50%;
        }
        .text p{
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
        <div class='text'>
            <p>Schedule Statement</p>
        </div>
        <div class='logo'>
            <img src='logo.png' alt='logo' width='250'/>
        </div>
    </div>
    ";
$html .= "<table>";
$html .= "
        <tr>
            <th>Name</th> <td colspan='5'>" . $data['s_name'] . "</td>
        </tr>
        <tr>
            <th>National ID</th> <td>" . $data['national_id'] . "</td>
            <th>Student ID</th> <td>" . $data['student_id'] . "</td>
            <th>Registered Hours</th> <td>" . $registered_hours['SUM(credits)'] . " hrs </td>
        </tr>
        <tr>
            <th>GPA</th> <td>" . $data['GPA'] . "</td>
            <th>Academic Status</th> <td>" . ($data['status'] == '1'? 'Active': 'Not active') . "</td>
            <th>Academic Term</th> <td>" . $data['acceptance_term'] . "</td>
        </tr>
        <tr>
            <th>Faculty</th> <td>" . $faculty['name'] . "</td>
            <th>Major</th> <td>" . $data['major'] . "</td>
            <th>Branch</th> <td>" . $faculty['branch'] . "</td>
         </tr>
        ";


$html .= "</table>";
$html .= "
    <br />
    <table>
        <tr>
            <th>No.</th>
            <th>Reference No.</th>
            <th>Course Code</th>
            <th>Course</th>
            <th>Time</th>
            <th>Room</th>
            <th>Day</th>
            <th>Lecture Type</th>
        </tr>
        <tr>
            <td>No.</td>
            <td>Reference No.</td>
            <td>Course Code</td>
            <td>Course</td>
            <td>Time</td>
            <td>Room</td>
            <td>Day</td>
            <td>Lecture Type</td>
         </tr>
    </table>
    ";

$html .= "
    <p>
       
    </p>
    <br><br><br><br>
    <div class='footer'>
        <div class='signature'>
            <p>
                Deanship of admission & Students Affairs<br>
                        <p class='deanship'>Name Here</p>
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