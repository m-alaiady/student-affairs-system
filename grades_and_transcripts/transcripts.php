<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');

if (!isset($_SESSION['student_id'])) {
    header("location:../index.php");
}

$query = "select * from students where student_id='" . $_SESSION['student_id'] . "' ";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);

$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);

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

$faculty_data = mysqli_query($con, $sql);
$faculty = mysqli_fetch_assoc($faculty_data);

function print_courses(mysqli_result $result, string $title) : void {
    global $html;
    $html .= "<h3 class='table-title' style='margin-top: 2em'>{$title}</h3>";
    if(mysqli_num_rows($result) > 0){
        $html .= "
            <table class='bordered-table' style='margin-top: 5em'>
            <tr>
                <th>Course</th> 
                <th style='padding-left: 2em'>Course title</th>
                <th>Credits</th>
                <th style='padding-left: 2em'>Grade</th>
            </tr>
        ";
        while( $courses_data= mysqli_fetch_assoc($result)){
            $grade = grade_details($courses_data['grade']);
            $html .= "
                <tr>
                    <td>{$courses_data['course_id']}</td> 
                    <td style='padding-left: 2em'>{$courses_data['course_name']}</td>
                    <td class='credits'>{$courses_data['credits']}</td>
                    <td style='padding-left: 2em' class='grade'>{$grade}</td>
                </tr>";
        }
        // $html .= "</table>";
        $html .= "
            </table>
            ";
    }
    else {
        $html .= "   
            <p style='color: crimson;'>No courses registered</p> 
        ";
    }

}

function grade_details($grade)
{
    switch ($grade) {
        case 0:
            return '';
            break;
        case $grade >= 0 && $grade < 50:
            return 'F';
            break;
        case $grade >= 50 && $grade < 58:
            return 'D';
            break;
        case $grade >= 58 && $grade < 66:
            return 'C';
            break;
        case $grade >= 66 && $grade < 74:
            return 'C+';
            break;
        case $grade >= 74 && $grade < 82:
            return 'B';
            break;
        case $grade >= 82 && $grade < 90:
            return 'B+';
            break;
        case $grade >= 90 && $grade <= 100:
            return 'A';
            break;
    }
}
function get_points($grade)
{
    switch ($grade) {
        case 'A':
            return 4;
            break;
        case 'B+':
            return 3.5;
            break;
        case 'B':
            return 3;
            break;
        case 'C+':
            return 2.5;
            break;
        case 'C':
            return 2;
            break;
        case 'D':
            return 1.5;
            break;
        case 'F':
            return 0;
            break;
    }
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
        .grade{
            margin-left: 2em;
        }
        th{
            text-align: left;
        }
        td.grade{
            margin: 1.25em;
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
            <th>Stundent ID</th> <td colspan='4'>" . $data['student_id'] . "</td>
            <th>Branch</th> <td>" .  ucwords($faculty['branch']) . "</td>
        </tr>
        <tr>
            <th>Student Name</th> <td colspan='4'>" . ucwords($data['s_name']) . "</td>
            <th>Birth Date</th> <td>" . date('M d, Y', strtotime($data['birth_date'])) . "</td>
        </tr>
        <tr>
           
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



$student_courses_result = mysqli_query($con, $get_all_student_courses);

// if (mysqli_num_rows($student_courses_result) > 0) {

//     $html .= "
//     <table style='margin-top: 5em'>
//         <tr>
//             <th>Course</th> 
//             <th>Course title</th>
//             <th>Credits</th>
//             <th>Grade</th>
//             <th>Points</th>
//         </tr>
//     ";

//     while ($courses_data = mysqli_fetch_assoc($student_courses_result)) {
//         $grade = grade_details($courses_data['grade']);
//         $points = "";
//         if ($grade) {
//             $points = get_points($grade) * $courses_data['credits'];
//         }
//         $html .= "
//         <tr>
//             <td>{$courses_data['course_id']}</td> 
//             <td>{$courses_data['course_name']}</td>
//             <td>{$courses_data['credits']}</td>
//             <td>{$grade}</td>
//             <td>{$points}</td>
//         </tr>";
//     }
//     $html .= "</table>";
// } else {
//     $html .= "   
//         <p style='color: crimson'>No courses registered</p> 
//     ";
// }
// $html .= "

// <br><br><br><br>
// <div class='footer'>
//     <div class='signature'>
//         <p>
//             Deanship of admission & Students Affairs<br>
//                     <p class='deanship'>Name here</p>
//         </p>
//     </div>
//     <div class='stamp'>
//         <p>Stamp</p>
//     </div>
// </div>
// ";

print_courses($student_courses_result, 'Unoffical Transcript');

// echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
