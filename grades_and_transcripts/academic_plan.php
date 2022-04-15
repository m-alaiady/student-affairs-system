<?php 
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');
require_once('connection.php');


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

$get_foundation_program = "SELECT * FROM foundation_program";  
$get_general_requirement = "SELECT * FROM general_requirement";    
$get_university_requirement = "SELECT * FROM university_requirement";    
$get_faculty_requirement_in_major = "SELECT * FROM faculty_requirement_in_major"; 
$get_faculty_requirement_mandatory = "SELECT * FROM faculty_requirement_mandatory"; 
$get_spec_faculty = "SELECT * FROM spec_faculty"; 
$get_faculty_requirement_electives= "SELECT * FROM faculty_requirement_electives"; 





        
$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);

function print_courses(mysqli_result $result, string $title) : void {
    global $html;

    $html .= "
        <h3 class='table-title' style='margin-top: 2em'>{$title}</h3>
        <table class='bordered-table' style='margin-top: 5em'>
        <tr>
            <th>Course</th> 
            <th>Course title</th>
            <th>Credits</th>
        </tr>
    ";
    while( $courses_data= mysqli_fetch_assoc($result)){
        $html .= "
            <tr>
                <td>{$courses_data['course_id']}</td> 
                <td>{$courses_data['course_name']}</td>
                <td class='credits'>{$courses_data['credits']}</td>
            </tr>";
    }
    // $html .= "</table>";
    $html .= "
        </table>
        ";


}

$head = "
    <style>
        table{
            width: 100%;
        }
        .bordered-table,.bordered-table th, .bordered-table td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
        .table-title{
            text-align:center;
            background: #ccc;
            border: 1px solid black;
        }
        .credits{
            text-align: center;
        }
        th{
            text-align: left;
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



$html .= "<table class='no-border'>";
$html .= "
        <tr>
            <th>Stundent Code</th> <td colspan='4'>" . $data['national_id'] . "</td>
            <th>Branch</th> <td>" . $data['national_id'] . "</td>
        </tr>
        <tr>
            <th>Student Name</th> <td colspan='4'>" . ucwords($data['s_name']) . "</td>
            <th>Birth Date</th> <td>" . date('M d, Y', strtotime($data['birth_date'])) . "</td>
        </tr>
        <tr>
            <th>Mother name</th> <td colspan='4'>" . ucwords($data['mother']) . "</td>
            <th>Birth Place</th> <td>" . ucwords($data['birth_place']) . "</td>
        </tr>
        <tr>
            <th></th> <td colspan='4'></td>
            <th>Gender</th> <td>" . ucwords($data['gender']) . "</td>
        </tr>
         <tr>
            <th>Track</th> <td colspan='4'>" . ucwords($data['major']) . "</td>
            <th>Nationality</th> <td>" . ucwords($data['nationality']) . "</td>
         </tr>
         <tr>
            <th>Degree</th> <td colspan='4'>" . $data['degree'] . "</td>
            <th>GPA</th> <td>" . $data['GPA'] . "</td>
        </tr>
        ";


$html .= "</table>";

$get_faculty_requirement_in_major = "SELECT * FROM faculty_requirement_in_major"; 
$get_faculty_requirement_mandatory = "SELECT * FROM faculty_requirement_mandatory"; 
$get_spec_faculty = "SELECT * FROM spec_faculty"; 
$get_faculty_requirement_electives= "SELECT * FROM faculty_requirement_electives"; 

$foundation_program_result = mysqli_query($academic_con, $get_foundation_program);
$general_requirement_result = mysqli_query($academic_con, $get_general_requirement);
$university_requirement_result = mysqli_query($academic_con, $get_university_requirement);
$faculty_requirement_in_major_result = mysqli_query($academic_con, $get_faculty_requirement_in_major);
$faculty_requirement_mandatory_result = mysqli_query($academic_con, $get_faculty_requirement_mandatory);
$spec_faculty_result = mysqli_query($academic_con, $get_spec_faculty);
$faculty_requirement_electives_result = mysqli_query($academic_con, $get_faculty_requirement_electives);



print_courses($foundation_program_result, 'Foundation Program Requirement');
print_courses($general_requirement_result, 'General Requirement (Credits Needed = 18)');
print_courses($university_requirement_result, 'University Requirements/Electives (Credits Needed = 3)');
print_courses($faculty_requirement_in_major_result, 'Faculty Requirements in IT (Credits Needed = 4)');
print_courses($faculty_requirement_mandatory_result, 'Faculty Requirements/Mandatory (Credits Needed = 4)');
print_courses($spec_faculty_result, 'Spec. Requirements/Mandatory (Credits Needed = 96)');
print_courses($faculty_requirement_electives_result, 'Faculty Requirements/Electives (Credits Needed = 6)');



$html .= "
<br><br><br><br>
<div class='footer'>
    <div class='signature'>
        <p>
            Deanship of admission & Students Affairs<br>
                    <p class='deanship'>Name here</p>
        </p>
    </div>
    <div class='stamp'>
        <p>Stamp</p>
    </div>
</div>
";



// echo $html;
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();