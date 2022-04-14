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

$faculty_data = mysqli_query($con, $sql);
$faculty = mysqli_fetch_assoc($faculty_data);

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
$registered_hours['SUM(credits)'] = $registered_hours['SUM(credits)'] > 0 ? $registered_hours['SUM(credits)'] : 0;

$get_all_student_courses = "
        SELECT  
            enrolled.absences, courses.*, sections.*, sections.id as section_id, courses.course_id as course_id, courses_time.time, teachers.teacher_name
        FROM 
            enrolled
            JOIN sections ON enrolled.section_id = sections.id
            JOIN courses ON sections.course_id = courses.id
            JOIN courses_time ON courses_time.id = sections.time_id
            JOIN teachers ON teachers.id = sections.tutor_id
        WHERE 
            enrolled.student_id = '$std_id'";

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
            margin-top: -5.0em;
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
            <th>Academic Status</th> <td colspan='3'>" . ($data['status'] == '1' ? 'Active' : 'Not active') . "</td>
            <th>Branch</th> <td colspan='1'>" . ucwords($faculty['branch']) . "</td>
        </tr>
        <tr>
            <th>Registered Hours</th> <td colspan='5'>" . $registered_hours['SUM(credits)'] . " hrs </td>
        </tr>
";


$html .= "</table>";
$student_courses_result = mysqli_query($con, $get_all_student_courses);
if (mysqli_num_rows($student_courses_result) > 0) {
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
        </tr>";

    $counter = 0;
    while ($courses_data = mysqli_fetch_assoc($student_courses_result)) {
        $day_and_times = explode(' ', $courses_data['time']);
        $days = array();
        $times = array();

        // split time and day from string
        foreach ($day_and_times as $day_and_time) {
            if (DateTime::createFromFormat('H:i', $day_and_time) !== false) {
                array_push($times, $day_and_time);
            } else {
                array_push($days, $day_and_time);
            }
        }
        $lecture_or_lab = "lecture_type";
        foreach ($times as $index => $time) {
            $counter++;
            $time_oo = strtotime($time);
            $time_format = date('h:i A', strtotime($time));
            $time_format = $time_format . " - " . date('h:i A', strtotime('+50 minutes', $time_oo));

            $html .= "
            <tr>
                <td>{$counter}</td>
                <td>{$courses_data['id']}</td>
                <td>{$courses_data['course_id']}</td>
                <td style='width: 22%'>{$courses_data['course_name']}</td>
                <td style='width: 22%'>{$time_format}</td>
                <td>{$courses_data['room']}</td>
                <td>$days[$index]</td>
                <td>{$courses_data[$lecture_or_lab]}</td>
            </tr>
        ";
            if ($lecture_or_lab == "lecture_type") {
                $lecture_or_lab = "lab_type";
            } else {
                $lecture_or_lab = "lecture_type";
            }
        }

        // print_r($times);

    }
    $html .= "
    </table> 
";
}
$html .= "   
    <p></p>
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
