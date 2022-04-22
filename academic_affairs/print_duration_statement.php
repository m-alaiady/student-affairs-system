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
            padding: 1.8em;
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
            <p>Study Duration Statement</p>
        </div>
        <br><br><br><br>
    </div>
    ";
$html .= "<table>";
$html .= "
        <tr>
            <th>Name</th> <td colspan='5'>" . $data['s_name'] . "</td>
        </tr>
        <tr>
            <th>National ID</th> <td colspan='3'>" . $data['national_id'] . "</td>
            <th>Student ID</th> <td colspan='1'>" . $data['student_id'] . "</td>
        </tr>
        <tr>
            <th>College</th> <td colspan='3'>" . ucwords($faculty['name']) . "</td>
            <th>Major</th> <td colspan='1'>" . $data['major'] . "</td>
        </tr>
        <tr>
            <th>Level</th> <td colspan='3'>" . $data['level'] . "</td>
            <th>Degree</th> <td colspan='1'>" . $data['degree'] . "</td>
        </tr>
        <tr>
            <th>Academic Status</th> <td colspan='3'>" . ($data['status'] == '1'? 'Active': 'Not active') . "</td>
            <th>Branch</th> <td colspan='1'>" . ucwords($faculty['branch']) . "</td>
         </tr>
        ";


$html .= "</table>";
$html .= "
    <p>
        The Deanship of Admission and Students Affairs certifies that the mentioned above student is one of<br>
        the regular students who is enrolled in the university during " . $data['acceptance_term'] . " and that<br>
        the student study at the university during the Evening time
        <br><br>
        This statement was issues upon the student's request without any responsibility upon the university.
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